@extends('layouts.admin')

@section('title', 'Editar Proyecto')
@section('page_title', 'Editar Proyecto')

@section('content')

<div class="admin-card glass" style="max-width: 800px;">
    <div class="admin-card-title">Detalles del Proyecto: {{ $project->title }}</div>

    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="title" class="form-label">Título del Proyecto *</label>
                <input type="text" name="title" id="title" class="form-input" value="{{ old('title', $project->title) }}" required>
            </div>
            
            <div class="form-group">
                <label for="order" class="form-label">Orden de Prioridad *</label>
                <input type="number" name="order" id="order" class="form-input" value="{{ old('order', $project->order) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Descripción del Proyecto *</label>
            <textarea name="description" id="description" class="form-input" style="min-height: 150px;" required>{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="tech_stack" class="form-label">Tecnologías / Stack Técnico (Separados por Coma) *</label>
            <input type="text" name="tech_stack" id="tech_stack" class="form-input" value="{{ old('tech_stack', $project->tech_stack) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="project_url" class="form-label">URL del Proyecto En Vivo (Opcional)</label>
                <input type="url" name="project_url" id="project_url" class="form-input" value="{{ old('project_url', $project->project_url) }}">
            </div>
            
            <div class="form-group">
                <label for="github_url" class="form-label">URL del Repositorio de GitHub (Opcional)</label>
                <input type="url" name="github_url" id="github_url" class="form-input" value="{{ old('github_url', $project->github_url) }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 1.5rem; align-items: center;">
            <div class="form-group">
                <label for="image" class="form-label">Cambiar Imagen de Portada</label>
                <input type="file" name="image" id="image" class="form-input" style="padding: 0.5rem;" accept="image/*">
                <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">Formatos: PNG, JPG, WebP. Máx. 4MB</span>
            </div>
            
            <div>
                <span class="form-label">Imagen Actual</span>
                <div style="width: 150px; height: 90px; border-radius: 8px; overflow: hidden; background: #000; border: 1px solid var(--border-color);">
                    @if ($project->image_path)
                        <img src="{{ asset($project->image_path) }}" alt="Miniatura actual" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 0.9rem;">
                            Sin imagen
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.projects.index') }}" class="btn-action-text" style="display: flex; align-items: center; justify-content: center;">
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

@endsection
