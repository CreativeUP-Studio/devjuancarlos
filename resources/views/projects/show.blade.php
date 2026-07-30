@php
    $pageTitle = $project->title . ' | ' . ($profile->name ?? 'Juan Carlos') . ' - Caso de Estudio';
    $pageDesc = Str::limit(strip_tags($project->description), 160);
    $canonicalUrl = request()->url();
    $projectImage = $project->image_path ? asset($project->image_path) : asset('images/nav_inicio.png');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Primary SEO Meta Tags -->
    <title>{{ $pageTitle }}</title>
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="author" content="{{ $profile->name ?? 'Juan Carlos' }}">
    <meta name="keywords" content="{{ $project->title }}, {{ $project->tech_stack ?? 'Software' }}, Desarrollo Web, Proyecto, Inteligencia Artificial, Portafolio">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="theme-color" content="#050508">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Favicons & App Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.svg') }}">

    <!-- Open Graph / Facebook / WhatsApp / LinkedIn -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:image" content="{{ $projectImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $project->title }}">
    <meta property="og:site_name" content="{{ $profile->name ?? 'Juan Carlos' }} - Proyectos">
    <meta property="og:locale" content="es_PE">

    <!-- Twitter / X Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $canonicalUrl }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    <meta name="twitter:image" content="{{ $projectImage }}">

    <!-- JSON-LD Structured Data for Software / Project Experience -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "{{ $project->title }}",
      "description": "{{ $pageDesc }}",
      "image": "{{ $projectImage }}",
      "applicationCategory": "DeveloperApplication",
      "operatingSystem": "Web",
      "author": {
        "@type": "Person",
        "name": "{{ $profile->name ?? 'Juan Carlos' }}"
      }
    }
    </script>

    <!-- Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Alex+Brush&family=Great+Vibes&display=swap" rel="stylesheet">
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

        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #111111;
            overflow-x: hidden;
        }

        /* ----------------------------------------------------
           1. FIXED TOP NAVBAR (COMPLETELY TRANSPARENT ALWAYS, NO BLACK BAR)
        ---------------------------------------------------- */
        .fixed-project-nav {
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

        .fixed-project-nav * {
            pointer-events: auto;
        }

        .nav-right-actions {
            display: flex;
            align-items: center;
            gap: 1.25rem;
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

        /* ----------------------------------------------------
           2. FULLSCREEN HERO HEADER (100vh)
        ---------------------------------------------------- */
        .project-hero-header {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            box-sizing: border-box;
            color: #ffffff;
            overflow: hidden;
        }

        .project-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(5, 5, 8, 0.35) 0%,
                rgba(5, 5, 8, 0.15) 40%,
                rgba(5, 5, 8, 0.92) 100%
            );
            z-index: 1;
        }

        /* Hero Content inside 100vh */
        .project-hero-content {
            position: relative;
            z-index: 2;
            padding: 0 6% 4.5rem;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .hero-project-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--insta-yellow);
            margin-bottom: 1rem;
            background: rgba(252, 175, 69, 0.12);
            border: 1px solid rgba(252, 175, 69, 0.25);
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
        }

        .hero-project-title {
            font-size: clamp(2.2rem, 5vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin: 0 0 1.25rem 0;
            color: #ffffff;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .hero-tech-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .hero-tech-pill {
            padding: 0.35rem 0.8rem;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .hero-scroll-down {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .hero-scroll-down:hover {
            color: #ffffff;
        }

        .hero-scroll-down i {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(6px); }
            60% { transform: translateY(3px); }
        }

        /* ----------------------------------------------------
           3. DETAILS SECTION (WHITE BACKGROUND THEME)
        ---------------------------------------------------- */
        .project-details-section {
            background-color: #ffffff;
            color: #111111;
            padding: 6rem 6%;
            position: relative;
        }

        .details-wrapper {
            max-width: 1200px;
            margin: 0 auto;
        }

        .editorial-section-tag {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #888888;
            margin-bottom: 0.5rem;
            display: block;
        }

        .editorial-section-title {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #111111;
            margin: 0 0 3rem 0;
        }

        .editorial-section-title span {
            background: linear-gradient(135deg, var(--insta-purple) 0%, var(--insta-magenta) 50%, var(--insta-orange) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Grid Layout */
        .details-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3.5rem;
            align-items: start;
        }

        @media (max-width: 900px) {
            .details-grid {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }
        }

        /* Main Description & Steps Cards */
        .main-desc-box {
            background: #f9f9fc;
            border: 1px solid #e5e5ee;
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .main-desc-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        }

        .desc-box-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0 0 1.25rem 0;
            color: #111111;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .desc-box-title i {
            color: var(--insta-magenta);
        }

        .desc-text {
            font-size: 1.05rem;
            line-height: 1.85;
            color: #444444;
            font-weight: 300;
            white-space: pre-line;
        }

        /* Timeline / Development Steps Section */
        .steps-timeline {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .step-card {
            background: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .step-card:hover {
            transform: translateX(6px);
            border-color: var(--insta-orange);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-magenta) 100%);
            color: #ffffff;
            font-size: 1rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(225, 48, 108, 0.25);
        }

        .step-text {
            font-size: 0.98rem;
            line-height: 1.6;
            color: #333333;
            font-weight: 400;
            margin: 0;
            padding-top: 0.4rem;
        }

        /* Features Cards Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .feature-card {
            background: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 16px;
            padding: 1.6rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-magenta) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            border-color: #dddddd;
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: rgba(225, 48, 108, 0.08);
            color: var(--insta-magenta);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #111111;
            margin: 0 0 0.4rem 0;
        }

        .feature-desc {
            font-size: 0.88rem;
            color: #666666;
            line-height: 1.55;
            margin: 0;
            font-weight: 300;
        }

        /* Sidebar Styling */
        .sidebar-box {
            background: #f9f9fc;
            border: 1px solid #e5e5ee;
            border-radius: 20px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            position: sticky;
            top: 100px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        }

        .sidebar-heading {
            font-size: 1.05rem;
            font-weight: 700;
            color: #111111;
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .sidebar-heading i {
            color: var(--insta-orange);
        }

        .sidebar-tech-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .sidebar-tech-tag {
            padding: 0.4rem 0.85rem;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            color: #222222;
            font-size: 0.82rem;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }

        .action-button-stack {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn-cta-live {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.65rem;
            padding: 1rem 1.5rem;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-purple) 25%, var(--insta-magenta) 50%, var(--insta-orange) 100%);
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(225, 48, 108, 0.3);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-cta-live:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(225, 48, 108, 0.45);
            color: #ffffff;
        }

        .btn-cta-github {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.65rem;
            padding: 1rem 1.5rem;
            border-radius: 14px;
            background: #111115;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-cta-github:hover {
            background: #22222a;
            transform: translateY(-2px);
            color: #ffffff;
        }

        /* More Projects Section */
        .more-projects-wrapper {
            margin-top: 6rem;
            padding-top: 4rem;
            border-top: 1px solid #eaeaea;
        }

        .more-projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .mini-card-modern {
            background: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 18px;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03);
        }

        .mini-card-modern:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            border-color: #cccccc;
        }

        .mini-card-img-box {
            aspect-ratio: 16/10;
            overflow: hidden;
            background: #0f0f15;
        }

        .mini-card-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .mini-card-modern:hover .mini-card-img-box img {
            transform: scale(1.05);
        }

        .mini-card-content {
            padding: 1.4rem;
        }

        .mini-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #111111;
            margin: 0 0 0.4rem 0;
        }

        .mini-card-desc {
            font-size: 0.85rem;
            color: #666666;
            margin: 0;
            line-height: 1.5;
            font-weight: 300;
        }
    </style>
</head>
<body>

    @php
        $projectHeroBgUrl = $project->image_path ? asset($project->image_path) : asset('images/nav_inicio.png');
        $mainProfileHeroBgUrl = $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : asset('images/nav_inicio.png');
        $stepsList = $project->steps_array;
        $featuresList = $project->features_array;
    @endphp

    <!-- ----------------------------------------------------
       1. FIXED TOP NAVBAR (COMPLETELY TRANSPARENT AT ALL TIMES)
    ---------------------------------------------------- -->
    <nav class="fixed-project-nav" id="fixedProjectNav">
        <!-- Logo Monogram Left -->
        <a href="{{ route('portfolio.index') }}" class="navbar-brand">
            <div class="logo-container">
                <div class="logo-svg-container">
                    <svg class="logo-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="insta-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#405de6" />
                                <stop offset="25%" stop-color="#833ab4" />
                                <stop offset="50%" stop-color="#e1306c" />
                                <stop offset="75%" stop-color="#f56040" />
                                <stop offset="100%" stop-color="#fcaf45" />
                            </linearGradient>
                        </defs>
                        <text x="50%" y="72%" text-anchor="middle" class="logo-script-text">JC</text>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Right Actions: Back Button + Mobile Menu Toggle at Far Right -->
        <div class="nav-right-actions">
            <a href="{{ route('portfolio.index') }}#proyectos" class="btn-back-home">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Volver al Portafolio</span>
            </a>

            <!-- Mobile Menu Toggle Button (4-dot Grid Icon) -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Abrir menú">
                <div class="grid-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Overlay Drawer (Background image uses main profile hero image) -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <div class="menu-bg-image" style="background-image: url('{{ $mainProfileHeroBgUrl }}');"></div>
        <div class="menu-bg-overlay"></div>

        <div class="mobile-menu-content">
            <div class="mobile-menu-header">
                <div class="logo-container">
                    <div class="logo-svg-container" style="width: 50px; height: 50px;">
                        <svg class="logo-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="insta-grad-menu" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#405de6" />
                                    <stop offset="25%" stop-color="#833ab4" />
                                    <stop offset="50%" stop-color="#e1306c" />
                                    <stop offset="75%" stop-color="#f56040" />
                                    <stop offset="100%" stop-color="#fcaf45" />
                                </linearGradient>
                            </defs>
                            <text x="50%" y="72%" text-anchor="middle" class="logo-script-text">JC</text>
                        </svg>
                    </div>
                </div>

                <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Cerrar menú">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="mobile-menu-body">
                <nav class="mobile-menu-nav">
                    <a href="{{ route('portfolio.index') }}#hero" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">1</span>
                        <span class="mobile-menu-link-main">Inicio</span>
                    </a>
                    <a href="{{ route('portfolio.index') }}#biografia" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">2</span>
                        <span class="mobile-menu-link-main">Biografía</span>
                    </a>
                    <a href="{{ route('portfolio.index') }}#habilidades" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">3</span>
                        <span class="mobile-menu-link-main">Habilidades</span>
                    </a>
                    <a href="{{ route('portfolio.index') }}#proyectos" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">4</span>
                        <span class="mobile-menu-link-main">Proyectos</span>
                    </a>
                    <a href="{{ route('portfolio.index') }}#viajes" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">5</span>
                        <span class="mobile-menu-link-main">Viajes</span>
                    </a>
                    <a href="{{ route('portfolio.index') }}#contacto" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">6</span>
                        <span class="mobile-menu-link-main">Contáctame</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
       2. FULLSCREEN HERO HEADER (100vh)
    ---------------------------------------------------- -->
    <header class="project-hero-header" style="background-image: url('{{ $projectHeroBgUrl }}');">
        <div class="project-hero-overlay"></div>

        <!-- Project Hero Title Content Inside Header -->
        <div class="project-hero-content">
            <div class="hero-project-tag">
                <i class="fa-solid fa-star"></i>
                <span>Proyecto Destacado</span>
            </div>

            <h1 class="hero-project-title">{{ $project->title }}</h1>

            <!-- Tech Pills -->
            <div class="hero-tech-pills">
                @foreach($project->tech_stack_array as $tech)
                    <span class="hero-tech-pill">{{ $tech }}</span>
                @endforeach
            </div>

            <a href="#detalles" class="hero-scroll-down">
                <span>Ver especificaciones del proyecto</span>
                <i class="fa-solid fa-chevron-down"></i>
            </a>
        </div>
    </header>

    <!-- ----------------------------------------------------
       3. DETAILS SECTION (WHITE BACKGROUND THEME)
    ---------------------------------------------------- -->
    <section id="detalles" class="project-details-section">
        <div class="details-wrapper">
            <!-- Header -->
            <span class="editorial-section-tag">01 / ESPECIFICACIONES & ARQUITECTURA</span>
            <h2 class="editorial-section-title">Detalles del <span>Proyecto</span></h2>

            <!-- Main Grid -->
            <div class="details-grid">
                <!-- Left Main Block -->
                <div>
                    <!-- Main Description Box -->
                    <div class="main-desc-box">
                        <h3 class="desc-box-title">
                            <i class="fa-solid fa-circle-info"></i>
                            Descripción y Alcance
                        </h3>
                        <div class="desc-text">
                            {{ $project->description }}
                        </div>
                    </div>

                    <!-- Process / Development Steps Timeline Section -->
                    <h3 class="desc-box-title" style="margin-bottom: 1.5rem;">
                        <i class="fa-solid fa-list-check" style="color: var(--insta-blue);"></i>
                        Proceso de Desarrollo & Pasos
                    </h3>

                    <div class="steps-timeline">
                        @if(!empty($stepsList) && count($stepsList) > 0)
                            @foreach($stepsList as $index => $step)
                                <div class="step-card">
                                    <div class="step-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                    <p class="step-text">{{ $step }}</p>
                                </div>
                            @endforeach
                        @else
                            <!-- Default Generated Steps if not customized yet in admin -->
                            <div class="step-card">
                                <div class="step-number">01</div>
                                <p class="step-text"><strong>Análisis & Arquitectura:</strong> Definición del alcance, especificaciones técnicas y diseño modular de la solución.</p>
                            </div>
                            <div class="step-card">
                                <div class="step-number">02</div>
                                <p class="step-text"><strong>Desarrollo Backend & DB:</strong> Implementación de la lógica de negocio, optimización de base de datos y APIs RESTful.</p>
                            </div>
                            <div class="step-card">
                                <div class="step-number">03</div>
                                <p class="step-text"><strong>Frontend & UI/UX:</strong> Construcción de componentes responsive e interfaces dinámicas centradas en la experiencia de usuario.</p>
                            </div>
                            <div class="step-card">
                                <div class="step-number">04</div>
                                <p class="step-text"><strong>Pruebas & Despliegue:</strong> Pruebas de integración, contenerización con Docker y despliegue continuo en la nube.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Key Features & Characteristics Cards Grid -->
                    <h3 class="desc-box-title" style="margin-bottom: 1.5rem;">
                        <i class="fa-solid fa-wand-magic-sparkles" style="color: var(--insta-orange);"></i>
                        Características & Funcionalidades Clave
                    </h3>

                    <div class="features-grid">
                        @if(!empty($featuresList) && count($featuresList) > 0)
                            @foreach($featuresList as $feature)
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <i class="fa-solid fa-circle-dot"></i>
                                    </div>
                                    <p class="feature-desc" style="font-weight: 500; color: #111111;">{{ $feature }}</p>
                                </div>
                            @endforeach
                        @else
                            <!-- Default Features -->
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-microchip"></i>
                                </div>
                                <h4 class="feature-title">Arquitectura Modulada</h4>
                                <p class="feature-desc">Diseño desacoplado enfocado en alta escalabilidad y fácil mantenimiento.</p>
                            </div>

                            <div class="feature-card">
                                <div class="feature-icon" style="background: rgba(64, 93, 230, 0.08); color: var(--insta-blue);">
                                    <i class="fa-solid fa-bolt"></i>
                                </div>
                                <h4 class="feature-title">Alto Rendimiento</h4>
                                <p class="feature-desc">Carga ultrarrápida con consultas optimizadas y procesamiento paralelo.</p>
                            </div>

                            <div class="feature-card">
                                <div class="feature-icon" style="background: rgba(245, 96, 64, 0.08); color: var(--insta-orange);">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <h4 class="feature-title">Seguridad End-to-End</h4>
                                <p class="feature-desc">Validación estricta de entradas y mecanismos de protección de datos.</p>
                            </div>

                            <div class="feature-card">
                                <div class="feature-icon" style="background: rgba(131, 58, 180, 0.08); color: var(--insta-purple);">
                                    <i class="fa-solid fa-mobile-screen-button"></i>
                                </div>
                                <h4 class="feature-title">Diseño Responsive</h4>
                                <p class="feature-desc">Adaptación fluida en dispositivos móviles, tablets y computadoras.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Sticky Sidebar -->
                <aside>
                    <div class="sidebar-box">
                        <!-- Tech Stack -->
                        <div>
                            <h3 class="sidebar-heading">
                                <i class="fa-solid fa-layer-group"></i>
                                Stack Tecnológico
                            </h3>
                            <div class="sidebar-tech-grid">
                                @foreach($project->tech_stack_array as $tech)
                                    <span class="sidebar-tech-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Project Actions -->
                        <div>
                            <h3 class="sidebar-heading">
                                <i class="fa-solid fa-rocket"></i>
                                Acciones Rápidas
                            </h3>

                            <div class="action-button-stack">
                                @if($project->project_url)
                                    <a href="{{ $project->project_url }}" target="_blank" class="btn-cta-live">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        <span>Probar Demo en Vivo</span>
                                    </a>
                                @endif

                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" class="btn-cta-github">
                                        <i class="fa-brands fa-github"></i>
                                        <span>Ver Código en GitHub</span>
                                    </a>
                                @endif

                                @if(!$project->project_url && !$project->github_url)
                                    <div style="padding: 1rem; border-radius: 12px; background: #ffffff; border: 1px solid #e0e0e0; text-align: center; color: #777777; font-size: 0.85rem;">
                                        <i class="fa-solid fa-lock" style="margin-right: 0.35rem; color: var(--insta-orange);"></i>
                                        Código bajo acuerdo de privacidad
                                    </div>
                                @endif

                                <a href="{{ route('portfolio.index') }}#proyectos" style="text-align: center; color: #666666; font-size: 0.85rem; text-decoration: none; font-weight: 500; margin-top: 0.5rem;">
                                    <i class="fa-solid fa-arrow-left" style="margin-right: 0.35rem;"></i>
                                    Volver al listado de proyectos
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- More Projects Grid -->
            @if($otherProjects->isNotEmpty())
                <div class="more-projects-wrapper">
                    <span class="editorial-section-tag">02 / MÁS TRABAJOS</span>
                    <h2 class="editorial-section-title">Otros Proyectos <span>Destacados</span></h2>

                    <div class="more-projects-grid">
                        @foreach($otherProjects as $other)
                            <a href="{{ route('portfolio.projects.show', $other) }}" class="mini-card-modern">
                                <div class="mini-card-img-box">
                                    @if($other->image_path)
                                        <img src="{{ asset($other->image_path) }}" alt="{{ $other->title }}" loading="lazy">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.2); font-size: 2.5rem;">
                                            <i class="fa-solid fa-code"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="mini-card-content">
                                    <h3 class="mini-card-title">{{ $other->title }}</h3>
                                    <p class="mini-card-desc">{{ Str::limit($other->description, 80) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- ----------------------------------------------------
       4. CONTACT & HIRING FORM SECTION
    ---------------------------------------------------- -->
    <section id="contacto" style="padding: 6rem 8%; min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; box-sizing: border-box; position: relative; background: #050508; color: #ffffff; border-top: 1px solid rgba(255, 255, 255, 0.06);">
        <div class="editorial-header-global" style="position: relative; top: 0; transform: none; width: 100%; margin-bottom: 3rem;">
            <div>
                <span class="editorial-tag-global">02 / CONTACTO & CONTRATACIÓN</span>
                <h2 class="editorial-title-global">Trabajemos <span style="background: linear-gradient(135deg, var(--insta-purple) 0%, var(--insta-magenta) 50%, var(--insta-orange) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Juntos</span></h2>
            </div>
        </div>

        <div style="max-width: 1200px; margin: 0 auto; width: 100%; display: flex; flex-direction: column; justify-content: center;">
            <div class="contact-container">
                <!-- Left Info Panel -->
                <div class="contact-info">
                    <div>
                        <h3 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1.5rem; letter-spacing: -0.5px;">¿Tienes un proyecto en mente?</h3>
                        <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 3rem; font-size: 1.05rem; font-weight: 300; line-height: 1.7;">
                            Ponte en contacto conmigo para discutir colaboraciones, vacantes de desarrollo o consultas de consultoría en sistemas y arquitectura cloud.
                        </p>
                        
                        <div class="contact-details">
                            @if($profile && $profile->email)
                                <div class="contact-detail-item">
                                    <div class="contact-detail-icon"><i class="fa-solid fa-envelope"></i></div>
                                    <div class="contact-detail-content">
                                        <h4>Correo Electrónico</h4>
                                        <p>{{ $profile->email }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($profile && $profile->phone)
                                <div class="contact-detail-item">
                                    <div class="contact-detail-icon"><i class="fa-solid fa-phone"></i></div>
                                    <div class="contact-detail-content">
                                        <h4>Teléfono</h4>
                                        <p>{{ $profile->phone }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="contact-detail-item">
                                <div class="contact-detail-icon"><i class="fa-solid fa-location-dot"></i></div>
                                <div class="contact-detail-content">
                                    <h4>Ubicación</h4>
                                    <p>{{ $profile->location ?? 'Disponible para trabajo remoto global' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="social-links">
                        @if($profile && $profile->github_url)
                            <a href="{{ $profile->github_url }}" class="social-link-icon" target="_blank" title="GitHub">
                                <i class="fa-brands fa-github"></i>
                            </a>
                        @endif
                        @if($profile && $profile->linkedin_url)
                            <a href="{{ $profile->linkedin_url }}" class="social-link-icon" target="_blank" title="LinkedIn">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Contact Form Card -->
                <div class="contact-form-container glass">
                    @if(session('success'))
                        <div class="alert-box alert-success" style="margin-bottom: 2rem;">
                            <i class="fa-solid fa-circle-check" style="margin-right: 0.5rem;"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert-box alert-error" style="margin-bottom: 2rem;">
                            <i class="fa-solid fa-circle-exclamation" style="margin-right: 0.5rem;"></i>
                            Por favor revisa los errores del formulario.
                        </div>
                    @endif

                    <form action="{{ route('portfolio.contact') }}#contacto" method="POST">
                        @csrf
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="form_name" class="form-label">Tu Nombre *</label>
                                <input type="text" name="name" id="form_name" class="form-input" placeholder="Ej. Juan Pérez" value="{{ old('name') }}" required>
                                @error('name')
                                    <span style="font-size:0.75rem; color:#ffffff; font-weight: 500; margin-top:0.25rem; display:block;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="form_email" class="form-label">Correo Electrónico *</label>
                                <input type="email" name="email" id="form_email" class="form-input" placeholder="juan@ejemplo.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <span style="font-size:0.75rem; color:#ffffff; font-weight: 500; margin-top:0.25rem; display:block;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="form_subject" class="form-label">Asunto (Opcional)</label>
                            <input type="text" name="subject" id="form_subject" class="form-input" placeholder="Ej. Oportunidad de trabajo / Consulta" value="{{ old('subject') }}">
                        </div>

                        <div class="form-group">
                            <label for="form_content" class="form-label">Mensaje *</label>
                            <textarea name="content" id="form_content" class="form-input" placeholder="Escribe tu mensaje aquí..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <span style="font-size:0.75rem; color:#ffffff; font-weight: 500; margin-top:0.25rem; display:block;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-top: 1.5rem;">
                            <button type="submit" class="btn-primary">Enviar Mensaje</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------------------------------
       5. FOOTER
    ---------------------------------------------------- -->
    <footer style="padding: 3rem 8%; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.08); background: #050508; color: rgba(255, 255, 255, 0.5); font-size: 0.9rem;">
        <p>© {{ date('Y') }} {{ $profile->name ?? 'Portafolio Profesional' }}. Todos los derechos reservados.</p>
        <p style="margin-top: 0.5rem; font-size: 0.8rem;">Diseñado e implementado con <i class="fa-solid fa-heart" style="color: var(--insta-magenta); filter: drop-shadow(0 0 5px rgba(225, 48, 108, 0.45));"></i> en Laravel y CSS Vanilla.</p>
    </footer>

    <!-- JS for Mobile Menu Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('mobileMenuToggle');
            const closeBtn = document.getElementById('mobileMenuClose');
            const menuOverlay = document.getElementById('mobileMenuOverlay');

            if (toggleBtn && menuOverlay) {
                toggleBtn.addEventListener('click', function() {
                    menuOverlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            if (closeBtn && menuOverlay) {
                closeBtn.addEventListener('click', function() {
                    menuOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
        });
    </script>
</body>
</html>
