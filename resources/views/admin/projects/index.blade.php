@extends('layouts.admin')

@section('title', 'Gestionar Proyectos')
@section('page_title', 'Gestionar Proyectos')

@section('content')

<style>
    .projects-editor-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .project-thumb-preview {
        width: 64px;
        height: 42px;
        border-radius: 8px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .project-thumb-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .project-thumb-preview:hover {
        border-color: var(--border-hover);
        transform: scale(1.08);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .tech-tag {
        display: inline-block;
        padding: 0.15rem 0.55rem;
        font-size: 0.68rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: var(--text-secondary);
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .tech-tag:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    .project-url-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.2rem 0.55rem;
        font-size: 0.72rem;
        font-weight: 500;
        border-radius: 6px;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .project-url-link:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .project-url-link.live-link:hover {
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.25);
        background: rgba(16, 185, 129, 0.06);
    }

    .project-url-link.github-link:hover {
        color: #a78bfa;
        border-color: rgba(167, 139, 250, 0.25);
        background: rgba(167, 139, 250, 0.06);
    }

    .project-stats-bar {
        display: flex;
        gap: 2rem;
        padding: 1.25rem 1.5rem;
        background: rgba(255, 255, 255, 0.015);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        margin-bottom: 1.5rem;
    }

    .project-stat-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .project-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }

    .project-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        line-height: 1;
    }

    .project-stat-label {
        font-size: 0.72rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
    }

    .empty-state-container {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-muted);
        border: 1px dashed var(--border-color);
        border-radius: 14px;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1.5rem;
        color: var(--text-muted);
    }

    .empty-state-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .empty-state-desc {
        font-size: 0.88rem;
        font-weight: 300;
        color: var(--text-muted);
        max-width: 400px;
        margin: 0 auto 1.5rem;
        line-height: 1.5;
    }

    .order-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        padding: 0 0.5rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }

    @media (max-width: 768px) {
        .project-stats-bar {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>

<div class="projects-editor-container">

    <!-- Stats Summary Bar -->
    <div class="project-stats-bar">
        <div class="project-stat-item">
            <div class="project-stat-icon" style="background: rgba(64, 93, 230, 0.08); border-color: rgba(64, 93, 230, 0.2); color: var(--insta-blue);">
                <i class="fa-solid fa-diagram-project"></i>
            </div>
            <div>
                <div class="project-stat-value">{{ $projects->count() }}</div>
                <div class="project-stat-label">Proyectos</div>
            </div>
        </div>
        <div class="project-stat-item">
            <div class="project-stat-icon" style="background: rgba(16, 185, 129, 0.08); border-color: rgba(16, 185, 129, 0.2); color: #10b981;">
                <i class="fa-solid fa-globe"></i>
            </div>
            <div>
                <div class="project-stat-value">{{ $projects->whereNotNull('project_url')->count() }}</div>
                <div class="project-stat-label">Con URL En Vivo</div>
            </div>
        </div>
        <div class="project-stat-item">
            <div class="project-stat-icon" style="background: rgba(167, 139, 250, 0.08); border-color: rgba(167, 139, 250, 0.2); color: #a78bfa;">
                <i class="fa-brands fa-github"></i>
            </div>
            <div>
                <div class="project-stat-value">{{ $projects->whereNotNull('github_url')->count() }}</div>
                <div class="project-stat-label">Con GitHub</div>
            </div>
        </div>
    </div>

    <!-- Projects List Card -->
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.8rem;">
            <div class="admin-card-title" style="margin-bottom: 0;">
                <i class="fa-solid fa-diagram-project"></i>
                Proyectos del Portafolio
            </div>
            
            <a href="{{ route('admin.projects.create') }}" class="btn-action-text btn-primary-action" style="border-radius: 10px; padding: 0.75rem 1.2rem;">
                <i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i>
                Nuevo Proyecto
            </a>
        </div>

        <p style="font-size: 0.88rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 1.5rem;">
            Administra los proyectos que aparecen en tu portafolio. Puedes agregar enlaces a demos en vivo y repositorios de GitHub para cada proyecto.
        </p>

        @if ($projects->isEmpty())
            <div class="empty-state-container">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <div class="empty-state-title">No hay proyectos registrados</div>
                <div class="empty-state-desc">
                    Aún no tienes ningún proyecto. Comienza creando uno para mostrarlo en tu portafolio.
                </div>
                <a href="{{ route('admin.projects.create') }}" class="btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 10px; font-size: 0.88rem; text-decoration: none;">
                    <i class="fa-solid fa-plus"></i>
                    Crear Primer Proyecto
                </a>
            </div>
        @else
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px; text-align: center;">Portada</th>
                            <th>Proyecto</th>
                            <th>Tecnologías</th>
                            <th style="width: 130px;">Enlaces</th>
                            <th style="width: 80px; text-align: center;">Orden</th>
                            <th style="width: 150px; text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>
                                    <div style="display: flex; justify-content: center;">
                                        <div class="project-thumb-preview">
                                            @if ($project->image_path)
                                                <img src="{{ asset($project->image_path) }}" alt="{{ $project->title }}">
                                            @else
                                                <i class="fa-solid fa-image" style="color: var(--text-muted); font-size: 0.9rem;"></i>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div style="font-weight: 600; color: #ffffff; margin-bottom: 0.25rem;">{{ $project->title }}</div>
                                    <div style="font-size: 0.78rem; color: var(--text-muted); line-height: 1.4; max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ Str::limit($project->description, 60) }}
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.3rem; max-width: 220px;">
                                        @foreach (array_slice($project->tech_stack_array, 0, 4) as $tech)
                                            <span class="tech-tag">{{ $tech }}</span>
                                        @endforeach
                                        @if (count($project->tech_stack_array) > 4)
                                            <span class="tech-tag" style="color: var(--insta-orange); border-color: rgba(245, 96, 64, 0.2);">
                                                +{{ count($project->tech_stack_array) - 4 }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        @if ($project->project_url)
                                            <a href="{{ $project->project_url }}" target="_blank" class="project-url-link live-link" title="Ver proyecto en vivo">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                <span>En Vivo</span>
                                            </a>
                                        @endif
                                        @if ($project->github_url)
                                            <a href="{{ $project->github_url }}" target="_blank" class="project-url-link github-link" title="Ver repositorio en GitHub">
                                                <i class="fa-brands fa-github"></i>
                                                <span>GitHub</span>
                                            </a>
                                        @endif
                                        @if (!$project->project_url && !$project->github_url)
                                            <span style="font-size: 0.75rem; color: var(--text-muted);">—</span>
                                        @endif
                                    </div>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <span class="order-badge">{{ $project->order }}</span>
                                </td>
                                <td style="text-align: right; vertical-align: middle;">
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
</div>

@endsection
