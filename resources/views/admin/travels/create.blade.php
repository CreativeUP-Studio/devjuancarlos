@extends('layouts.admin')

@section('title', 'Nuevo Viaje')
@section('page_title', 'Agregar Nuevo Viaje')

@section('content')

<style>
    /* Custom Selection Cards & Live Previews */
    .media-type-selector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .media-option-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.1rem 1.25rem;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.02);
        border: 2px solid var(--border-color);
        cursor: pointer;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        user-select: none;
    }

    .media-option-card:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    .media-option-card.active {
        background: rgba(225, 48, 108, 0.08);
        border-color: var(--insta-magenta);
        box-shadow: 0 8px 25px rgba(225, 48, 108, 0.25);
    }

    .option-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--text-secondary);
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .media-option-card.active .option-icon {
        background: linear-gradient(135deg, var(--insta-purple), var(--insta-orange));
        color: #ffffff;
        border: none;
        box-shadow: 0 4px 15px rgba(225, 48, 108, 0.4);
    }

    .option-info {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .option-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #ffffff;
    }

    .option-desc {
        font-size: 0.78rem;
        color: var(--text-muted);
        font-weight: 300;
    }

    /* CUSTOM DROPZONE FILE INPUT BUTTONS */
    .file-dropzone-custom {
        position: relative;
        width: 100%;
    }

    .file-hidden-input {
        position: absolute;
        inset: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 10;
    }

    .file-dropzone-label {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.85rem 1.15rem;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.025);
        border: 1px dashed rgba(255, 255, 255, 0.2);
        cursor: pointer;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .file-dropzone-custom:hover .file-dropzone-label {
        background: rgba(255, 255, 255, 0.06);
        border-color: var(--insta-magenta);
        box-shadow: 0 6px 20px rgba(225, 48, 108, 0.25);
        transform: translateY(-2px);
    }

    .dropzone-badge-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--insta-blue), var(--insta-purple));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #ffffff;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .dropzone-info-text {
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
        overflow: hidden;
    }

    .dropzone-btn-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .dropzone-file-name {
        font-size: 0.78rem;
        color: var(--text-muted);
        font-weight: 300;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 260px;
    }

    .dropzone-file-name.has-file {
        color: var(--insta-yellow);
        font-weight: 600;
    }

    /* Live Preview Boxes */
    .preview-box-container {
        margin-top: 0.85rem;
        border-radius: 14px;
        overflow: hidden;
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid var(--border-color);
        padding: 0.5rem;
        display: none;
    }

    .preview-box-container img {
        width: 100%;
        max-height: 220px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
    }

    .preview-box-container video {
        width: 100%;
        max-height: 240px;
        border-radius: 10px;
        outline: none;
        display: block;
    }

    .preview-box-container audio {
        width: 100%;
        margin-top: 0.25rem;
        outline: none;
    }

    /* UPLOAD PROGRESS BAR OVERLAY */
    .upload-progress-modal {
        position: fixed;
        inset: 0;
        background: rgba(5, 5, 8, 0.88);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        animation: fadeIn 0.3s ease;
    }

    .upload-progress-card {
        background: rgba(18, 19, 28, 0.96);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 24px;
        padding: 2.2rem;
        max-width: 520px;
        width: 100%;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7);
    }

    .progress-header {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .progress-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--insta-purple), var(--insta-magenta), var(--insta-orange));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #ffffff;
        box-shadow: 0 8px 25px rgba(225, 48, 108, 0.4);
        animation: pulseIcon 2s infinite;
    }

    @keyframes pulseIcon {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.06); }
    }

    .progress-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 0.25rem 0;
    }

    .progress-subtitle {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin: 0;
    }

    .progress-bar-track {
        width: 100%;
        height: 12px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.08);
        overflow: hidden;
        margin-bottom: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .progress-bar-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, var(--insta-blue) 0%, var(--insta-purple) 35%, var(--insta-magenta) 70%, var(--insta-orange) 100%);
        background-size: 200% 100%;
        border-radius: 10px;
        transition: width 0.2s ease;
        box-shadow: 0 0 15px rgba(225, 48, 108, 0.6);
    }

    .progress-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.88rem;
    }

    .progress-percentage {
        font-weight: 700;
        color: var(--insta-yellow);
        font-size: 1.1rem;
    }

    .progress-bytes {
        color: var(--text-secondary);
        font-weight: 400;
    }
</style>

<!-- UPLOAD PROGRESS MODAL -->
<div class="upload-progress-modal" id="uploadProgressModal" style="display: none;">
    <div class="upload-progress-card">
        <div class="progress-header">
            <div class="progress-icon">
                <i class="fa-solid fa-cloud-arrow-up"></i>
            </div>
            <div>
                <h3 class="progress-title" id="progressTitleText">Subiendo Archivos y Guardando...</h3>
                <p class="progress-subtitle" id="progressStatusText">Por favor espera mientras se procesa la carga multimedia.</p>
            </div>
        </div>

        <div class="progress-bar-track">
            <div class="progress-bar-fill" id="progressBarFill"></div>
        </div>

        <div class="progress-footer">
            <span class="progress-percentage" id="progressPercentText">0%</span>
            <span class="progress-bytes" id="progressBytesText">0 MB / 0 MB</span>
        </div>
    </div>
</div>

<div class="admin-card glass" style="max-width: 850px; margin: 0 auto;">
    <div class="admin-card-title">
        <i class="fa-solid fa-plane-circle-check"></i>
        Detalles de la Bitácora de Viaje
    </div>

    <form action="{{ route('admin.travels.store') }}" method="POST" enctype="multipart/form-data" id="travelForm">
        @csrf

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="title" class="form-label">Destino / Título *</label>
                <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" placeholder="Ej. Machu Picchu" required>
            </div>
            
            <div class="form-group">
                <label for="order" class="form-label">Orden de Prioridad *</label>
                <input type="number" name="order" id="order" class="form-input" value="{{ old('order', 0) }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
                <label for="location" class="form-label">Lugar / Ciudad</label>
                <input type="text" name="location" id="location" class="form-input" value="{{ old('location') }}" placeholder="Ej. Cusco">
            </div>

            <div class="form-group">
                <label for="country" class="form-label">País</label>
                <input type="text" name="country" id="country" class="form-input" value="{{ old('country') }}" placeholder="Ej. Perú">
            </div>

            <div class="form-group">
                <label for="year" class="form-label">Año</label>
                <input type="text" name="year" id="year" class="form-input" value="{{ old('year', '2025') }}" placeholder="Ej. 2025">
            </div>

            <div class="form-group">
                <label for="travel_date" class="form-label">Fecha del Viaje</label>
                <input type="text" name="travel_date" id="travel_date" class="form-input" value="{{ old('travel_date') }}" placeholder="Ej. 15 de Octubre, 2025">
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Resumen Breve (Aparece en la tarjeta) *</label>
            <textarea name="description" id="description" class="form-input" style="min-height: 90px;" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="content" class="form-label">Bitácora Completa / Reseña Extendida (Página de detalles)</label>
            <textarea name="content" id="content" class="form-input" style="min-height: 150px; line-height: 1.7;" placeholder="Escribe la experiencia completa, reflexiones, ruta del viaje y detalles fotográficos...">{{ old('content') }}</textarea>
        </div>

        <!-- Media Config Section -->
        <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); padding: 1.75rem; border-radius: 18px; margin-bottom: 1.75rem;">
            <h4 style="margin: 0 0 1.25rem 0; font-size: 1.05rem; color: #ffffff; display: flex; align-items: center; gap: 0.6rem;">
                <i class="fa-solid fa-photo-film" style="color: var(--insta-orange);"></i>
                Configuración Multimedia, Videos & Audio
            </h4>

            <!-- Selection Cards for Media Type -->
            <label class="form-label">Tipo de Contenido en el Cuadro Izquierdo *</label>
            <div class="media-type-selector">
                <div class="media-option-card {{ old('media_type', 'image') === 'image' ? 'active' : '' }}" id="cardMediaImage" onclick="selectMediaTypeCard('image')">
                    <input type="radio" name="media_type" value="image" {{ old('media_type', 'image') === 'image' ? 'checked' : '' }} style="display:none;" id="radioMediaImage">
                    <div class="option-icon"><i class="fa-solid fa-camera"></i></div>
                    <div class="option-info">
                        <span class="option-title">Fotografía / Imagen</span>
                        <span class="option-desc">Muestra una foto en el cuadro izquierdo</span>
                    </div>
                </div>

                <div class="media-option-card {{ old('media_type') === 'video' ? 'active' : '' }}" id="cardMediaVideo" onclick="selectMediaTypeCard('video')">
                    <input type="radio" name="media_type" value="video" {{ old('media_type') === 'video' ? 'checked' : '' }} style="display:none;" id="radioMediaVideo">
                    <div class="option-icon"><i class="fa-solid fa-video"></i></div>
                    <div class="option-info">
                        <span class="option-title">Reproductor de Video</span>
                        <span class="option-desc">Muestra un video simple en el cuadro izquierdo</span>
                    </div>
                </div>
            </div>

            <!-- Upload Fields Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Image Input + Custom Dropzone -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="image" class="form-label" style="color: #ffffff;">
                        <i class="fa-solid fa-image" style="color: var(--insta-orange); margin-right: 0.35rem;"></i>
                        Imagen de Fondo 100vh * <span style="font-size: 0.72rem; color: #4ade80; text-transform: none;">(Fotos HD / Gran Peso hasta 100 MB)</span>
                    </label>

                    <div class="file-dropzone-custom">
                        <input type="file" name="image" id="image" class="file-hidden-input" accept="image/*" onchange="handleFileDropzoneSelect(this, 'imgFileName', previewImageLive)" required>
                        <div class="file-dropzone-label">
                            <div class="dropzone-badge-icon" style="background: linear-gradient(135deg, var(--insta-orange), var(--insta-yellow));">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <div class="dropzone-info-text">
                                <span class="dropzone-btn-title"><i class="fa-solid fa-folder-open"></i> Subir Imagen (Alta Calidad)</span>
                                <span class="dropzone-file-name" id="imgFileName">Ningún archivo seleccionado</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="preview-box-container" id="imagePreviewBox">
                        <img id="imagePreviewImg" src="" alt="Previsualización de Imagen">
                    </div>
                </div>

                <!-- Video Input + Custom Dropzone -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="video" class="form-label" style="color: #ffffff;">
                        <i class="fa-solid fa-video" style="color: var(--insta-orange); margin-right: 0.35rem;"></i>
                        Archivo de Video <span style="font-size: 0.72rem; color: #4ade80; text-transform: none;">(Máx. 2 GB)</span>
                        <span id="videoReqBadge" style="font-size: 0.72rem; color: var(--insta-orange); text-transform: none; font-weight: 700; display: {{ old('media_type') === 'video' ? 'inline-block' : 'none' }};">(OBLIGATORIO)</span>
                    </label>

                    <div class="file-dropzone-custom">
                        <input type="file" name="video" id="video" class="file-hidden-input" accept="video/mp4,video/webm,video/ogg,video/quicktime" onchange="handleFileDropzoneSelect(this, 'vidFileName', previewVideoLive)" {{ old('media_type') === 'video' ? 'required' : '' }}>
                        <div class="file-dropzone-label">
                            <div class="dropzone-badge-icon" style="background: linear-gradient(135deg, var(--insta-magenta), var(--insta-orange));">
                                <i class="fa-solid fa-video"></i>
                            </div>
                            <div class="dropzone-info-text">
                                <span class="dropzone-btn-title"><i class="fa-solid fa-film"></i> Subir Video (Hasta 2GB)</span>
                                <span class="dropzone-file-name" id="vidFileName">Ningún archivo seleccionado</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="preview-box-container" id="videoPreviewBox">
                        <video id="videoPreviewVid" controls></video>
                    </div>
                    <div style="font-size: 0.72rem; color: rgba(255,255,255,0.45); margin-top: 0.4rem; line-height: 1.3;">
                        💡 <strong>Recomendación:</strong> Usa videos en formato MP4 con códec <strong>H.264 (AVC)</strong> para reproducción universal inmediata en Chrome, Edge y móviles.
                    </div>
                </div>
            </div>

            <!-- Audio Input + Custom Dropzone -->
            <div class="form-group" style="margin-bottom: 0; margin-top: 1.5rem;">
                <label for="audio" class="form-label" style="color: #ffffff;">
                    <i class="fa-solid fa-music" style="color: var(--insta-magenta); margin-right: 0.35rem;"></i>
                    Música / Pista de Audio de Fondo <span style="font-size: 0.72rem; color: var(--text-muted); text-transform: none;">(Opcional)</span>
                </label>

                <div class="file-dropzone-custom">
                    <input type="file" name="audio" id="audio" class="file-hidden-input" accept="audio/mp3,audio/wav,audio/m4a,audio/ogg" onchange="handleFileDropzoneSelect(this, 'audFileName', previewAudioLive)">
                    <div class="file-dropzone-label">
                        <div class="dropzone-badge-icon" style="background: linear-gradient(135deg, var(--insta-blue), var(--insta-purple));">
                            <i class="fa-solid fa-music"></i>
                        </div>
                        <div class="dropzone-info-text">
                            <span class="dropzone-btn-title"><i class="fa-solid fa-headphones"></i> Subir Pista de Audio (.mp3)</span>
                            <span class="dropzone-file-name" id="audFileName">Ningún archivo seleccionado</span>
                        </div>
                    </div>
                </div>
                
                <div class="preview-box-container" id="audioPreviewBox" style="padding: 0.75rem;">
                    <audio id="audioPreviewAud" controls></audio>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.travels.index') }}" class="btn-action-text" style="display: flex; align-items: center; justify-content: center;">
                Cancelar
            </a>
            <button type="submit" class="btn-primary" id="btnSubmitTravel">
                <i class="fa-solid fa-plus"></i>
                Crear Viaje
            </button>
        </div>
    </form>
</div>

<script>
    const MAX_VIDEO_SIZE = 2048 * 1024 * 1024; // 2 GB (2048 MB)

    function selectMediaTypeCard(type) {
        const cardImg = document.getElementById('cardMediaImage');
        const cardVid = document.getElementById('cardMediaVideo');
        const radioImg = document.getElementById('radioMediaImage');
        const radioVid = document.getElementById('radioMediaVideo');
        const videoInput = document.getElementById('video');
        const videoReqBadge = document.getElementById('videoReqBadge');
        
        if (type === 'image') {
            if (radioImg) radioImg.checked = true;
            if (radioVid) radioVid.checked = false;
            if (cardImg) cardImg.classList.add('active');
            if (cardVid) cardVid.classList.remove('active');
            if (videoInput) videoInput.required = false;
            if (videoReqBadge) videoReqBadge.style.display = 'none';
        } else {
            if (radioVid) radioVid.checked = true;
            if (radioImg) radioImg.checked = false;
            if (cardVid) cardVid.classList.add('active');
            if (cardImg) cardImg.classList.remove('active');
            if (videoInput) videoInput.required = true;
            if (videoReqBadge) videoReqBadge.style.display = 'inline-block';
        }
    }

    function handleFileDropzoneSelect(input, displayId, previewCallback) {
        const displayEl = document.getElementById(displayId);
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Client-side 2GB Video Check
            if (input.id === 'video' && file.size > MAX_VIDEO_SIZE) {
                alert('El archivo de video seleccionado supera el límite máximo permitido de 2 GB (2048 MB) (Tamaño actual: ' + (file.size / (1024*1024)).toFixed(1) + ' MB). Por favor elige un archivo más pequeño.');
                input.value = '';
                displayEl.textContent = 'Ningún archivo seleccionado';
                displayEl.classList.remove('has-file');
                return;
            }

            displayEl.textContent = '✓ ' + file.name + ' (' + (file.size / (1024*1024)).toFixed(1) + ' MB)';
            displayEl.classList.add('has-file');
            if (typeof previewCallback === 'function') {
                previewCallback(input);
            }
        }
    }

    // Live Image Preview
    function previewImageLive(input) {
        const box = document.getElementById('imagePreviewBox');
        const img = document.getElementById('imagePreviewImg');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                box.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Live Video Preview
    function previewVideoLive(input) {
        selectMediaTypeCard('video');
        const box = document.getElementById('videoPreviewBox');
        const vid = document.getElementById('videoPreviewVid');
        
        if (input.files && input.files[0]) {
            const url = URL.createObjectURL(input.files[0]);
            vid.src = url;
            box.style.display = 'block';
        }
    }

    // Live Audio Preview
    function previewAudioLive(input) {
        const box = document.getElementById('audioPreviewBox');
        const aud = document.getElementById('audioPreviewAud');
        
        if (input.files && input.files[0]) {
            const url = URL.createObjectURL(input.files[0]);
            aud.src = url;
            box.style.display = 'block';
        }
    }

    // AJAX Form Upload with Progressive 60fps MB Counting & Smooth Fill
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('travelForm');
        const modal = document.getElementById('uploadProgressModal');
        const barFill = document.getElementById('progressBarFill');
        const percentText = document.getElementById('progressPercentText');
        const bytesText = document.getElementById('progressBytesText');

        if (form && modal) {
            form.addEventListener('submit', function(e) {
                // Validate HTML5 inputs before showing progress modal
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                e.preventDefault();

                const formData = new FormData(form);
                const xhr = new XMLHttpRequest();

                modal.style.display = 'flex';
                barFill.style.width = '0%';
                percentText.textContent = '0%';
                bytesText.textContent = 'Calculando transferencia...';

                let displayPercent = 0;
                let targetPercent = 0;
                let totalBytes = 0;
                let loadedBytes = 0;
                let isComplete = false;

                // Smooth 60fps Interpolation Timer
                const animInterval = setInterval(function() {
                    if (isComplete) return;

                    // Interpolate displayPercent smoothly towards targetPercent
                    if (displayPercent < targetPercent) {
                        displayPercent += Math.max(0.4, (targetPercent - displayPercent) * 0.18);
                        if (displayPercent > targetPercent) displayPercent = targetPercent;
                    }

                    const val = Math.min(99, Math.floor(displayPercent));
                    barFill.style.width = displayPercent.toFixed(1) + '%';
                    percentText.textContent = val + '%';

                    if (totalBytes > 0) {
                        const currentMB = ((totalBytes * (displayPercent / 100)) / (1024 * 1024)).toFixed(1);
                        const totalMB = (totalBytes / (1024 * 1024)).toFixed(1);
                        bytesText.textContent = currentMB + ' MB / ' + totalMB + ' MB';
                    } else {
                        bytesText.textContent = 'Procesando datos en el servidor...';
                    }
                }, 30);

                xhr.upload.addEventListener('progress', function(event) {
                    if (event.lengthComputable && event.total > 0) {
                        totalBytes = event.total;
                        loadedBytes = event.loaded;
                        // Map physical upload phase to 0% -> 90%
                        const realProgress = (event.loaded / event.total) * 90;
                        targetPercent = Math.max(targetPercent, Math.round(realProgress));
                    }
                });

                xhr.onload = function() {
                    isComplete = true;
                    clearInterval(animInterval);

                    if (xhr.status >= 200 && xhr.status < 350) {
                        barFill.style.width = '100%';
                        percentText.textContent = '100%';

                        if (totalBytes > 0) {
                            const totalMB = (totalBytes / (1024 * 1024)).toFixed(1);
                            bytesText.textContent = totalMB + ' MB / ' + totalMB + ' MB - ¡Guardado con éxito!';
                        } else {
                            bytesText.textContent = '¡Proceso completado!';
                        }

                        setTimeout(function() {
                            window.location.href = "{{ route('admin.travels.index') }}";
                        }, 450);
                    } else if (xhr.status === 422) {
                        modal.style.display = 'none';
                        let errorMsg = 'Error de validación:\n';
                        try {
                            const res = JSON.parse(xhr.responseText);
                            if (res.errors) {
                                for (let field in res.errors) {
                                    errorMsg += '• ' + res.errors[field].join(', ') + '\n';
                                }
                            } else if (res.message) {
                                errorMsg += '• ' + res.message;
                            }
                        } catch(err) {
                            errorMsg += 'Revisa los campos requeridos del formulario.';
                        }
                        alert(errorMsg);
                    } else if (xhr.status === 413) {
                        modal.style.display = 'none';
                        alert('El servidor web bloqueó la carga por superar el límite de tamaño (Error HTTP 413 Payload Too Large).\n\nSe incluyeron los archivos de configuración .htaccess y .user.ini para 2GB. Si tu servidor usa Nginx o cPanel, solicita aumentar "client_max_body_size 2048M" o "upload_max_filesize" en cPanel.');
                    } else {
                        modal.style.display = 'none';
                        alert('Ocurrió un error al procesar la solicitud (Código HTTP ' + xhr.status + ').');
                    }
                };

                xhr.onerror = function() {
                    isComplete = true;
                    clearInterval(animInterval);
                    modal.style.display = 'none';
                    alert('Error de conexión al intentar enviar los archivos.');
                };

                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.send(formData);
            });
        }
    });
</script>

@endsection
