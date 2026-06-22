@extends('layouts.admin')

@section('title', 'Gestionar Biografía')
@section('page_title', 'Gestionar Biografía')

@section('content')

<style>
    .bio-preview-container {
        position: relative;
        width: 100%;
        height: 140px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background-color: var(--bg-dark);
        margin-top: 0.5rem;
    }
    .bio-preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .bio-image-circle {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid rgba(255, 255, 255, 0.15);
        background-color: var(--bg-dark);
        margin: 0 auto 1rem auto;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    }
    .bio-image-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<form action="{{ route('admin.biography.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        
        <!-- LEFT COLUMN: The 3 public site images -->
        <div>
            <!-- Image 1: Main Photo -->
            <div class="admin-card glass" style="text-align: center;">
                <div class="admin-card-title" style="justify-content: center;"><i class="fa-solid fa-camera"></i> 1. Foto de Perfil (Bio Principal)</div>
                
                <div class="bio-image-circle">
                    <img src="{{ $profile->photo_path ? asset($profile->photo_path) : asset('images/bio_lifestyle.png') }}" id="preview-photo-path" alt="Foto Perfil">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="photo" class="btn-action-text" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; border-style: dashed; border-color: rgba(255, 255, 255, 0.2); width: 100%; cursor: pointer;">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Cambiar Foto Principal
                    </label>
                    <input type="file" name="photo" id="photo" style="display: none;" accept="image/*" onchange="previewImageCircle(this, 'preview-photo-path'); document.getElementById('photo-lbl').innerText = this.files[0] ? this.files[0].name : '';">
                    <span id="photo-lbl" style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;"></span>
                </div>
            </div>

            <!-- Image 2: Workspace Image -->
            <div class="admin-card glass">
                <div class="admin-card-title"><i class="fa-solid fa-laptop-code"></i> 2. Imagen Workspace (Panel Superior)</div>
                
                <div class="bio-preview-container">
                    @if ($profile->workspace_image)
                        <img src="{{ asset($profile->workspace_image) }}" id="preview-workspace-img" alt="Workspace">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1rem;">
                            Usa la imagen por defecto
                        </div>
                    @endif
                </div>

                <div class="form-group" style="margin-top: 1rem; margin-bottom: 0;">
                    <label for="workspace_image" class="btn-action-text" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; border-style: dashed; border-color: rgba(255, 255, 255, 0.2); width: 100%; cursor: pointer;">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Cambiar Workspace
                    </label>
                    <input type="file" name="workspace_image" id="workspace_image" style="display: none;" accept="image/*" onchange="previewImageRect(this, 'preview-workspace-img'); document.getElementById('workspace-lbl').innerText = this.files[0] ? this.files[0].name : '';">
                    <span id="workspace-lbl" style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;"></span>
                </div>
            </div>

            <!-- Image 3: Tech Stack Image -->
            <div class="admin-card glass">
                <div class="admin-card-title"><i class="fa-solid fa-microchip"></i> 3. Imagen Tech Stack (Panel Inferior)</div>
                
                <div class="bio-preview-container">
                    @if ($profile->tech_image)
                        <img src="{{ asset($profile->tech_image) }}" id="preview-tech-img" alt="Tech">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1rem;">
                            Usa la imagen por defecto
                        </div>
                    @endif
                </div>

                <div class="form-group" style="margin-top: 1rem; margin-bottom: 0;">
                    <label for="tech_image" class="btn-action-text" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; border-style: dashed; border-color: rgba(255, 255, 255, 0.2); width: 100%; cursor: pointer;">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Cambiar Tech Image
                    </label>
                    <input type="file" name="tech_image" id="tech_image" style="display: none;" accept="image/*" onchange="previewImageRect(this, 'preview-tech-img'); document.getElementById('tech-lbl').innerText = this.files[0] ? this.files[0].name : '';">
                    <span id="tech-lbl" style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;"></span>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Biography Texts & Panels -->
        <div>
            <!-- Main biography text fields -->
            <div class="admin-card glass" style="margin-bottom: 1.5rem;">
                <div class="admin-card-title"><i class="fa-solid fa-user-astronaut"></i> Biografía - Información Principal</div>
                
                <div class="form-group">
                    <label for="bio_tag" class="form-label">Etiqueta Superior (Tag)</label>
                    <input type="text" name="bio_tag" id="bio_tag" class="form-input" value="{{ old('bio_tag', $profile->bio_tag ?? 'El Humano Detrás del Código') }}" placeholder="Ej. El Humano Detrás del Código">
                    <small style="color: var(--text-muted); font-size: 0.8rem;">Texto pequeño arriba del título principal</small>
                </div>

                <div class="form-group">
                    <label for="bio_title" class="form-label">Título Principal</label>
                    <input type="text" name="bio_title" id="bio_title" class="form-input" value="{{ old('bio_title', $profile->bio_title ?? 'Transformo Ideas en Realidad Digital') }}" placeholder="Ej. Transformo Ideas en Realidad Digital">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="bio_description" class="form-label">Descripción Detallada (Cuerpo principal)</label>
                    <textarea name="bio_description" id="bio_description" class="form-input" style="min-height: 120px;">{{ old('bio_description', $profile->bio_description) }}</textarea>
                </div>
            </div>

            <!-- Workspace & Tech stack texts -->
            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
                <!-- Workspace Text fields -->
                <div class="admin-card glass" style="margin-bottom: 0;">
                    <div class="admin-card-title"><i class="fa-solid fa-laptop-code" style="color: var(--accent-cyan);"></i> Contenido de Workspace</div>
                    
                    <div class="form-group">
                        <label for="workspace_title" class="form-label">Título del Panel</label>
                        <input type="text" name="workspace_title" id="workspace_title" class="form-input" value="{{ old('workspace_title', $profile->workspace_title ?? 'Mi Laboratorio') }}">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="workspace_desc" class="form-label">Descripción del Panel</label>
                        <textarea name="workspace_desc" id="workspace_desc" class="form-input" style="min-height: 80px;">{{ old('workspace_desc', $profile->workspace_desc) }}</textarea>
                    </div>
                </div>

                <!-- Tech Stack Text fields -->
                <div class="admin-card glass" style="margin-bottom: 0;">
                    <div class="admin-card-title"><i class="fa-solid fa-microchip" style="color: var(--accent-cyan);"></i> Contenido de Tech Stack</div>
                    
                    <div class="form-group">
                        <label for="tech_title" class="form-label">Título del Panel</label>
                        <input type="text" name="tech_title" id="tech_title" class="form-input" value="{{ old('tech_title', $profile->tech_title ?? 'Stack Tecnológico') }}">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="tech_desc" class="form-label">Descripción del Panel</label>
                        <textarea name="tech_desc" id="tech_desc" class="form-input" style="min-height: 80px;">{{ old('tech_desc', $profile->tech_desc) }}</textarea>
                    </div>
                </div>
            </div>

            <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; text-align: right;">
                <a href="{{ route('admin.dashboard') }}" class="btn-action-text" style="display: inline-flex; align-items: center; justify-content: center; margin-right: 1rem; border: 1px solid rgba(255,255,255,0.1);">
                    Volver al Dashboard
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk" style="margin-right: 0.5rem;"></i> Guardar Biografía
                </button>
            </div>
        </div>
        
    </div>
</form>

<script>
    // Image preview circle uploader
    function previewImageCircle(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById(previewId);
                if (previewImg) {
                    previewImg.src = e.target.result;
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Image preview rectangle uploader
    function previewImageRect(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let previewImg = document.getElementById(previewId);
                if (previewImg) {
                    previewImg.src = e.target.result;
                } else {
                    // If fallback div is present, replace it or create img
                    const parent = document.querySelector('[id="' + previewId + '"]').parentNode;
                    parent.innerHTML = '<img src="' + e.target.result + '" id="' + previewId + '" alt="Vista previa">';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
