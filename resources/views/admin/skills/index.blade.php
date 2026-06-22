@extends('layouts.admin')

@section('title', 'Gestionar Habilidades')
@section('page_title', 'Gestionar Habilidades')

@section('content')

<div class="admin-card glass">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div class="admin-card-title" style="margin-bottom: 0;">Habilidades Técnicas</div>
        <a href="{{ route('admin.skills.create') }}" class="btn-action-text btn-primary-action">
            <i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i>
            Nueva Habilidad
        </a>
    </div>

    @if ($skills->isEmpty())
        <div style="text-align: center; padding: 3rem 0; color: var(--text-muted);">
            <div style="font-size: 3rem; margin-bottom: 1rem;"><i class="fa-solid fa-brain"></i></div>
            <p>No tienes ninguna habilidad registrada. ¡Agrega tus conocimientos!</p>
        </div>
    @else
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Icono</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Dominio</th>
                        <th style="width: 100px;">Orden</th>
                        <th style="width: 150px; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skills as $skill)
                        <tr>
                            <td style="text-align: center; font-size: 1.25rem; color: var(--accent-cyan);">
                                @if ($skill->icon_class)
                                    <i class="{{ $skill->icon_class }}"></i>
                                @else
                                    <i class="fa-solid fa-code"></i>
                                @endif
                            </td>
                            <td style="font-weight: 600;">
                                {{ $skill->name }}
                            </td>
                            <td>
                                <span class="project-tag">
                                    {{ $skill->category }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div class="skill-bar-bg" style="width: 120px;">
                                        <div class="skill-bar-fill" style="width: {{ $skill->proficiency }}%; height: 100%;"></div>
                                    </div>
                                    <span style="font-size: 0.85rem; font-weight: 600;">{{ $skill->proficiency }}%</span>
                                </div>
                            </td>
                            <td>
                                {{ $skill->order }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                    <a href="{{ route('admin.skills.edit', $skill) }}" class="btn-action" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta habilidad?');">
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

@endsection
