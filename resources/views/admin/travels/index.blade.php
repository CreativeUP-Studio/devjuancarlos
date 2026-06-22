@extends('layouts.admin')

@section('title', 'Gestionar Viajes')
@section('page_title', 'Gestionar Viajes')

@section('content')

<div class="admin-card glass">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div class="admin-card-title" style="margin-bottom: 0;">Lista de Viajes</div>
        <a href="{{ route('admin.travels.create') }}" class="btn-action-text btn-primary-action">
            <i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i>
            Nuevo Viaje
        </a>
    </div>

    @if ($travels->isEmpty())
        <div style="text-align: center; padding: 3rem 0; color: var(--text-muted);">
            <div style="font-size: 3rem; margin-bottom: 1rem;"><i class="fa-solid fa-plane"></i></div>
            <p>No tienes ningún viaje agregado. ¡Comienza creando uno!</p>
        </div>
    @else
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Imagen</th>
                        <th>Destino / Título</th>
                        <th>Etiqueta (Badge)</th>
                        <th>Detalles / Características</th>
                        <th style="width: 100px;">Orden</th>
                        <th style="width: 150px; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($travels as $travel)
                        <tr>
                            <td>
                                <div style="width: 60px; height: 40px; border-radius: 4px; overflow: hidden; background: #000; border: 1px solid var(--border-color);">
                                    @if ($travel->image_path)
                                        <img src="{{ asset($travel->image_path) }}" alt="{{ $travel->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 0.8rem;">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td style="font-weight: 600;">
                                {{ $travel->title }}
                            </td>
                            <td>
                                <span class="project-tag" style="background: rgba(255, 255, 255, 0.08); padding: 0.15rem 0.5rem; font-size: 0.75rem; color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.15);">
                                    {{ $travel->badge }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.75rem; font-size: 0.75rem; color: var(--text-secondary);">
                                    @if($travel->meta_1_text)
                                        <span><i class="{{ $travel->meta_1_icon ?? 'fa-solid fa-plane-departure' }}"></i> {{ $travel->meta_1_text }}</span>
                                    @endif
                                    @if($travel->meta_2_text)
                                        <span><i class="{{ $travel->meta_2_icon ?? 'fa-solid fa-camera' }}"></i> {{ $travel->meta_2_text }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                {{ $travel->order }}
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

@endsection
