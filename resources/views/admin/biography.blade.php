@extends('layouts.admin')

@section('title', 'Gestionar Biografía')
@section('page_title', 'Gestionar Biografía')

@section('content')

<style>
    .bio-editor-container {
        max-width: 800px;
        margin: 0 auto;
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bg-thumb-card {
        position: relative;
        aspect-ratio: 16 / 10;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.01);
        transition: all 0.3s ease;
    }

    .bg-thumb-card:hover {
        border-color: rgba(239, 68, 68, 0.5);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.15);
    }

    .bg-thumb-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .bg-delete-btn {
        position: absolute;
        inset: 0;
        background: rgba(239, 68, 68, 0.85);
        border: none;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        font-size: 1.25rem;
    }

    .bg-thumb-card:hover .bg-delete-btn {
        opacity: 1;
    }

    .file-input-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .custom-file-upload {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.85rem 1.25rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        width: fit-content;
    }

    .custom-file-upload:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--border-hover);
    }

    .file-name-display {
        font-size: 0.85rem;
        color: var(--text-secondary);
        font-weight: 300;
    }
</style>

<div class="bio-editor-container">
    <form action="{{ route('admin.biography.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Keep other bio columns safe as hidden inputs -->
        <input type="hidden" name="bio_tag" value="{{ $profile->bio_tag }}">
        <input type="hidden" name="workspace_title" value="{{ $profile->workspace_title }}">
        <input type="hidden" name="workspace_desc" value="{{ $profile->workspace_desc }}">
        <input type="hidden" name="tech_title" value="{{ $profile->tech_title }}">
        <input type="hidden" name="tech_desc" value="{{ $profile->tech_desc }}">

        <div class="admin-card">
            <div class="admin-card-title">
                <i class="fa-solid fa-user-astronaut"></i>
                Editar Texto de Biografía
            </div>

            <div class="form-group">
                <label for="bio_title" class="form-label">Texto Gigante de Fondo (Outline) *</label>
                <input 
                    type="text" 
                    name="bio_title" 
                    id="bio_title" 
                    class="form-input" 
                    value="{{ old('bio_title', $profile->bio_title ?? 'YO') }}" 
                    placeholder="ej. YO" 
                    required
                >
                <span style="font-size: 0.78rem; color: var(--text-muted); display: block; margin-top: 0.4rem;">La palabra gigante delineada en el fondo de esta sección (ej. YO, BIO, SOY, etc.)</span>
            </div>

            <div class="form-group">
                <label for="bio_description" class="form-label">Cuerpo de la Biografía *</label>
                <textarea 
                    name="bio_description" 
                    id="bio_description" 
                    class="form-input" 
                    style="min-height: 180px; resize: vertical; line-height: 1.7;" 
                    placeholder="Escribe aquí tu biografía detallada tal como aparece en el sitio web..."
                    required
                >{{ old('bio_description', $profile->bio_description) }}</textarea>
            </div>
        </div>

        <div class="admin-card" style="margin-top: 1.5rem;">
            <div class="admin-card-title">
                <i class="fa-solid fa-images"></i>
                Fondos de la Sección de Biografía
            </div>

            <!-- Upload new backgrounds -->
            <div class="form-group">
                <label class="form-label">Subir Nuevas Imágenes de Fondo (Multiselección)</label>
                <div class="file-input-wrapper">
                    <label class="custom-file-upload">
                        <input 
                            type="file" 
                            name="bio_backgrounds[]" 
                            id="bio_backgrounds" 
                            accept="image/*" 
                            multiple 
                            style="display: none;"
                            onchange="handleBackgroundsUpload(this)"
                        >
                        <i class="fa-solid fa-cloud-arrow-up"></i> Seleccionar Imágenes
                    </label>
                    <span class="file-name-display" id="bg-file-count">Sin archivos seleccionados</span>
                </div>
                <span style="font-size: 0.78rem; color: var(--text-muted); display: block; margin-top: 0.5rem; line-height: 1.5;">
                    Formatos admitidos: PNG, JPG, WebP. Puedes seleccionar y subir múltiples fondos que rotarán automáticamente.
                </span>
            </div>

            <!-- Existing backgrounds list -->
            <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <label class="form-label" style="margin-bottom: 0.85rem; display: block;">Imágenes de Fondo Actuales</label>
                
                @if (empty($profile->bio_backgrounds) || count($profile->bio_backgrounds) == 0)
                    <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0; padding: 1.25rem; background: rgba(255,255,255,0.01); border: 1px solid var(--border-color); border-radius: 12px; text-align: center;">
                        No hay fondos cargados aún. Se usará la foto del hero por defecto.
                    </p>
                @else
                    <div id="bio-bg-gallery" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 1rem;">
                        @foreach ($profile->bio_backgrounds as $index => $bg)
                            <div class="bg-thumb-card" id="bg-thumb-{{ $index }}">
                                <img src="{{ asset($bg) }}" alt="Biography Background">
                                <button type="button" class="bg-delete-btn" onclick="markBackgroundForDeletion('{{ $bg }}', {{ $index }})" title="Eliminar este fondo">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Hidden input container for deleted backgrounds -->
            <div id="deleted-backgrounds-container"></div>

            <div style="margin-top: 2.5rem; padding-top: 1.8rem; border-top: 1px solid var(--border-color); text-align: right; display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('admin.dashboard') }}" class="btn-action" style="padding: 0.85rem 1.5rem; border-radius: 12px;">
                    Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
