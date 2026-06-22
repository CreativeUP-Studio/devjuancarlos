@extends('layouts.admin')

@section('title', 'Nuevo Viaje')
@section('page_title', 'Agregar Nuevo Viaje')

@section('content')

<div class="admin-card glass" style="max-width: 800px;">
    <div class="admin-card-title">Detalles de la Bitácora de Viaje</div>

    <form action="{{ route('admin.travels.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="title" class="form-label">Destino / Título *</label>
                <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" placeholder="Ej. Machu Picchu" required>
            </div>
            
            <div class="form-group">
                <label for="order" class="form-label">Orden de Prioridad *</label>
                <input type="number" name="order" id="order" class="form-input" value="{{ old('order', 0) }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="badge" class="form-label">Etiqueta (Badge) *</label>
                <input type="text" name="badge" id="badge" class="form-input" value="{{ old('badge') }}" placeholder="Ej. Perú · 2025" required>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Descripción de la Experiencia *</label>
            <textarea name="description" id="description" class="form-input" style="min-height: 120px;" required>{{ old('description') }}</textarea>
        </div>

        <div style="background: rgba(255, 255, 255, 0.01); border: 1px solid rgba(255, 255, 255, 0.05); padding: 1.25rem; border-radius: 12px; margin-bottom: 1.5rem;">
            <h4 style="margin: 0 0 1rem 0; font-size: 0.95rem; color: #ffffff;"><i class="fa-solid fa-tags" style="color: var(--accent-cyan); margin-right: 0.5rem;"></i> Características / Metadatos del Viaje</h4>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="meta_1_icon" class="form-label">Clase de Icono 1 (FontAwesome)</label>
                    <input type="text" name="meta_1_icon" id="meta_1_icon" class="form-input" value="{{ old('meta_1_icon', 'fa-solid fa-plane-departure') }}" placeholder="Ej. fa-solid fa-plane-departure">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="meta_1_text" class="form-label">Texto Característica 1</label>
                    <input type="text" name="meta_1_text" id="meta_1_text" class="form-input" value="{{ old('meta_1_text') }}" placeholder="Ej. Aventura">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="meta_2_icon" class="form-label">Clase de Icono 2 (FontAwesome)</label>
                    <input type="text" name="meta_2_icon" id="meta_2_icon" class="form-input" value="{{ old('meta_2_icon', 'fa-solid fa-camera') }}" placeholder="Ej. fa-solid fa-camera">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="meta_2_text" class="form-label">Texto Característica 2</label>
                    <input type="text" name="meta_2_text" id="meta_2_text" class="form-input" value="{{ old('meta_2_text') }}" placeholder="Ej. Fotografía">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">Imagen del Destino</label>
            <input type="file" name="image" id="image" class="form-input" style="padding: 0.5rem;" accept="image/*">
            <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">Formatos: PNG, JPG, WebP. Máx. 4MB</span>
        </div>

        <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.travels.index') }}" class="btn-action-text" style="display: flex; align-items: center; justify-content: center;">
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                Crear Viaje
            </button>
        </div>
    </form>
</div>

@endsection
