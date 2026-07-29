@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Configuración del Header')

@section('content')

<style>
    .dashboard-header-container {
        max-width: 700px;
        margin: 0 auto;
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-preview-box {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        margin-top: 1rem;
        height: 220px;
        background: rgba(255, 255, 255, 0.01);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header-preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .header-preview-box:hover .header-preview-image {
        transform: scale(1.03);
    }

    .header-preview-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .file-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .custom-file-upload {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.85rem 1.25rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-file-upload:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--border-hover);
    }

    .file-name-display {
        font-size: 0.85rem;
        color: var(--text-secondary);
        font-weight: 300;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
</style>

<div class="dashboard-header-container">
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Keep validation required and other fields safe as hidden inputs -->
        <input type="hidden" name="bio" value="{{ $profile->bio ?? 'Arquitecto de experiencias digitales' }}">
        <input type="hidden" name="email" value="{{ $profile->email }}">
        <input type="hidden" name="phone" value="{{ $profile->phone }}">
        <input type="hidden" name="location" value="{{ $profile->location }}">
        <input type="hidden" name="github_url" value="{{ $profile->github_url }}">
        <input type="hidden" name="linkedin_url" value="{{ $profile->linkedin_url }}">

        <div class="admin-card">
            <div class="admin-card-title">
                <i class="fa-solid fa-sliders"></i>
                Detalles del Header (Hero)
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Nombre Principal *</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-input" 
                    value="{{ old('name', $profile->name) }}" 
                    placeholder="ej. Juan Carlos Chahuayo Martínez" 
                    required
                >
            </div>
            
            <div class="form-group">
                <label for="title" class="form-label">Subtítulo del Hero *</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    class="form-input" 
                    value="{{ old('title', $profile->title) }}" 
                    placeholder="ej. Estudiante de ingeniería de sistemas" 
                    required
                >
            </div>

            <!-- Hero BG Image Upload -->
            <div class="form-group" style="margin-top: 1.8rem;">
                <label class="form-label">Imagen de Fondo del Hero *</label>
                <div class="file-input-wrapper">
                    <label class="custom-file-upload">
                        <input 
                            type="file" 
                            name="hero_bg_image" 
                            id="hero_bg_image" 
                            accept="image/*" 
                            style="display: none;"
                            onchange="handleImageUpload(this)"
                        >
                        <i class="fa-regular fa-image"></i> Seleccionar Imagen
                    </label>
                    <span class="file-name-display" id="hero-file-name">
                        {{ $profile->hero_bg_image ? 'Imagen actual cargada' : 'Sin archivo seleccionado' }}
                    </span>
                </div>
                
                <div class="header-preview-box">
                    @if($profile->hero_bg_image)
                        <img src="{{ asset($profile->hero_bg_image) }}" id="preview-hero" class="header-preview-image" alt="Hero Background">
                    @else
                        <div class="header-preview-placeholder" id="preview-placeholder">
                            <i class="fa-regular fa-images" style="font-size: 2.2rem;"></i>
                            <span>Vista previa del fondo</span>
                        </div>
                        <img id="preview-hero" class="header-preview-image" alt="Hero Background" style="display: none;">
                    @endif
                </div>
            </div>

            <div style="margin-top: 2.5rem; padding-top: 1.8rem; border-top: 1px solid var(--border-color); text-align: right;">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
