<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>{{ $profile->name ?? 'Portafolio Profesional' }} - {{ $profile->title ?? 'Desarrollador Web & Especialista en IA' }}</title>
    <meta name="description" content="{{ Str::limit($profile->bio ?? 'Portafolio profesional de desarrollo web e integración de Inteligencia Artificial.', 155) }}">
    <meta name="author" content="{{ $profile->name ?? 'Desarrollador Web & IA' }}">
    
    <!-- Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @php
        $photoUrl = $profile && $profile->photo_path ? asset($profile->photo_path) : asset('images/bio_lifestyle.png');
        $heroBgUrl = $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : asset('images/nav_inicio.png');
    @endphp
    @include('partials.preloader')

    <!-- Header / Navigation Bar -->
    <nav class="navbar" id="navbar">
        <a href="#" class="navbar-brand">
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
                        <!-- Path D -->
                        <path class="logo-path-d" d="M 22,26 L 47,26 A 20,20 0 0 1 67,46 A 20,20 0 0 1 47,66 L 22,66" stroke="#ffffff" stroke-width="8.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                        <!-- Path J -->
                        <path class="logo-path-j" d="M 77,43 L 77,56 A 20,20 0 0 1 57,76 L 42,76" stroke="#ffffff" stroke-width="8.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                    </svg>
                </div>
            </div>
        </a>
        
        <!-- Desktop Navigation Links -->
        <div class="navbar-links">
            <a href="#hero">Inicio</a>
            <a href="#biografia">Biografía</a>
            <a href="#proyectos">Proyectos</a>
            <a href="#habilidades">Habilidades</a>
            <a href="#viajes">Viajes</a>
            <a href="#contacto" class="btn-contact">Contáctame</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" style="color: var(--text-primary); font-weight: 600;"><i class="fa-solid fa-user-gear"></i> Panel Admin</a>
            @endauth
        </div>

        <!-- Mobile Menu Toggle Button (Grid Icon) -->
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Abrir menú">
            <div class="grid-icon">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <div class="mobile-menu-content">
            <!-- Close Button -->
            <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Cerrar menú">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="mobile-menu-grid">
                <!-- Sidebar (Left Panel) -->
                <div class="mobile-menu-sidebar">
                    <div class="sidebar-top">
                        <div class="logo-container">
                            <div class="logo-svg-container" style="width: 56px; height: 56px;">
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
                                    <!-- Path D -->
                                    <path class="logo-path-d" d="M 22,26 L 47,26 A 20,20 0 0 1 67,46 A 20,20 0 0 1 47,66 L 22,66" stroke="#ffffff" stroke-width="8.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                                    <!-- Path J -->
                                    <path class="logo-path-j" d="M 77,43 L 77,56 A 20,20 0 0 1 57,76 L 42,76" stroke="#ffffff" stroke-width="8.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="sidebar-name">{{ $profile->name ?? 'Juan Carlos Chahuayo Martínez' }}</h3>
                        <p class="sidebar-title">{{ $profile->title ?? 'Desarrollador Web & Especialista en IA' }}</p>
                    </div>

                    <div class="sidebar-middle">
                        <div class="sidebar-preview-wrapper">
                            <div class="sidebar-preview-image active" id="preview-default" style="background-image: url('{{ asset('images/nav_default.png') }}')"></div>
                            <div class="sidebar-preview-image" id="preview-inicio" style="background-image: url('{{ asset('images/nav_inicio.png') }}')"></div>
                            <div class="sidebar-preview-image" id="preview-biografia" style="background-image: url('{{ $photoUrl }}')"></div>
                            <div class="sidebar-preview-image" id="preview-proyectos" style="background-image: url('{{ asset('images/nav_proyectos.png') }}')"></div>
                            <div class="sidebar-preview-image" id="preview-habilidades" style="background-image: url('{{ asset('images/nav_habilidades.png') }}')"></div>
                            <div class="sidebar-preview-image" id="preview-viajes" style="background-image: url('{{ asset('images/nav_viajes.png') }}')"></div>
                            <div class="sidebar-preview-image" id="preview-contacto" style="background-image: url('{{ asset('images/nav_contacto.png') }}')"></div>
                        </div>
                    </div>

                    <div class="sidebar-bottom">
                        <div class="sidebar-contact-info">
                            @if($profile && $profile->email)
                                <a href="mailto:{{ $profile->email }}" class="sidebar-email">
                                    <i class="fa-solid fa-envelope"></i> {{ $profile->email }}
                                </a>
                            @endif
                        </div>
                        <div class="mobile-social-links">
                            @if($profile && $profile->github_url)
                                <a href="{{ $profile->github_url }}" target="_blank" class="mobile-social-icon" title="GitHub">
                                    <i class="fa-brands fa-github"></i>
                                </a>
                            @endif
                            @if($profile && $profile->linkedin_url)
                                <a href="{{ $profile->linkedin_url }}" target="_blank" class="mobile-social-icon" title="LinkedIn">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Navigation List (Right Panel) -->
                <div class="mobile-menu-main">
                    <span class="menu-label-tag">Menú de Navegación</span>
                    <nav class="mobile-menu-nav">
                        <a href="#hero" class="mobile-menu-link" data-preview="preview-inicio">
                            <span class="mobile-menu-link-num">01</span>
                            <span class="mobile-menu-link-content">
                                <span class="mobile-menu-link-main">Inicio</span>
                                <span class="mobile-menu-link-sub">Página principal y biografía</span>
                            </span>
                            <i class="fa-solid fa-arrow-right link-arrow"></i>
                        </a>

                        <a href="#biografia" class="mobile-menu-link" data-preview="preview-biografia">
                            <span class="mobile-menu-link-num">02</span>
                            <span class="mobile-menu-link-content">
                                <span class="mobile-menu-link-main">Biografía</span>
                                <span class="mobile-menu-link-sub">Quién soy y mi trayectoria</span>
                            </span>
                            <i class="fa-solid fa-arrow-right link-arrow"></i>
                        </a>
                        
                        <a href="#proyectos" class="mobile-menu-link" data-preview="preview-proyectos">
                            <span class="mobile-menu-link-num">03</span>
                            <span class="mobile-menu-link-content">
                                <span class="mobile-menu-link-main">Proyectos</span>
                                <span class="mobile-menu-link-sub">Mis últimos desarrollos y sistemas</span>
                            </span>
                            <i class="fa-solid fa-arrow-right link-arrow"></i>
                        </a>
                        
                        <a href="#habilidades" class="mobile-menu-link" data-preview="preview-habilidades">
                            <span class="mobile-menu-link-num">04</span>
                            <span class="mobile-menu-link-content">
                                <span class="mobile-menu-link-main">Habilidades</span>
                                <span class="mobile-menu-link-sub">Conocimientos técnicos y especialidades</span>
                            </span>
                            <i class="fa-solid fa-arrow-right link-arrow"></i>
                        </a>

                        <a href="#viajes" class="mobile-menu-link" data-preview="preview-viajes">
                            <span class="mobile-menu-link-num">05</span>
                            <span class="mobile-menu-link-content">
                                <span class="mobile-menu-link-main">Viajes</span>
                                <span class="mobile-menu-link-sub">Mis destinos y bitácora de aventuras</span>
                            </span>
                            <i class="fa-solid fa-arrow-right link-arrow"></i>
                        </a>
                        
                        <a href="#contacto" class="mobile-menu-link" data-preview="preview-contacto">
                            <span class="mobile-menu-link-num">06</span>
                            <span class="mobile-menu-link-content">
                                <span class="mobile-menu-link-main">Contáctame</span>
                                <span class="mobile-menu-link-sub">Envíame un mensaje directo</span>
                            </span>
                            <i class="fa-solid fa-arrow-right link-arrow"></i>
                        </a>
                        
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="mobile-menu-link" data-preview="preview-default">
                                <span class="mobile-menu-link-num">07</span>
                                <span class="mobile-menu-link-content">
                                    <span class="mobile-menu-link-main">Panel Admin</span>
                                    <span class="mobile-menu-link-sub">Gestión interna del portafolio</span>
                                </span>
                                <i class="fa-solid fa-arrow-right link-arrow"></i>
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section with Fullscreen Background Image -->
    <section id="hero" class="hero" style="background-image: url('{{ $heroBgUrl }}');">
        <div class="hero-overlay"></div>
        
        <!-- Bottom-anchored cinematic content -->
        <div class="hero-bottom">
            <div class="hero-content-new">
                <span class="hero-label">Portafolio Personal</span>
                @php
                    $fullName = $profile->name ?? 'Juan Carlos Chahuayo Martínez';
                    $nameParts = explode(' ', $fullName, 2);
                    $firstName = $nameParts[0] ?? '';
                    $lastName = $nameParts[1] ?? '';
                @endphp
                <h1 class="hero-title-new">
                    <span class="hero-firstname">{{ $firstName }}</span>
                    <span class="hero-lastname hero-text-gradient">{{ $lastName }}</span>
                </h1>
                <p class="hero-presentation-new">
                    {{ $profile->title ?? 'Desarrollador Web & Especialista en IA' }}
                </p>
                <div class="hero-cta-new">
                    <a href="#contacto" class="btn-hero-collaboration">
                        <span>Iniciar Colaboración</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <!-- Scroll indicator -->
            <div class="hero-scroll-hint">
                <span>Scroll</span>
                <div class="scroll-line"></div>
            </div>
        </div>
    </section>

    <!-- Biography Section with Fullscreen Image Layout -->
    <section id="biografia" class="biografia-section-fullscreen">
        <!-- Large Image with Bio Content -->
        <div class="bio-image-large">
            <img src="{{ $photoUrl }}" alt="Perfil Principal" class="bio-img">
            <div class="bio-image-overlay"></div>
            
            <!-- Bio Content Inside Image -->
            <div class="bio-content-overlay">
                <div class="bio-inner-content">
                    <span class="bio-tag">{{ $profile->bio_tag ?? 'El Humano Detrás del Código' }}</span>
                    <h2 class="bio-main-title">
                        {!! nl2br(e($profile->bio_title ?? 'Transformo Ideas en Realidad Digital')) !!}
                    </h2>
                    <p class="bio-elegant-text">
                        {{ $profile->bio_description ?? $profile->bio ?? 'Arquitecto de experiencias digitales, fusiono la elegancia del diseño con la potencia de la inteligencia artificial. Cada línea de código cuenta una historia, cada sistema resuelve un problema real.' }}
                    </p>
                    
                    <div class="bio-identity-grid">
                        <div class="bio-identity-item">
                            <i class="fa-solid fa-signature"></i>
                            <div>
                                <span class="bio-identity-label">Identidad</span>
                                <span class="bio-identity-value">{{ $profile->name ?? 'Juan Carlos Chahuayo' }}</span>
                            </div>
                        </div>
                        <div class="bio-identity-item">
                            <i class="fa-solid fa-code-branch"></i>
                            <div>
                                <span class="bio-identity-label">Especialización</span>
                                <span class="bio-identity-value">{{ $profile->title ?? 'Desarrollo Web & IA' }}</span>
                            </div>
                        </div>
                        @if($profile && $profile->email)
                        <div class="bio-identity-item">
                            <i class="fa-solid fa-at"></i>
                            <div>
                                <span class="bio-identity-label">Conexión</span>
                                <span class="bio-identity-value">{{ $profile->email }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($profile && $profile->cv_path)
                    <div class="bio-cta-wrapper">
                        <a href="{{ asset($profile->cv_path) }}" target="_blank" class="btn-bio-cv">
                            <span>Explorar Trayectoria</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Small Images with Labels -->
        <div class="bio-images-small-column">
            <!-- Top Small Image - Workspace -->
            <div class="bio-image-small">
                <img src="{{ $profile && $profile->workspace_image ? asset($profile->workspace_image) : asset('images/bio_workspace.png') }}" alt="Espacio de Trabajo" class="bio-img">
                <div class="bio-image-overlay-strong"></div>
                <div class="bio-small-content">
                    <div class="bio-small-icon">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>
                    <h3 class="bio-small-title">{{ $profile->workspace_title ?? 'Mi Laboratorio' }}</h3>
                    <p class="bio-small-desc">{{ $profile->workspace_desc ?? 'Donde las ideas cobran vida y el café se transforma en código' }}</p>
                </div>
            </div>
            
            <!-- Bottom Small Image - Tech Stack -->
            <div class="bio-image-small">
                <img src="{{ $profile && $profile->tech_image ? asset($profile->tech_image) : asset('images/bio_tech.png') }}" alt="Tecnología" class="bio-img">
                <div class="bio-image-overlay-strong"></div>
                <div class="bio-small-content">
                    <div class="bio-small-icon">
                        <i class="fa-solid fa-microchip"></i>
                    </div>
                    <h3 class="bio-small-title">{{ $profile->tech_title ?? 'Stack Tecnológico' }}</h3>
                    <p class="bio-small-desc">{{ $profile->tech_desc ?? 'Herramientas de vanguardia para construir el futuro' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Grid Section — Fullscreen Split Layout -->
    <section id="proyectos" style="min-height: 100vh; height: 100vh; position: relative; overflow: hidden; padding: 0; margin: 0;">
        <!-- Header Overlay -->
        <div class="projects-header-overlay">
            <span class="section-subtitle">Portafolio</span>
            <h2 class="section-title">Proyectos <span class="text-gradient">Destacados</span></h2>
        </div>

        @if($projects->isEmpty())
            <div style="height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; color: var(--text-muted); background: var(--bg-dark);">
                <i class="fa-solid fa-diagram-project" style="font-size: 3rem; margin-bottom: 1.5rem; color: var(--accent-cyan);"></i>
                <p style="font-size: 1.25rem;">Pronto se añadirán nuevos proyectos interesantes. ¡Vuelve pronto!</p>
            </div>
        @else
            @php
                $featuredProjects = $projects->take(2);
            @endphp
            <div class="projects-split-container">
                @foreach($featuredProjects as $project)
                    <article class="project-panel">
                        <div class="project-panel-bg" style="background-image: url('{{ $project->image_path ? asset($project->image_path) : asset('images/nav_proyectos.png') }}')"></div>
                        <div class="project-panel-overlay"></div>
                        
                        <div class="project-panel-content">
                            <div class="project-panel-tags">
                                @foreach($project->tech_stack_array as $tech)
                                    <span class="project-panel-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                            <h3 class="project-panel-title">{{ $project->title }}</h3>
                            <p class="project-panel-desc">{{ $project->description }}</p>
                            
                            <div class="project-panel-links">
                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" class="project-panel-link" target="_blank">
                                        <i class="fa-brands fa-github"></i> Código Fuente
                                    </a>
                                @endif
                                @if($project->project_url)
                                    <a href="{{ $project->project_url }}" class="project-panel-link" target="_blank">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Demo En Vivo
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
                
                @if($featuredProjects->count() < 2)
                    <!-- Placeholder panel if there's only 1 project -->
                    <article class="project-panel" style="background-color: #0c0c12;">
                        <div class="project-panel-overlay" style="background: rgba(5,5,5,0.7);"></div>
                        <div class="project-panel-content" style="text-align: center; padding-bottom: 20%; transform: none; opacity: 1;">
                            <i class="fa-solid fa-code" style="font-size: 3rem; color: rgba(255,255,255,0.1); margin-bottom: 1.5rem;"></i>
                            <h3 class="project-panel-title" style="color: rgba(255,255,255,0.3); font-size: 1.75rem;">Próximamente más proyectos</h3>
                        </div>
                    </article>
                @endif
            </div>

            <!-- Bottom Center Round Button -->
            <button class="projects-more-btn" onclick="openProjectsModal()">
                <span>Otros</span>
            </button>
        @endif
    </section>

    <!-- All Projects Modal Overlay -->
    <div id="projectsModal" class="projects-modal-overlay">
        <div class="projects-modal-container glass">
            <button class="projects-modal-close" onclick="closeProjectsModal()" aria-label="Cerrar galería">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="projects-modal-header">
                <span class="section-subtitle">Portafolio</span>
                <h2 class="section-title">Galería de <span class="text-gradient">Proyectos</span></h2>
            </div>
            
            @if($projects->isEmpty())
                <p style="color: var(--text-muted); text-align: center;">No hay proyectos para mostrar.</p>
            @else
                <div class="projects-modal-grid">
                    @foreach($projects as $project)
                        <article class="project-card glass">
                            <div class="project-image-container">
                                @if($project->image_path)
                                    <img src="{{ asset($project->image_path) }}" alt="{{ $project->title }}" class="project-image">
                                @else
                                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:var(--bg-card); color:var(--text-muted); font-size:3rem;">
                                        <i class="fa-solid fa-network-wired"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="project-body">
                                <h3 class="project-title">{{ $project->title }}</h3>
                                <p class="project-desc">{{ $project->description }}</p>
                                
                                <div class="project-tags">
                                    @foreach($project->tech_stack_array as $tech)
                                        <span class="project-tag">{{ $tech }}</span>
                                    @endforeach
                                </div>
                                
                                <div class="project-links">
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" class="project-link" target="_blank">
                                            <i class="fa-brands fa-github"></i> Código
                                        </a>
                                    @endif
                                    @if($project->project_url)
                                        <a href="{{ $project->project_url }}" class="project-link" target="_blank" style="color: var(--text-primary); text-decoration: underline;">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Demo En Vivo
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Skills Categorized Section -->
    <section id="habilidades" style="background-color: rgba(255,255,255,0.01);">
        <div class="section-header">
            <span class="section-subtitle">Conocimientos</span>
            <h2 class="section-title">Habilidades <span class="text-gradient">Técnicas</span></h2>
        </div>

        @if($skillsGrouped->isEmpty())
            <div style="text-align: center; padding: 4rem 0; color: var(--text-muted); background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color);">
                <i class="fa-solid fa-brain" style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--accent-purple);"></i>
                <p>Las habilidades técnicas se cargarán próximamente.</p>
            </div>
        @else
            <div class="skills-container">
                @foreach($skillsGrouped as $category => $skills)
                    <div class="skills-category-card glass">
                        <h3 class="skills-category-title">
                            <i class="fa-solid fa-code-branch" style="margin-right: 0.5rem; font-size: 0.95rem;"></i>
                            {{ $category }}
                        </h3>
                        <div class="skill-list">
                            @foreach($skills as $skill)
                                <div class="skill-item">
                                    <div class="skill-info">
                                        <span class="skill-name">
                                            @if($skill->icon_class)
                                                <i class="{{ $skill->icon_class }}" style="margin-right: 0.35rem; color: var(--accent-cyan);"></i>
                                            @endif
                                            {{ $skill->name }}
                                        </span>
                                        <span class="skill-percent">{{ $skill->proficiency }}%</span>
                                    </div>
                                    <div class="skill-bar-bg">
                                        <div class="skill-bar-fill" data-percent="{{ $skill->proficiency }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Travel Gallery Section -->
    <section id="viajes" style="background-color: rgba(255,255,255,0.005); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="section-header">
            <span class="section-subtitle">Exploración</span>
            <h2 class="section-title">Viajes & <span class="text-gradient">Bitácora</span></h2>
        </div>

        <div class="travel-container">
            @if($travels->isEmpty())
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 0; color: var(--text-muted); background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); width: 100%;">
                    <i class="fa-solid fa-plane-departure" style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--accent-cyan);"></i>
                    <p>Pronto se añadirán nuevos destinos y bitácoras de viajes. ¡Vuelve pronto!</p>
                </div>
            @else
                @foreach($travels as $travel)
                    <article class="travel-card glass">
                        <div class="travel-image-container">
                            @if($travel->image_path)
                                <img src="{{ asset($travel->image_path) }}" alt="{{ $travel->title }}" class="travel-image">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--bg-card); color: var(--text-muted); font-size: 2rem;">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                            @endif
                            @if($travel->badge)
                                <span class="travel-badge">{{ $travel->badge }}</span>
                            @endif
                        </div>
                        <div class="travel-body">
                            <h3 class="travel-card-title">{{ $travel->title }}</h3>
                            <p class="travel-desc">{{ $travel->description }}</p>
                            <div class="travel-meta">
                                @if($travel->meta_1_text)
                                    <span><i class="{{ $travel->meta_1_icon ?? 'fa-solid fa-plane-departure' }}"></i> {{ $travel->meta_1_text }}</span>
                                @endif
                                @if($travel->meta_2_text)
                                    <span><i class="{{ $travel->meta_2_icon ?? 'fa-solid fa-camera' }}"></i> {{ $travel->meta_2_text }}</span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            @endif
        </div>
    </section>

    <!-- Contact & Message Submission Section -->
    <section id="contacto">
        <div class="section-header">
            <span class="section-subtitle">Contacto</span>
            <h2 class="section-title">Trabajemos <span class="text-gradient">Juntos</span></h2>
        </div>

        <div class="contact-container">
            <!-- Left Info Panel -->
            <div class="contact-info">
                <div>
                    <h3 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1.5rem; letter-spacing: -0.5px;">¿Tienes un proyecto en mente?</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 3rem; font-size: 1.05rem;">
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

                    <button type="submit" class="btn-primary" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        <i class="fa-solid fa-paper-plane"></i> Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="padding: 3rem 8%; text-align: center; border-top: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.9rem;">
        <p>© {{ date('Y') }} {{ $profile->name ?? 'Portafolio Profesional' }}. Todos los derechos reservados.</p>
        <p style="margin-top: 0.5rem; font-size: 0.8rem;">Diseñado e implementado con <i class="fa-solid fa-heart" style="color: var(--insta-magenta); filter: drop-shadow(0 0 5px rgba(225, 48, 108, 0.45));"></i> en Laravel y CSS Vanilla.</p>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        // Navbar Scrolled Effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');

        // Open mobile menu
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scroll
        });

        // Close mobile menu
        const closeMobileMenu = () => {
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = ''; // Restore scroll
        };

        mobileMenuClose.addEventListener('click', closeMobileMenu);
        
        // Close when clicking overlay background
        mobileMenuOverlay.addEventListener('click', (e) => {
            if (e.target === mobileMenuOverlay) {
                closeMobileMenu();
            }
        });

        // Close when clicking a menu link
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', () => {
                closeMobileMenu();
            });
        });

        // Hover preview images for navigation links
        const previewImages = document.querySelectorAll('.sidebar-preview-image');
        const defaultPreview = document.getElementById('preview-default');

        mobileMenuLinks.forEach(link => {
            link.addEventListener('mouseenter', () => {
                const targetId = link.getAttribute('data-preview');
                if (targetId) {
                    const targetImage = document.getElementById(targetId);
                    if (targetImage) {
                        previewImages.forEach(img => img.classList.remove('active'));
                        targetImage.classList.add('active');
                    }
                }
            });

            link.addEventListener('mouseleave', () => {
                previewImages.forEach(img => img.classList.remove('active'));
                if (defaultPreview) {
                    defaultPreview.classList.add('active');
                }
            });
        });

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileMenuOverlay.classList.contains('active')) {
                closeMobileMenu();
            }
        });

        // Skill Bars Animation on Scroll
        document.addEventListener('DOMContentLoaded', () => {
            const skillFills = document.querySelectorAll('.skill-bar-fill');
            
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const bar = entry.target;
                        const percent = bar.getAttribute('data-percent');
                        bar.style.width = percent;
                        observer.unobserve(bar); // Animate once
                    }
                });
            }, observerOptions);

            skillFills.forEach(bar => {
                observer.observe(bar);
            });
        });

        // Projects Modal Actions
        const projectsModal = document.getElementById('projectsModal');
        
        function openProjectsModal() {
            if (projectsModal) {
                projectsModal.classList.add('active');
                document.body.classList.add('modal-active');
            }
        }

        function closeProjectsModal() {
            if (projectsModal) {
                projectsModal.classList.remove('active');
                document.body.classList.remove('modal-active');
            }
        }

        // Close modal on escape press or click outside container
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && projectsModal.classList.contains('active')) {
                closeProjectsModal();
            }
        });
        
        if (projectsModal) {
            projectsModal.addEventListener('click', (e) => {
                if (e.target === projectsModal) {
                    closeProjectsModal();
                }
            });
        }
    </script>
</body>
</html>
