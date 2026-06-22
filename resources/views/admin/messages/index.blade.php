@extends('layouts.admin')

@section('title', 'Bandeja de Entrada')
@section('page_title', 'Mensajes Recibidos')

@section('content')

<div class="admin-card glass">
    <div class="admin-card-title">Buzón de Contacto</div>

    @if ($messages->isEmpty())
        <div style="text-align: center; padding: 3rem 0; color: var(--text-muted);">
            <div style="font-size: 3rem; margin-bottom: 1rem;"><i class="fa-solid fa-envelope-open"></i></div>
            <p>No has recibido ningún mensaje de contacto todavía.</p>
        </div>
    @else
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">Estado</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Asunto</th>
                        <th>Fecha</th>
                        <th style="width: 120px; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                        <tr style="{{ !$message->is_read ? 'background: rgba(255, 255, 255, 0.04); font-weight: 500;' : '' }}">
                            <td>
                                @if ($message->is_read)
                                    <span class="badge badge-read">Leído</span>
                                @else
                                    <span class="badge badge-unread">Nuevo</span>
                                @endif
                            </td>
                            <td>
                                {{ $message->name }}
                            </td>
                            <td>
                                {{ $message->email }}
                            </td>
                            <td style="max-width: 250px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                {{ $message->subject ?? '(Sin Asunto)' }}
                            </td>
                            <td style="font-size: 0.85rem; color: var(--text-secondary);">
                                {{ $message->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="btn-action" title="Ver mensaje">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este mensaje?');">
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
