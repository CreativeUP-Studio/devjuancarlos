@extends('layouts.admin')

@section('title', 'Gestionar Viajes')
@section('page_title', 'Gestionar Viajes')

@section('content')

<style>
    .travels-editor-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .travel-thumb-preview {
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

    .travel-thumb-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .travel-stats-bar {
        display: flex;
        gap: 2rem;
        padding: 1.25rem 1.5rem;
        background: rgba(255, 255, 255, 0.015);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        margin-bottom: 1.5rem;
    }

    .travel-stat-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .travel-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
    }

    .travel-stat-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: #ffffff;
        line-height: 1;
    }

    .travel-stat-label {
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
    }

    .badge-media {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-secondary);
    }

    .badge-media.video-badge {
        background: rgba(245, 96, 64, 0.08);
        border-color: rgba(245, 96, 64, 0.2);
        color: var(--insta-orange);
    }

    .badge-media.audio-badge {
        background: rgba(225, 48, 108, 0.08);
        border-color: rgba(225, 48, 108, 0.2);
        color: var(--insta-magenta);
    }
</style>

<div class="travels-editor-container">

    <!-- Stats Summary Bar -->
    <div class="travel-stats-bar">
        <div class="travel-stat-item">
            <div class="travel-stat-icon" style="color: var(--insta-orange); background: rgba(245, 96, 64, 0.08); border-color: rgba(245, 96, 64, 0.2);">
                <i class="fa-solid fa-plane-departure"></i>
            </div>
            <div>
                <div class="travel-stat-value">{{ $travels->count() }}</div>
                <div class="travel-stat-label">Destinos de Viaje</div>
            </div>
        </div>

        <div class="travel-stat-item">
            <div class="travel-stat-icon" style="color: var(--insta-magenta); background: rgba(225, 48, 108, 0.08); border-color: rgba(225, 48, 108, 0.2);">
                <i class="fa-solid fa-video"></i>
            </div>
            <div>
                <div class="travel-stat-value">{{ $travels->where('media_type', 'video')->count() }}</div>
                <div class="travel-stat-label">Con Video Integrado</div>
            </div>
        </div>

        <div class="travel-stat-item">
            <div class="travel-stat-icon" style="color: var(--insta-yellow); background: rgba(252, 175, 69, 0.08); border-color: rgba(252, 175, 69, 0.2);">
                <i class="fa-solid fa-music"></i>
            </div>
            <div>
                <div class="travel-stat-value">{{ $travels->whereNotNull('audio_path')->count() }}</div>
                <div class="travel-stat-label">Con Música de Fondo</div>
            </div>
        </div>
    </div>

    <!-- Travels Table Card -->
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div class="admin-card-title" style="margin-bottom: 0;">
                <i class="fa-solid fa-earth-americas"></i>
                Lista de Bitácoras de Viaje
            </div>
            <a href="{{ route('admin.travels.create') }}" class="btn-primary" style="padding: 0.75rem 1.4rem; border-radius: 12px; font-size: 0.88rem;">
                <i class="fa-solid fa-plus"></i>
                Nuevo Viaje
            </a>
        </div>

        @if ($travels->isEmpty())
            <div style="text-align: center; padding: 4rem 0; color: var(--text-muted);">
                <div style="font-size: 3.5rem; margin-bottom: 1rem; color: var(--insta-orange);"><i class="fa-solid fa-plane"></i></div>
                <h3 style="font-size: 1.1rem; color: #ffffff; margin-bottom: 0.5rem;">No tienes ningún viaje registrado</h3>
                <p style="font-size: 0.9rem; margin-bottom: 1.5rem;">Comienza agregando tus mejores experiencias de viaje y bitácoras fotográficas.</p>
                <a href="{{ route('admin.travels.create') }}" class="btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Crear Primer Viaje
                </a>
            </div>
        @else
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px; text-align: center;">Portada</th>
                            <th>Destino / Título</th>
                            <th>Lugar & País</th>
                            <th style="width: 120px;">Año / Fecha</th>
                            <th>Multimedia & Audio</th>
                            <th style="width: 80px; text-align: center;">Orden</th>
                            <th style="width: 140px; text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($travels as $travel)
                            <tr>
                                <td>
                                    <div style="display: flex; justify-content: center;">
                                        <div class="travel-thumb-preview">
                                            @if ($travel->image_path)
                                                <img src="{{ asset($travel->image_path) }}" alt="{{ $travel->title }}">
                                            @else
                                                <i class="fa-solid fa-image" style="color: var(--text-muted); font-size: 0.9rem;"></i>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td style="font-weight: 600;">
                                    <div style="color: #ffffff; margin-bottom: 0.2rem;">{{ $travel->title }}</div>
                                    <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 300;">
                                        {{ Str::limit($travel->description, 50) }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 500;">{{ $travel->location ?? '—' }}</div>
                                    <div style="font-size: 0.78rem; color: var(--text-muted);">{{ $travel->country ?? 'Perú' }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--insta-yellow);">{{ $travel->year ?? '2025' }}</div>
                                    @if($travel->travel_date)
                                        <div style="font-size: 0.72rem; color: var(--text-muted);">{{ $travel->travel_date }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                                        @if($travel->media_type === 'video')
                                            <span class="badge-media video-badge">
                                                <i class="fa-solid fa-video"></i> Video
                                            </span>
                                        @else
                                            <span class="badge-media">
                                                <i class="fa-solid fa-image"></i> Imagen
                                            </span>
                                        @endif

                                        @if($travel->audio_path)
                                            <span class="badge-media audio-badge">
                                                <i class="fa-solid fa-music"></i> Música
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <span style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary);">{{ $travel->order }}</span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                        <a href="{{ route('admin.travels.edit', $travel) }}" class="btn-action" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.travels.destroy', $travel) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este viaje?');">
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
