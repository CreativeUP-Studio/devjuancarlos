<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>{{ $travel->title }} - {{ $profile->name ?? 'Portafolio Profesional' }}</title>
    <meta name="description" content="{{ Str::limit($travel->description, 155) }}">
    <meta name="author" content="{{ $profile->name ?? 'Juan Carlos Chahuayo Martínez' }}">
    
    <!-- Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Alex+Brush&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --insta-blue: #405de6;
            --insta-purple: #833ab4;
            --insta-magenta: #e1306c;
            --insta-orange: #f56040;
            --insta-yellow: #fcaf45;
        }

        html, body {
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            background-color: #050508;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            overflow: hidden !important;
        }

        /* Custom Scrollbar for Story Box */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.2); }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--insta-magenta); }

        /* ----------------------------------------------------
           1. FIXED TOP NAVBAR (COMPLETELY TRANSPARENT)
        ---------------------------------------------------- */
        .fixed-travel-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 85px;
            padding: 1.25rem 6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            z-index: 1000;
            box-sizing: border-box;
            pointer-events: none;
        }

        .fixed-travel-nav * {
            pointer-events: auto;
        }

        .nav-right-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-back-home {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #ffffff;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.6rem 1.25rem;
            border-radius: 30px;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .btn-back-home:hover {
            background: rgba(0, 0, 0, 0.7);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateX(-3px);
            color: #ffffff;
        }

        /* Music Toggle Button Top Right (Neutral Dark Glass) */
        .btn-music-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-music-toggle:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.7);
            transform: scale(1.08);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }

        .btn-music-toggle.playing {
            background: rgba(255, 255, 255, 0.22);
            border-color: rgba(255, 255, 255, 0.85);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.35);
        }

        .btn-music-toggle.playing i {
            animation: spin-note 3s linear infinite;
        }

        @keyframes spin-note {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Logo Brand Style */
        .travel-brand-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .brand-icon-script {
            font-family: 'Alex Brush', cursive;
            font-size: 3.2rem;
            color: #ffffff;
            line-height: 1;
            cursor: pointer;
            transition: all 0.4s ease;
            filter: drop-shadow(0 0 12px rgba(225, 48, 108, 0.3));
        }

        .brand-icon-script:hover {
            background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-purple) 25%, var(--insta-magenta) 50%, var(--insta-orange) 75%, var(--insta-yellow) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 18px rgba(225, 48, 108, 0.6));
        }

        /* ----------------------------------------------------
           2. FULLSCREEN BACKGROUND + SPLIT LAYOUT (EXACT 100vh)
        ---------------------------------------------------- */
        .fullscreen-travel-hero {
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            box-sizing: border-box;
            padding: 90px 6% 40px;
            overflow: hidden;
        }

        .travel-hero-bg-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(5, 5, 8, 0.85) 0%,
                rgba(5, 5, 8, 0.72) 50%,
                rgba(5, 5, 8, 0.92) 100%
            );
            z-index: 1;
        }

        .split-content-container {
            position: relative;
            z-index: 2;
            max-width: 1250px;
            width: 100%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(320px, 440px) 1fr;
            gap: 3.5rem;
            align-items: center;
            max-height: calc(100vh - 130px);
        }

        /* Left Side: Square Media Container (Photo or Video Player) */
        .square-media-card {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            max-height: 440px;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(255, 255, 255, 0.05);
            background: #0d0d12;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.4s ease;
        }

        .square-media-card:hover {
            transform: translateY(-4px) scale(1.01);
            border-color: rgba(255, 255, 255, 0.35);
        }

        .square-media-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 24px;
        }

        .square-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.2);
            font-size: 4rem;
            background: linear-gradient(135deg, #0a0a10 0%, #151520 100%);
        }

        /* ----------------------------------------------------
           3. MINIMALIST VIDEO PLAYER (ONLY PLAY & PAUSE BUTTON)
        ---------------------------------------------------- */
        .custom-video-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 24px;
            overflow: hidden;
            background: #000;
            cursor: pointer;
        }

        .custom-video-wrapper video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .video-overlay-controls {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 10;
        }

        .custom-video-wrapper:hover .video-overlay-controls,
        .custom-video-wrapper.is-paused .video-overlay-controls {
            opacity: 1;
        }

        /* Minimalist Center Play/Pause Button (Neutral Dark Glass) */
        .center-play-btn {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
        }

        .center-play-btn:hover {
            transform: scale(1.08);
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.7);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
        }

        /* Right Side: Details */
        .details-right-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-height: calc(100vh - 140px);
        }

        .travel-location-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--insta-yellow);
            margin-bottom: 1rem;
            background: rgba(252, 175, 69, 0.12);
            border: 1px solid rgba(252, 175, 69, 0.25);
            padding: 0.4rem 1rem;
            border-radius: 30px;
            width: fit-content;
        }

        .travel-detail-title {
            font-size: clamp(2rem, 3.8vw, 3.4rem);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -1px;
            margin: 0 0 0.85rem 0;
            color: #ffffff;
        }

        /* Date Highlight Pill */
        .travel-date-highlight {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.92rem;
            color: rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 0.45rem 1rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
            width: fit-content;
        }

        .travel-date-highlight i {
            color: var(--insta-orange);
        }

        /* Meta Pills Row */
        .travel-meta-pills-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .meta-pill-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.95rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.88);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .meta-pill-item i {
            color: var(--insta-orange);
        }

        /* Story Box (Glass Panel) */
        .glass-story-panel {
            background: rgba(255, 255, 255, 0.035);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 1.5rem 1.75rem;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            max-height: 320px;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .glass-story-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 0.85rem 0;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .glass-story-title i {
            color: var(--insta-magenta);
        }

        .glass-story-desc {
            font-size: 1rem;
            line-height: 1.7;
            color: #ffffff;
            font-weight: 400;
            margin: 0 0 1rem 0;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-story-text {
            font-size: 0.95rem;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 300;
            white-space: pre-line;
            margin: 0;
        }

        /* ----------------------------------------------------
           4. RESPONSIVE MEDIA QUERIES FOR TABLET & MOBILE
        ---------------------------------------------------- */
        @media (max-width: 1024px) {
            .fullscreen-travel-hero {
                padding: 90px 4% 30px;
            }

            .split-content-container {
                grid-template-columns: minmax(280px, 360px) 1fr;
                gap: 2.5rem;
            }

            .square-media-card {
                max-height: 360px;
            }

            .glass-story-panel {
                max-height: 280px;
            }
        }

        @media (max-width: 768px) {
            html, body {
                height: auto !important;
                min-height: 100vh !important;
                overflow-x: hidden !important;
                overflow-y: auto !important;
            }

            .fixed-travel-nav {
                height: 70px;
                padding: 0.85rem 4%;
            }

            .brand-icon-script {
                font-size: 2.5rem;
            }

            .btn-back-home {
                padding: 0.55rem 1rem;
                font-size: 0.8rem;
            }

            .btn-music-toggle {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .fullscreen-travel-hero {
                height: auto;
                min-height: 100vh;
                padding: 85px 4% 40px;
                align-items: flex-start;
                overflow-y: visible;
            }

            .split-content-container {
                grid-template-columns: 1fr;
                gap: 1.75rem;
                max-height: none;
                overflow: visible;
            }

            .square-media-card {
                max-height: 340px;
                border-radius: 18px;
                margin: 0 auto;
                max-width: 360px;
            }

            .details-right-panel {
                max-height: none;
            }

            .travel-detail-title {
                font-size: 2.1rem;
                letter-spacing: -0.5px;
                margin-bottom: 0.65rem;
            }

            .travel-location-badge {
                font-size: 0.72rem;
                letter-spacing: 1.8px;
                padding: 0.35rem 0.85rem;
                margin-bottom: 0.75rem;
            }

            .travel-date-highlight {
                font-size: 0.85rem;
                padding: 0.4rem 0.85rem;
                margin-bottom: 1rem;
            }

            .travel-meta-pills-row {
                gap: 0.5rem;
                margin-bottom: 1rem;
            }

            .meta-pill-item {
                font-size: 0.78rem;
                padding: 0.35rem 0.75rem;
                border-radius: 10px;
            }

            .glass-story-panel {
                max-height: none;
                padding: 1.25rem 1.4rem;
                border-radius: 16px;
            }

            .glass-story-title {
                font-size: 1rem;
            }

            .glass-story-desc {
                font-size: 0.92rem;
                line-height: 1.6;
            }

            .glass-story-text {
                font-size: 0.88rem;
                line-height: 1.65;
            }
        }

        @media (max-width: 480px) {
            .btn-back-home span {
                display: none;
            }

            .btn-back-home {
                padding: 0.5rem;
                border-radius: 50%;
                width: 38px;
                height: 38px;
                justify-content: center;
            }

            .square-media-card {
                max-height: 280px;
                border-radius: 16px;
            }

            .travel-detail-title {
                font-size: 1.85rem;
            }

            .center-play-btn {
                width: 56px;
                height: 56px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

    @php
        // Media & Cover setup
        $hasCustomAudio = !empty($travel->audio_path);
        $travelAudioUrl = $hasCustomAudio ? asset($travel->audio_path) : '';
        $travelHeroBgUrl = $travel->image_path ? asset($travel->image_path) : asset('images/hero-bg.jpg');
        $locationText = $travel->location ?? 'Destino Destacado';
        $countryText = $travel->country ?? 'Perú';
        $yearText = $travel->year ?? '2025';
        $travelDateText = $travel->travel_date ?? ($yearText . ' · ' . $locationText);
    @endphp

    <!-- Audio Player element if music is assigned -->
    @if($hasCustomAudio)
        <audio id="travelAudioTrack" src="{{ $travelAudioUrl }}" loop preload="metadata"></audio>
    @endif

    <!-- ----------------------------------------------------
       1. FIXED TOP NAVBAR (COMPLETELY TRANSPARENT)
    ---------------------------------------------------- -->
    <nav class="fixed-travel-nav">
        <!-- Left: Brand Logo -->
        <a href="{{ route('portfolio.index') }}#viajes" class="travel-brand-logo" title="Volver al inicio">
            <span class="brand-icon-script">JC</span>
        </a>

        <!-- Right: Action Buttons (Back + Music Toggle) -->
        <div class="nav-right-actions">
            @if($hasCustomAudio)
                <button class="btn-music-toggle" id="travelMusicBtn" title="Reproducir música de este viaje" aria-label="Música">
                    <i class="fa-solid fa-music"></i>
                </button>
            @endif

            <a href="{{ route('portfolio.index') }}#viajes" class="btn-back-home">
                <i class="fa-solid fa-arrow-left-long"></i>
                <span>Volver a Viajes</span>
            </a>
        </div>
    </nav>

    <!-- ----------------------------------------------------
       2. FULLSCREEN BACKGROUND + SPLIT LAYOUT (EXACT 100vh)
       Left: Square Media Card (Image or Video) | Right: Details & Bitácora
    ---------------------------------------------------- -->
    <header class="fullscreen-travel-hero" style="background-image: url('{{ $travelHeroBgUrl }}');">
        <div class="travel-hero-bg-overlay"></div>

        <div class="split-content-container">
            <!-- Left Side: Square Media Container (Photo or Video Player) -->
            <div class="square-media-card">
                @if($travel->media_type === 'video' && $travel->video_path)
                    <!-- MINIMALIST PLAY / PAUSE VIDEO PLAYER -->
                    <div class="custom-video-wrapper" id="customVideoWrapper">
                        <video id="customTravelVideo" poster="{{ $travelHeroBgUrl }}" autoplay loop muted playsinline>
                            <source src="{{ asset($travel->video_path) }}" type="video/mp4">
                            Tu navegador no soporta la reproducción de video.
                        </video>

                        <!-- Video Overlay Controls (Play/Pause Only) -->
                        <div class="video-overlay-controls" id="videoOverlayControls">
                            <button class="center-play-btn" id="centerPlayBtn" aria-label="Play/Pause">
                                <i class="fa-solid fa-pause" id="centerPlayIcon"></i>
                            </button>
                        </div>
                    </div>
                @elseif($travel->image_path)
                    <img src="{{ asset($travel->image_path) }}" alt="{{ $travel->title }}">
                @else
                    <div class="square-placeholder">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                @endif
            </div>

            <!-- Right Side: Details -->
            <div class="details-right-panel">
                <span class="travel-location-badge">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $locationText }} · {{ $countryText }} · {{ $yearText }}
                </span>

                <h1 class="travel-detail-title">{{ $travel->title }}</h1>

                <!-- Fecha del Viaje Highlight -->
                <div class="travel-date-highlight">
                    <i class="fa-solid fa-calendar-day"></i>
                    <span><strong>Fecha del Viaje:</strong> {{ $travelDateText }}</span>
                </div>

                <!-- Meta Pills -->
                <div class="travel-meta-pills-row">
                    <div class="meta-pill-item">
                        <i class="fa-solid fa-earth-americas"></i>
                        <span><strong>País:</strong> {{ $countryText }}</span>
                    </div>

                    <div class="meta-pill-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span><strong>Lugar:</strong> {{ $locationText }}</span>
                    </div>

                    <div class="meta-pill-item">
                        <i class="fa-regular fa-calendar"></i>
                        <span><strong>Año:</strong> {{ $yearText }}</span>
                    </div>
                </div>

                <!-- Story Box: Resumen & Bitácora Completa -->
                <div class="glass-story-panel">
                    <h2 class="glass-story-title">
                        <i class="fa-solid fa-book-open"></i>
                        Reseña & Bitácora del Destino
                    </h2>

                    @if($travel->description)
                        <p class="glass-story-desc">{{ $travel->description }}</p>
                    @endif

                    @if($travel->content)
                        <p class="glass-story-text">{{ $travel->content }}</p>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- JS Script (Music Audio Player + Minimalist Play/Pause Video Controls) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Background Audio Music Button & Autoplay Logic
            const musicBtn = document.getElementById('travelMusicBtn');
            const audioTrack = document.getElementById('travelAudioTrack');
            const isImageOnlyMode = {{ ($travel->media_type !== 'video' || !$travel->video_path) && !empty($travel->audio_path) ? 'true' : 'false' }};

            if (audioTrack) {
                function startAudio() {
                    audioTrack.play().then(() => {
                        if (musicBtn) {
                            musicBtn.classList.add('playing');
                            musicBtn.setAttribute('title', 'Pausar música');
                        }
                    }).catch(err => {
                        console.log('Autoplay deferred:', err);
                        // Trigger on first user interaction if browser blocked instant autoplay
                        const unlockAudio = function() {
                            audioTrack.play().then(() => {
                                if (musicBtn) {
                                    musicBtn.classList.add('playing');
                                    musicBtn.setAttribute('title', 'Pausar música');
                                }
                            }).catch(e => {});
                        };
                        document.addEventListener('click', unlockAudio, { once: true });
                        document.addEventListener('touchstart', unlockAudio, { once: true });
                    });
                }

                // Autoplay music automatically if photo-only mode
                if (isImageOnlyMode) {
                    startAudio();
                }

                if (musicBtn) {
                    musicBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (audioTrack.paused) {
                            startAudio();
                        } else {
                            audioTrack.pause();
                            musicBtn.classList.remove('playing');
                            musicBtn.setAttribute('title', 'Reproducir música de este viaje');
                        }
                    });

                    audioTrack.addEventListener('ended', function() {
                        musicBtn.classList.remove('playing');
                    });
                }
            }

            // Minimalist Play/Pause Video Controls Logic
            const videoWrapper = document.getElementById('customVideoWrapper');
            const video = document.getElementById('customTravelVideo');
            const centerPlayBtn = document.getElementById('centerPlayBtn');
            const centerPlayIcon = document.getElementById('centerPlayIcon');

            if (video && videoWrapper) {
                function togglePlay(e) {
                    if (e) e.stopPropagation();
                    if (video.paused) {
                        video.play().catch(err => console.log('Playback error:', err));
                    } else {
                        video.pause();
                    }
                }

                function updatePlayState() {
                    if (video.paused) {
                        videoWrapper.classList.add('is-paused');
                        if (centerPlayIcon) centerPlayIcon.className = 'fa-solid fa-play';
                    } else {
                        videoWrapper.classList.remove('is-paused');
                        if (centerPlayIcon) centerPlayIcon.className = 'fa-solid fa-pause';
                    }
                }

                if (centerPlayBtn) {
                    centerPlayBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        togglePlay();
                    });
                }
                
                videoWrapper.addEventListener('click', function(e) {
                    togglePlay();
                });

                video.addEventListener('play', updatePlayState);
                video.addEventListener('pause', updatePlayState);

                // Initial sync
                updatePlayState();
            }
        });
    </script>
</body>
</html>
