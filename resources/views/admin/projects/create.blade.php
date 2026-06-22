@extends('layouts.admin')

@section('title', 'Nuevo Proyecto')
@section('page_title', 'Agregar Nuevo Proyecto')

@section('content')

<div class="admin-card glass" style="max-width: 800px;">
    <div class="admin-card-title">Detalles del Proyecto</div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="title" class="form-label">Título del Proyecto *</label>
                <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" placeholder="Ej. Dashboard de Microservicios Cloud" required>
            </div>
            
            <div class="form-group">
                <label for="order" class="form-label">Orden de Prioridad *</label>
                <input type="number" name="order" id="order" class="form-input" value="{{ old('order', 0) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Descripción del Proyecto *</label>
            <textarea name="description" id="description" class="form-input" style="min-height: 150px;" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="tech_stack" class="form-label">Tecnologías / Stack Técnico (Separados por Coma) *</label>
            <input type="text" name="tech_stack" id="tech_stack" class="form-input" value="{{ old('tech_stack') }}" placeholder="Ej. Laravel, Docker, Kubernetes, AWS, Vue.js" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="project_url" class="form-label">URL del Proyecto En Vivo (Opcional)</label>
                <input type="url" name="project_url" id="project_url" class="form-input" value="{{ old('project_url') }}" placeholder="https://proyecto.com">
            </div>
            
            <div class="form-group">
                <label for="github_url" class="form-label">URL del Repositorio de GitHub (Opcional)</label>
                <input type="url" name="github_url" id="github_url" class="form-input" value="{{ old('github_url') }}" placeholder="https://github.com/usuario/repositorio">
            </div>
        </div>

        <div class="form-group" style="margin-top: 1.5rem;">
            <label for="image" class="form-label">Imagen de Portada (Miniatura)</label>
            <input type="file" name="image" id="image" class="form-input" style="padding: 0.5rem;" accept="image/*">
            <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">Formatos: PNG, JPG, WebP. Máx. 4MB</span>
        </div>

        <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.projects.index') }}" class="btn-action-text" style="display: flex; align-items: center; justify-content: center;">
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                Crear Proyecto
            </button>
        </div>
    </form>
</div>

@endsection
