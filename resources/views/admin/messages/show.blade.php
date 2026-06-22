@extends('layouts.admin')

@section('title', 'Ver Mensaje')
@section('page_title', 'Detalles del Mensaje')

@section('content')

<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.messages.index') }}" style="color: var(--accent-cyan); display: flex; align-items: center; gap: 0.5rem; font-weight: 500;">
        <i class="fa-solid fa-arrow-left"></i> Volver a la Bandeja de Entrada
    </a>
</div>

<div class="admin-card glass" style="max-width: 800px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem;">
        <div>
            <span class="badge {{ $message->is_read ? 'badge-read' : 'badge-unread' }}" style="margin-bottom: 0.75rem;">
                {{ $message->is_read ? 'Leído' : 'Nuevo' }}
            </span>
            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem;">{{ $message->subject ?? '(Sin Asunto)' }}</h2>
            <div style="font-size: 0.9rem; color: var(--text-secondary);">
                De: <strong style="color: var(--text-primary);">{{ $message->name }}</strong> 
                &lt;<a href="mailto:{{ $message->email }}" style="color: var(--accent-cyan); text-decoration: underline;">{{ $message->email }}</a>&gt;
            </div>
        </div>
        <div style="text-align: right; font-size: 0.85rem; color: var(--text-secondary);">
            <div><i class="fa-regular fa-clock" style="margin-right: 0.25rem;"></i> {{ $message->created_at->format('d/m/Y') }}</div>
            <div style="margin-top: 0.25rem;">{{ $message->created_at->format('H:i:s') }}</div>
        </div>
    </div>

    <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 8px; padding: 2rem; min-height: 200px; white-space: pre-wrap; line-height: 1.7; font-size: 1.05rem;">
        {{ $message->content }}
    </div>

    <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}" class="btn-primary" style="display: flex; align-items: center; gap: 0.5rem;">
            <i class="fa-solid fa-reply"></i>
            Responder por Correo
        </a>

        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este mensaje?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action-text" style="color: var(--text-primary); border-color: var(--border-color); background: rgba(255, 255, 255, 0.02); display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <i class="fa-solid fa-trash-can"></i>
                Eliminar Mensaje
            </button>
        </form>
    </div>
</div>

@endsection
