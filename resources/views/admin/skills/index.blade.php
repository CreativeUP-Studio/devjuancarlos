@extends('layouts.admin')

@section('title', 'Gestionar Habilidades')
@section('page_title', 'Gestionar Habilidades')

@section('content')

<style>
    .skills-editor-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tech-grid-icon-preview {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 1.6rem;
    }
</style>

<div class="skills-editor-container">
    
    @if ($errors->any())
        <div class="alert-modern alert-error" style="margin-bottom: 1.5rem; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 12px; padding: 1.25rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #ef4444; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.95rem;">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Errores al guardar cambios:</span>
            </div>
            <ul style="margin: 0; padding-left: 1.25rem; color: var(--text-secondary); font-size: 0.88rem; line-height: 1.5;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 1. EDIT UNCP LEARNING PARAGRAPH -->
    <form action="{{ route('admin.skills.update-text') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="admin-card">
            <div class="admin-card-title">
                <i class="fa-solid fa-graduation-cap"></i>
                Sección Habilidades (Texto y Fondo)
            </div>

            <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem; margin-bottom: 1.5rem;">
                <!-- Column 1: Text -->
                <div class="form-group" style="margin-bottom: 0; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <label for="tech_desc" class="form-label">Cuerpo del Texto *</label>
                        <textarea 
                            name="tech_desc" 
                            id="tech_desc" 
                            class="form-input" 
                            style="min-height: 180px; resize: vertical; line-height: 1.7;" 
                            placeholder="Escribe lo que aprendiste en la UNCP tal como se muestra en la sección de habilidades..."
                            required
                        >{{ old('tech_desc', $profile->tech_desc) }}</textarea>
                    </div>
                </div>

                <!-- Column 2: Background Image -->
                <div style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Imagen de Fondo de la Sección</label>
                        
                        <!-- Thumbnail Preview -->
                        <div style="position: relative; border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color); aspect-ratio: 16/9; background: #15151e; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            @if($profile && $profile->tech_image)
                                <img id="tech_image_preview" src="{{ asset($profile->tech_image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img id="tech_image_preview" src="{{ asset('images/nav_habilidades.png') }}" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.5;">
                            @endif
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); padding: 0.4rem; text-align: center; font-size: 0.75rem; color: #fff;">
                                Vista Previa
                            </div>
                        </div>

                        <!-- Upload & Delete Buttons -->
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <label for="tech_image_input" class="btn-action-text btn-primary-action" style="cursor: pointer; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; padding: 0.6rem 1rem; font-size: 0.85rem; flex: 1; text-align: center; border: 1px solid var(--border-color);">
                                <i class="fa-solid fa-upload" style="margin-right: 0.4rem;"></i>
                                Subir Imagen
                            </label>
                            <input type="file" name="tech_image" id="tech_image_input" accept="image/*" style="display: none;" onchange="previewImage(this)">

                            @if($profile && $profile->tech_image)
                                <label style="display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; cursor: pointer; color: var(--danger-color); font-size: 0.85rem; padding: 0.6rem;">
                                    <input type="checkbox" name="delete_tech_image" value="1" style="cursor: pointer;">
                                    Eliminar
                                </label>
                            @endif
                        </div>
                        <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.5rem;">
                            Recomendado: 1920x1080px (JPG/PNG/WebP, max 10MB).
                        </span>an>
                    </div>
                </div>
            </div>

            <!-- Footer Row inside card -->
            <div style="border-top: 1px solid var(--border-color); padding-top: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.78rem; color: var(--text-muted); line-height: 1.4;">
                    Este párrafo y fondo se muestran en la sección Habilidades de tu portafolio.
                </span>
                <button type="submit" class="btn-primary" style="padding: 0.75rem 1.8rem; border-radius: 10px; font-weight: 600;">
                    <i class="fa-solid fa-floppy-disk" style="margin-right: 0.4rem;"></i>
                    Guardar Cambios
                </button>
            </div>
        </div>
    </form>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('tech_image_preview');
                    preview.src = e.target.result;
                    preview.style.opacity = 1;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- 2. MANAGE SKILLS LOGOS (CRUD TABLE) -->
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.8rem;">
            <div class="admin-card-title" style="margin-bottom: 0;">
                <i class="fa-solid fa-code"></i>
                Tecnologías & Logos del Portafolio
            </div>
            
            <a href="{{ route('admin.skills.create') }}" class="btn-action-text btn-primary-action" style="border-radius: 10px; padding: 0.75rem 1.2rem;">
                <i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i>
                Nueva Tecnología
            </a>
        </div>

        <p style="font-size: 0.88rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 1.5rem;">
            Administra las tecnologías y herramientas que aparecen en la grilla del sitio. Usa clases de <strong>Devicon</strong> (ej: <code>devicon-python-plain</code>) para mostrar sus logotipos oficiales con sus colores originales en el sitio web.
        </p>

        @if ($skills->isEmpty())
            <div style="text-align: center; padding: 4rem 0; color: var(--text-muted); border: 1px dashed var(--border-color); border-radius: 14px;">
                <div style="font-size: 3rem; margin-bottom: 1.25rem; opacity: 0.4;"><i class="fa-solid fa-layer-group"></i></div>
                <p style="font-weight: 300;">No hay tecnologías registradas. Añade una para empezar a poblar la grilla.</p>
            </div>
        @else
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 70px; text-align: center;">Logo</th>
                            <th>Nombre</th>
                            <th>Clase de Icono (Devicon)</th>
                            <th style="width: 90px; text-align: center;">Orden</th>
                            <th style="width: 100px; text-align: center;">Estado</th>
                            <th style="width: 180px; text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($skills as $skill)
                            <tr>
                                <td>
                                    <div style="display: flex; justify-content: center; align-items: center;">
                                        <div class="tech-grid-icon-preview">
                                            @if ($skill->icon_class)
                                                <i class="{{ $skill->icon_class }} colored"></i>
                                            @else
                                                <i class="fa-solid fa-code" style="color: var(--text-muted);"></i>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td style="font-weight: 600; vertical-align: middle;">
                                    {{ $skill->name }}
                                </td>
                                <td style="vertical-align: middle; font-family: monospace; color: var(--text-secondary); font-size: 0.85rem;">
                                    {{ $skill->icon_class ?? 'N/A' }}
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skill->order }}
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    @if ($skill->is_visible)
                                        <span class="badge" style="background: rgba(46, 204, 113, 0.15); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.3);">Visible</span>
                                    @else
                                        <span class="badge" style="background: rgba(127, 140, 141, 0.15); color: #95a5a6; border: 1px solid rgba(127, 140, 141, 0.3);">Oculto</span>
                                    @endif
                                </td>
                                <td style="text-align: right; vertical-align: middle;">
                                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                        <form action="{{ route('admin.skills.toggle-visibility', $skill) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-action" title="{{ $skill->is_visible ? 'Ocultar en el Portafolio' : 'Mostrar en el Portafolio' }}">
                                                <i class="fa-solid {{ $skill->is_visible ? 'fa-eye' : 'fa-eye-slash' }}" style="color: {{ $skill->is_visible ? 'var(--text-secondary)' : 'var(--insta-orange)' }}"></i>
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.skills.edit', $skill) }}" class="btn-action" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta tecnología?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('tech_image_preview');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.opacity = '1';
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
