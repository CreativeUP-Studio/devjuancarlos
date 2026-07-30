@extends('layouts.admin')

@section('title', 'Perfil de Administrador')
@section('page_title', 'Perfil de Administrador')

@section('content')

<style>
    .admin-account-container {
        max-width: 850px;
        margin: 0 auto;
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .account-avatar-card {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding: 1.75rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
    }

    .avatar-preview-circle {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-purple) 25%, var(--insta-magenta) 50%, var(--insta-orange) 100%);
        border: 3px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        flex-shrink: 0;
    }

    .avatar-preview-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-upload-info {
        flex: 1;
    }

    .avatar-upload-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.35rem;
    }

    .avatar-upload-desc {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    .form-section-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 0.75rem;
    }

    .form-section-title i {
        color: var(--insta-orange);
    }
</style>

<div class="admin-account-container">
    <div class="admin-card">
        <div class="admin-card-title">
            <i class="fa-solid fa-user-gear"></i>
            Configuración de Cuenta & Perfil de Administrador
        </div>

        <form action="{{ route('admin.account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Avatar Section -->
            <div class="account-avatar-card">
                <div class="avatar-preview-circle">
                    <img id="avatarPreviewImg" src="{{ $user->profile_photo }}" alt="Avatar Administrador">
                </div>
                <div class="avatar-upload-info">
                    <h4 class="avatar-upload-title">Fotografía de Perfil / Avatar</h4>
                    <p class="avatar-upload-desc">Esta imagen se mostrará en la barra superior y en el panel de control del administrador.</p>
                    
                    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                        <label for="avatar" class="btn-action" style="cursor: pointer;">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            Cambiar Foto de Perfil
                        </label>
                        <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;" onchange="previewAvatarLive(this)">

                        @if($user->avatar_path)
                            <label style="display: inline-flex; align-items: center; gap: 0.4rem; color: #f87171; font-size: 0.82rem; cursor: pointer; font-weight: 600;">
                                <input type="checkbox" name="delete_avatar" value="1" style="accent-color: #ef4444; cursor: pointer;">
                                <i class="fa-solid fa-trash-can"></i> Quitar Foto Personalizada
                            </label>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Personal Data Section -->
            <div class="form-section-title">
                <i class="fa-solid fa-id-card"></i>
                Datos Personales del Administrador
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="name" class="form-label">Nombre Completo *</label>
                    <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $user->name) }}" required placeholder="Ej. Juan Carlos">
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico (Login) *</label>
                    <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $user->email) }}" required placeholder="ejemplo@correo.com">
                </div>
            </div>

            <!-- Security & Password Section -->
            <div class="form-section-title" style="margin-top: 1rem;">
                <i class="fa-solid fa-shield-halved"></i>
                Seguridad & Cambio de Contraseña <span style="font-size: 0.72rem; color: var(--text-muted); font-weight: 400; text-transform: none;">(Dejar en blanco para mantener la contraseña actual)</span>
            </div>

            <div class="form-group">
                <label for="current_password" class="form-label">Contraseña Actual</label>
                <input type="password" name="current_password" id="current_password" class="form-input" placeholder="••••••••">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="new_password" class="form-label">Nueva Contraseña</label>
                    <input type="password" name="new_password" id="new_password" class="form-input" placeholder="Mínimo 8 caracteres">
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-input" placeholder="Repite la nueva contraseña">
                </div>
            </div>

            <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('admin.dashboard') }}" class="btn-action-text">
                    Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar Cambios del Perfil
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewAvatarLive(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('avatarPreviewImg');
                if (img) img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
