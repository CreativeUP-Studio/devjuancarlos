@extends('layouts.admin')

@section('title', 'Gestionar Proyectos')
@section('page_title', 'Gestionar Proyectos')

@section('content')

<div class="admin-card glass">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div class="admin-card-title" style="margin-bottom: 0;">Lista de Proyectos</div>
        <a href="{{ route('admin.projects.create') }}" class="btn-action-text btn-primary-action">
            <i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i>
            Nuevo Proyecto
        </a>
    </div>

    @if ($projects->isEmpty())
        <div style="text-align: center; padding: 3rem 0; color: var(--text-muted);">
            <div style="font-size: 3rem; margin-bottom: 1rem;"><i class="fa-solid fa-folder-open"></i></div>
            <p>No tienes ningún proyecto agregado. ¡Comienza creando uno!</p>
        </div>
    @else
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Miniatura</th>
                        <th>Título</th>
                        <th>Tecnologías</th>
                        <th style="width: 100px;">Orden</th>
                        <th style="width: 150px; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>
                                <div style="width: 60px; height: 40px; border-radius: 4px; overflow: hidden; background: #000; border: 1px solid var(--border-color);">
                                    @if ($project->image_path)
                                        <img src="{{ asset($project->image_path) }}" alt="{{ $project->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 0.8rem;">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td style="font-weight: 600;">
                                {{ $project->title }}
                            </td>
                            <td>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.25rem;">
                                    @foreach ($project->tech_stack_array as $tech)
                                        <span class="project-tag" style="padding: 0.1rem 0.5rem; font-size: 0.7rem;">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                {{ $project->order }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn-action" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proyecto?');">
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
