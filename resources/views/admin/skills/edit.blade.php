@extends('layouts.admin')

@section('title', 'Editar Habilidad')
@section('page_title', 'Editar Habilidad')

@section('content')

<div class="admin-card glass" style="max-width: 600px;">
    <div class="admin-card-title">Detalles de la Habilidad: {{ $skill->name }}</div>

    <form action="{{ route('admin.skills.update', $skill) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="form-label">Nombre de la Habilidad *</label>
            <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $skill->name) }}" required>
        </div>

        <div class="form-group">
            <label for="category" class="form-label">Categoría *</label>
            <select name="category" id="category" class="form-input" required style="cursor: pointer;">
                <option value="">Selecciona una categoría...</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category', $skill->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="proficiency" class="form-label">Porcentaje de Dominio (1-100) *</label>
                <input type="number" name="proficiency" id="proficiency" class="form-input" min="1" max="100" value="{{ old('proficiency', $skill->proficiency) }}" required>
            </div>
            
            <div class="form-group">
                <label for="order" class="form-label">Orden de Prioridad *</label>
                <input type="number" name="order" id="order" class="form-input" value="{{ old('order', $skill->order) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="icon_class" class="form-label">Clase de Icono (FontAwesome o Devicon, Opcional)</label>
            <input type="text" name="icon_class" id="icon_class" class="form-input" value="{{ old('icon_class', $skill->icon_class) }}">
            <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">
                Clase de FontAwesome (ej: <code>fa-brands fa-laravel</code>) o de Devicon (ej: <code>devicon-python-plain</code>).
            </span>
        </div>

        <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.skills.index') }}" class="btn-action-text" style="display: flex; align-items: center; justify-content: center;">
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

@endsection
