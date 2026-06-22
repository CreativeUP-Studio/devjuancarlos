@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Panel de Control (Dashboard)')

@section('content')

<style>
    .atajo-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1.25rem 1rem;
        border-radius: 12px;
        color: #ffffff;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: center;
    }
    .atajo-btn:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: rgba(255, 255, 255, 0.25) !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }
    .msg-item {
        padding: 0.85rem 1rem;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.04);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        transition: all 0.3s ease;
    }
    .msg-item:hover {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.08);
    }
</style>

<!-- Dashboard Summary Statistics -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    <!-- Projects KPI Card -->
    <div class="admin-card glass" style="margin-bottom: 0; padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; border-color: rgba(255, 255, 255, 0.08); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 0 0 20px rgba(255, 255, 255, 0.02);">
        <div style="width: 54px; height: 54px; border-radius: 16px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.15); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.6rem; filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.2));">
            <i class="fa-solid fa-folder-open"></i>
        </div>
        <div>
            <div style="font-size: 1.85rem; font-weight: 800; line-height: 1.1; color: #ffffff;">{{ $stats['projects_count'] }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-top: 0.25rem;">Proyectos</div>
        </div>
    </div>

    <!-- Skills KPI Card -->
    <div class="admin-card glass" style="margin-bottom: 0; padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; border-color: rgba(255, 255, 255, 0.08); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 0 0 20px rgba(255, 255, 255, 0.02);">
        <div style="width: 54px; height: 54px; border-radius: 16px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.15); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.6rem; filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.2));">
            <i class="fa-solid fa-brain"></i>
        </div>
        <div>
            <div style="font-size: 1.85rem; font-weight: 800; line-height: 1.1; color: #ffffff;">{{ $stats['skills_count'] }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-top: 0.25rem;">Habilidades</div>
        </div>
    </div>

    <!-- Travels KPI Card -->
    <div class="admin-card glass" style="margin-bottom: 0; padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; border-color: rgba(255, 255, 255, 0.08); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 0 0 20px rgba(255, 255, 255, 0.02);">
        <div style="width: 54px; height: 54px; border-radius: 16px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.15); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.6rem; filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.2));">
            <i class="fa-solid fa-plane"></i>
        </div>
        <div>
            <div style="font-size: 1.85rem; font-weight: 800; line-height: 1.1; color: #ffffff;">{{ $stats['travels_count'] }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-top: 0.25rem;">Viajes</div>
        </div>
    </div>

    <!-- Messages KPI Card -->
    <div class="admin-card glass" style="margin-bottom: 0; padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; border-color: rgba(255, 255, 255, 0.08); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 0 0 20px rgba(255, 255, 255, 0.02);">
        <div style="width: 54px; height: 54px; border-radius: 16px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.15); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.6rem; filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.2));">
            <i class="fa-solid fa-envelope"></i>
        </div>
        <div>
            <div style="font-size: 1.85rem; font-weight: 800; line-height: 1.1; color: #ffffff;">{{ $stats['messages_count'] }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-top: 0.25rem;">Mensajes</div>
        </div>
    </div>

    <!-- Unread Messages KPI Card -->
    <div class="admin-card glass" style="margin-bottom: 0; padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; border-color: rgba(255, 255, 255, 0.08); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 0 0 20px rgba(255, 255, 255, 0.02); {{ $stats['unread_messages'] > 0 ? 'border-color: rgba(239, 68, 68, 0.2);' : '' }}">
        <div style="width: 54px; height: 54px; border-radius: 16px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.15); display: flex; align-items: center; justify-content: center; color: {{ $stats['unread_messages'] > 0 ? '#ef4444' : '#ffffff' }}; font-size: 1.6rem; filter: drop-shadow(0 0 8px {{ $stats['unread_messages'] > 0 ? 'rgba(239, 68, 68, 0.3)' : 'rgba(255, 255, 255, 0.2)' }});">
            <i class="fa-solid fa-bell-slash"></i>
        </div>
        <div>
            <div style="font-size: 1.85rem; font-weight: 800; line-height: 1.1; color: {{ $stats['unread_messages'] > 0 ? '#ef4444' : '#ffffff' }};">{{ $stats['unread_messages'] }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-top: 0.25rem;">Sin Leer</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 2rem; align-items: start;">
    
    <!-- LEFT SIDE: Header & Contact Info Form -->
    <div>
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="admin-card glass" style="margin-bottom: 1.5rem;">
                <div class="admin-card-title"><i class="fa-solid fa-sliders" style="color: var(--accent-cyan);"></i> Configuración del Header (Inicio)</div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre Completo *</label>
                        <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $profile->name) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="title" class="form-label">Título Profesional de Presentación *</label>
                        <input type="text" name="title" id="title" class="form-input" value="{{ old('title', $profile->title) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="bio" class="form-label">Descripción Breve (SEO & Meta)</label>
                    <textarea name="bio" id="bio" class="form-input" style="min-height: 80px;" required>{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                    <div class="form-group">
                        <label for="hero_bg_image" class="form-label">Imagen de Fondo de Inicio (Hero)</label>
                        <input type="file" name="hero_bg_image" id="hero_bg_image" class="form-input" style="padding: 0.4rem;" accept="image/*" onchange="previewImage(this, 'preview-hero-bg');">
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">Formatos: PNG, JPG, WebP. Máx. 4MB</span>
                    </div>

                    <div class="form-group">
                        <label for="cv" class="form-label">Documento de Currículum (CV)</label>
                        <input type="file" name="cv" id="cv" class="form-input" style="padding: 0.4rem;" accept=".pdf,.doc,.docx" onchange="document.getElementById('cv-filename').innerText = this.files[0] ? this.files[0].name : '';">
                        <span id="cv-filename" style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">
                            {{ $profile->cv_path ? basename($profile->cv_path) : 'Formatos: PDF, DOCX. Máx. 10MB' }}
                        </span>
                    </div>
                </div>

                <div id="preview-hero-bg-container" style="margin-top: 0.5rem;">
                    <span style="font-size: 0.8rem; color: var(--text-secondary); display: block; margin-bottom: 0.25rem;">Imagen de fondo actual del Header:</span>
                    <img src="{{ $profile->hero_bg_image ? asset($profile->hero_bg_image) : asset('images/nav_inicio.png') }}" id="preview-hero-bg" alt="Fondo" style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.1);">
                </div>
            </div>

            <div class="admin-card glass" style="margin-bottom: 0;">
                <div class="admin-card-title"><i class="fa-solid fa-address-book" style="color: var(--accent-cyan);"></i> Datos de Contacto y Redes</div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                    <div class="form-group">
                        <label for="email" class="form-label">Correo Público</label>
                        <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $profile->email) }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Teléfono Público</label>
                        <input type="text" name="phone" id="phone" class="form-input" value="{{ old('phone', $profile->phone) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Ubicación / Disponibilidad de Trabajo *</label>
                    <input type="text" name="location" id="location" class="form-input" value="{{ old('location', $profile->location) }}" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="github_url" class="form-label">URL de GitHub</label>
                        <input type="url" name="github_url" id="github_url" class="form-input" value="{{ old('github_url', $profile->github_url) }}">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="linkedin_url" class="form-label">URL de LinkedIn</label>
                        <input type="url" name="linkedin_url" id="linkedin_url" class="form-input" value="{{ old('linkedin_url', $profile->linkedin_url) }}">
                    </div>
                </div>

                <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; text-align: right;">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk" style="margin-right: 0.5rem;"></i> Guardar Cambios del Header
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- RIGHT SIDE: Shortcuts & Inbox (BI) -->
    <div>
        <!-- Shortcuts Section -->
        <div class="admin-card glass" style="margin-bottom: 1.5rem;">
            <div class="admin-card-title"><i class="fa-solid fa-compass" style="color: var(--accent-cyan);"></i> Atajos de Gestión</div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <a href="{{ route('admin.projects.index') }}" class="atajo-btn" style="background: rgba(99, 102, 241, 0.05); border: 1px solid rgba(99, 102, 241, 0.15);">
                    <i class="fa-solid fa-diagram-project" style="font-size: 1.6rem; color: var(--accent-cyan);"></i>
                    <span style="font-size: 0.85rem; font-weight: 700;">Proyectos</span>
                </a>
                
                <a href="{{ route('admin.skills.index') }}" class="atajo-btn" style="background: rgba(139, 92, 246, 0.05); border: 1px solid rgba(139, 92, 246, 0.15);">
                    <i class="fa-solid fa-brain" style="font-size: 1.6rem; color: var(--accent-purple);"></i>
                    <span style="font-size: 0.85rem; font-weight: 700;">Habilidades</span>
                </a>
                
                <a href="{{ route('admin.travels.index') }}" class="atajo-btn" style="background: rgba(20, 184, 166, 0.05); border: 1px solid rgba(20, 184, 166, 0.15);">
                    <i class="fa-solid fa-plane" style="font-size: 1.6rem; color: #14b8a6;"></i>
                    <span style="font-size: 0.85rem; font-weight: 700;">Viajes</span>
                </a>
                
                <a href="{{ route('admin.biography.edit') }}" class="atajo-btn" style="background: rgba(236, 72, 153, 0.05); border: 1px solid rgba(236, 72, 153, 0.15);">
                    <i class="fa-solid fa-user-astronaut" style="font-size: 1.6rem; color: #ec4899;"></i>
                    <span style="font-size: 0.85rem; font-weight: 700;">Biografía</span>
                </a>
            </div>
        </div>

        <!-- Inbox (BI) Section -->
        <div class="admin-card glass" style="margin-bottom: 0;">
            <div class="admin-card-title" style="display: flex; justify-content: space-between; align-items: center;">
                <span><i class="fa-solid fa-inbox" style="color: var(--accent-cyan);"></i> Bandeja de Entrada (BI)</span>
                <a href="{{ route('admin.messages.index') }}" style="font-size: 0.75rem; color: var(--text-secondary); text-decoration: underline;">Ver Todos</a>
            </div>
            
            @if ($recentMessages->isEmpty())
                <div style="text-align: center; padding: 2rem 0; color: var(--text-muted);">
                    <i class="fa-solid fa-circle-info" style="font-size: 1.5rem; margin-bottom: 0.5rem;"></i>
                    <p style="font-size: 0.85rem; margin: 0;">No has recibido mensajes de contacto todavía.</p>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach ($recentMessages as $msg)
                        <div class="msg-item">
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 700; color: #ffffff; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                    @if (!$msg->is_read)
                                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444; display: inline-block; flex-shrink: 0;" title="Sin leer"></span>
                                    @endif
                                    {{ $msg->name }}
                                </div>
                                <div style="font-size: 0.75rem; color: var(--text-muted); text-overflow: ellipsis; overflow: hidden; white-space: nowrap; margin-top: 0.15rem;">
                                    {{ $msg->subject ?? 'Sin asunto' }}
                                </div>
                            </div>
                            <a href="{{ route('admin.messages.show', $msg) }}" class="btn-action" style="padding: 0.35rem 0.6rem; font-size: 0.75rem;" title="Ver mensaje">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById(previewId);
                if (previewImg) {
                    previewImg.src = e.target.result;
                    document.getElementById(previewId + '-container').style.display = 'block';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
