@extends('layouts.admin')

@section('title', 'Nuevo Proyecto')
@section('page_title', 'Agregar Nuevo Proyecto')

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

    .image-upload-zone {
        position: relative;
        border: 2px dashed var(--border-color);
        border-radius: 14px;
        padding: 2.5rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        background: rgba(255, 255, 255, 0.01);
    }

    .image-upload-zone:hover {
        border-color: var(--border-hover);
        background: rgba(255, 255, 255, 0.03);
    }

    .image-upload-zone.has-preview {
        padding: 0;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .image-upload-zone .upload-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.4rem;
        color: var(--text-muted);
        transition: all 0.3s ease;
    }

    .image-upload-zone:hover .upload-icon {
        border-color: var(--border-hover);
        color: var(--text-secondary);
        transform: translateY(-2px);
    }

    .image-upload-zone .upload-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.35rem;
    }

    .image-upload-zone .upload-hint {
        font-size: 0.78rem;
        color: var(--text-muted);
        font-weight: 300;
    }

    .image-upload-zone #create-preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }

    .image-upload-zone .preview-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        color: #ffffff;
        gap: 0.5rem;
    }

    .image-upload-zone.has-preview:hover .preview-overlay {
        opacity: 1;
    }

    .urls-section {
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 14px;
    }

    .urls-section-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.25rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #ffffff;
    }

    .urls-section-title i {
        color: var(--insta-blue);
    }
</style>

<div class="project-form-container">
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Main Details Card -->
        <div class="admin-card">
            <div class="admin-card-title">
                <i class="fa-solid fa-diagram-project"></i>
                Información del Proyecto
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="title" class="form-label">Título del Proyecto *</label>
                    <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" placeholder="Ej. Dashboard de Microservicios Cloud" required>
                </div>
                
                <div class="form-group">
                    <label for="order" class="form-label">Orden de Prioridad *</label>
                    <input type="number" name="order" id="order" class="form-input" value="{{ old('order', 0) }}" required>
                    <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.35rem;">Menor número = mayor prioridad</span>
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Descripción del Proyecto *</label>
                <textarea name="description" id="description" class="form-input" style="min-height: 140px; resize: vertical; line-height: 1.7;" placeholder="Describe las funcionalidades principales, el problema que resuelve y el impacto del proyecto..." required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="tech_stack" class="form-label">Tecnologías / Stack Técnico (Separados por Coma) *</label>
                <input type="text" name="tech_stack" id="tech_stack" class="form-input" value="{{ old('tech_stack') }}" placeholder="Ej. Laravel, Docker, Kubernetes, AWS, Vue.js" required>
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
Paso 4: Contenerización con Docker y despliegue en AWS EKS">{{ old('steps') }}</textarea>
                <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.35rem;">
                    Escribe cada paso en una nueva línea para generar la línea de tiempo del proceso de desarrollo.
                </span>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="features" class="form-label">Características & Funcionalidades Destacadas (Una por línea)</label>
                <textarea name="features" id="features" class="form-input" style="min-height: 120px; resize: vertical; line-height: 1.7;" placeholder="Arquitectura Eficiente: Diseño modular con alta escalabilidad
Alto Rendimiento: Procesamiento concurrente y caché distribuida
Seguridad Avanzada: Autenticación OAuth2 y cifrado de datos">{{ old('features') }}</textarea>
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
                        <input type="url" name="project_url" id="project_url" class="form-input" value="{{ old('project_url') }}" placeholder="https://proyecto.com">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="github_url" class="form-label">
                            <i class="fa-brands fa-github" style="color: #a78bfa; margin-right: 0.35rem;"></i>
                            Repositorio de GitHub
                        </label>
                        <input type="url" name="github_url" id="github_url" class="form-input" value="{{ old('github_url') }}" placeholder="https://github.com/usuario/repo">
                    </div>
                </div>
            </div>
            
            <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.75rem; line-height: 1.4;">
                Ambos campos son opcionales. Si agregas URLs, aparecerán como botones interactivos en la tarjeta del proyecto.
            </span>
        </div>

        <!-- Image Upload Card -->
        <div class="admin-card" style="margin-top: 1.5rem;">
            <div class="admin-card-title">
                <i class="fa-solid fa-image"></i>
                Imagen de Portada
            </div>

            <label for="image" class="image-upload-zone" id="createUploadZone">
                <input type="file" name="image" id="image" accept="image/*" style="display: none;" onchange="handleCreateImagePreview(this)">
                
                <div id="create-upload-content">
                    <div class="upload-icon">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <div class="upload-title">Arrastra tu imagen aquí o haz clic para seleccionar</div>
                    <div class="upload-hint">Formatos: PNG, JPG, WebP • Máximo 4MB</div>
                </div>
                
                <img id="create-preview-img" alt="Vista previa">
                <div class="preview-overlay">
                    <i class="fa-solid fa-camera" style="font-size: 1.5rem;"></i>
                    <span style="font-size: 0.85rem; font-weight: 500;">Cambiar imagen</span>
                </div>
            </label>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('admin.projects.index') }}" class="btn-action" style="padding: 0.85rem 1.5rem; border-radius: 12px; width: auto; height: auto; font-size: 0.9rem;">
                    Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Crear Proyecto
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function handleCreateImagePreview(input) {
        if (input.files && input.files[0]) {
            const zone = document.getElementById('createUploadZone');
            const preview = document.getElementById('create-preview-img');
            const content = document.getElementById('create-upload-content');
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                content.style.display = 'none';
                zone.classList.add('has-preview');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
