@extends('layouts.admin')

@section('title', 'Editar Proyecto')
@section('page_title', 'Editar Proyecto')

@section('content')

<style>
    .project-form-container {
        max-width: 800px;
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .current-image-preview {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        aspect-ratio: 16/9;
        background: #0a0a0f;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .current-image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .current-image-preview:hover {
        border-color: var(--border-hover);
    }

    .current-image-preview .preview-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.75));
        padding: 1.5rem 1rem 0.6rem;
        text-align: center;
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.8);
    }

    .no-image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        color: var(--text-muted);
    }

    .no-image-placeholder i {
        font-size: 2rem;
        opacity: 0.4;
    }

    .no-image-placeholder span {
        font-size: 0.82rem;
        font-weight: 300;
    }

    .file-upload-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .custom-file-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.1rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: #ffffff;
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-file-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--border-hover);
        transform: translateY(-1px);
    }

    .file-name-text {
        font-size: 0.82rem;
        color: var(--text-muted);
        font-weight: 300;
    }

    .urls-section {
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 14px;
    }

    .project-header-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        background: rgba(255, 255, 255, 0.015);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        margin-bottom: 1.5rem;
    }

    .project-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-magenta) 50%, var(--insta-orange) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #ffffff;
        flex-shrink: 0;
    }

    .project-header-text h3 {
        font-size: 1.05rem;
        font-weight: 600;
        color: #ffffff;
        margin: 0 0 0.2rem 0;
    }

    .project-header-text span {
        font-size: 0.78rem;
        color: var(--text-muted);
        font-weight: 300;
    }
</style>

<div class="project-form-container">

    <!-- Project Header Banner -->
    <div class="project-header-info">
        <div class="project-header-icon">
            <i class="fa-solid fa-pen-ruler"></i>
        </div>
        <div class="project-header-text">
            <h3>{{ $project->title }}</h3>
            <span>Editando proyecto · Creado {{ $project->created_at->diffForHumans() }}</span>
        </div>
    </div>

    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Main Details Card -->
        <div class="admin-card">
            <div class="admin-card-title">
                <i class="fa-solid fa-diagram-project"></i>
                Información del Proyecto
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="title" class="form-label">Título del Proyecto *</label>
                    <input type="text" name="title" id="title" class="form-input" value="{{ old('title', $project->title) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="order" class="form-label">Orden de Prioridad *</label>
                    <input type="number" name="order" id="order" class="form-input" value="{{ old('order', $project->order) }}" required>
                    <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.35rem;">Menor número = mayor prioridad</span>
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Descripción del Proyecto *</label>
                <textarea name="description" id="description" class="form-input" style="min-height: 140px; resize: vertical; line-height: 1.7;" required>{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="tech_stack" class="form-label">Tecnologías / Stack Técnico (Separados por Coma) *</label>
                <input type="text" name="tech_stack" id="tech_stack" class="form-input" value="{{ old('tech_stack', $project->tech_stack) }}" required>
                <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.35rem;">
                    Las tecnologías aparecerán como etiquetas en tu portafolio. Separa cada tecnología con una coma.
                </span>
            </div>
        </div>

        <!-- Development Process & Features Card -->
        <div class="admin-card" style="margin-top: 1.5rem;">
            <div class="admin-card-title">
                <i class="fa-solid fa-list-check"></i>
                Pasos de Desarrollo & Características
            </div>

            <div class="form-group">
                <label for="steps" class="form-label">Pasos / Proceso de Desarrollo (Un paso por línea)</label>
                <textarea name="steps" id="steps" class="form-input" style="min-height: 120px; resize: vertical; line-height: 1.7;" placeholder="Paso 1: Análisis de requerimientos y diseño de arquitectura
Paso 2: Modelado de base de datos en PostgreSQL
Paso 3: Desarrollo de APIs RESTful con Laravel
Paso 4: Contenerización con Docker y despliegue en AWS EKS">{{ old('steps', $project->steps) }}</textarea>
                <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.35rem;">
                    Escribe cada paso en una nueva línea para mostrar el proceso paso a paso en la vista de detalles.
                </span>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="features" class="form-label">Características & Funcionalidades Destacadas (Una por línea)</label>
                <textarea name="features" id="features" class="form-input" style="min-height: 120px; resize: vertical; line-height: 1.7;" placeholder="Arquitectura Eficiente: Diseño modular con alta escalabilidad
Alto Rendimiento: Procesamiento concurrente y caché distribuida
Seguridad Avanzada: Autenticación OAuth2 y cifrado de datos">{{ old('features', $project->features) }}</textarea>
                <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.35rem;">
                    Escribe cada característica en una nueva línea.
                </span>
            </div>
        </div>

        <!-- URLs Card -->
        <div class="admin-card" style="margin-top: 1.5rem;">
            <div class="admin-card-title">
                <i class="fa-solid fa-link"></i>
                Enlaces del Proyecto
            </div>

            <div class="urls-section">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="project_url" class="form-label">
                            <i class="fa-solid fa-globe" style="color: #10b981; margin-right: 0.35rem;"></i>
                            URL del Proyecto En Vivo
                        </label>
                        <input type="url" name="project_url" id="project_url" class="form-input" value="{{ old('project_url', $project->project_url) }}">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="github_url" class="form-label">
                            <i class="fa-brands fa-github" style="color: #a78bfa; margin-right: 0.35rem;"></i>
                            Repositorio de GitHub
                        </label>
                        <input type="url" name="github_url" id="github_url" class="form-input" value="{{ old('github_url', $project->github_url) }}">
                    </div>
                </div>
            </div>

            <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.75rem; line-height: 1.4;">
                Ambos campos son opcionales. Si agregas URLs, aparecerán como botones interactivos en la tarjeta del proyecto.
            </span>
        </div>

        <!-- Image Card -->
        <div class="admin-card" style="margin-top: 1.5rem;">
            <div class="admin-card-title">
                <i class="fa-solid fa-image"></i>
                Imagen de Portada
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start;">
                <!-- Current Image Preview -->
                <div>
                    <label class="form-label" style="margin-bottom: 0.75rem; display: block;">Imagen Actual</label>
                    <div class="current-image-preview">
                        @if ($project->image_path)
                            <img id="edit-preview-img" src="{{ asset($project->image_path) }}" alt="{{ $project->title }}">
                            <div class="preview-label">Vista Previa</div>
                        @else
                            <div class="no-image-placeholder">
                                <i class="fa-solid fa-image"></i>
                                <span>Sin imagen asignada</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Upload New Image -->
                <div>
                    <label class="form-label" style="margin-bottom: 0.75rem; display: block;">Cambiar Imagen</label>
                    
                    <div style="background: rgba(255, 255, 255, 0.01); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 14px; padding: 1.5rem; display: flex; flex-direction: column; align-items: center; gap: 1rem; min-height: 100px; justify-content: center;">
                        <label for="image" class="custom-file-btn">
                            <input type="file" name="image" id="image" accept="image/*" style="display: none;" onchange="handleEditFileSelect(this)">
                            <i class="fa-solid fa-upload"></i>
                            Seleccionar Imagen
                        </label>
                        <span class="file-name-text" id="edit-file-name">Sin archivo seleccionado</span>
                    </div>

                    <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.75rem; line-height: 1.4;">
                        Formatos: PNG, JPG, WebP • Máximo 4MB. La imagen anterior se reemplazará.
                    </span>
                </div>
            </div>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.78rem; color: var(--text-muted); line-height: 1.4;">
                    Los cambios se reflejarán en tu portafolio inmediatamente.
                </span>
                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('admin.projects.index') }}" class="btn-action" style="padding: 0.85rem 1.5rem; border-radius: 12px; width: auto; height: auto; font-size: 0.9rem;">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function handleEditFileSelect(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            const fileNameDisplay = document.getElementById('edit-file-name');
            if (fileNameDisplay) fileNameDisplay.textContent = fileName;

            // Also update the preview image if exists
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('edit-preview-img');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    // If there was no existing image, create a preview
                    const container = document.querySelector('.current-image-preview');
                    if (container) {
                        container.innerHTML = `
                            <img id="edit-preview-img" src="${e.target.result}" alt="Nueva imagen" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="preview-label">Nueva Imagen</div>
                        `;
                    }
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
