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
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Great+Vibes&family=MonteCarlo&family=Pinyon+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.15.1/devicon.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @php
        $photoUrl = $profile && $profile->photo_path ? asset($profile->photo_path) : asset('images/bio_lifestyle.png');
        $heroBgUrl = $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : asset('images/nav_inicio.png');
        $techBgUrl = $profile && $profile->tech_image ? asset($profile->tech_image) : asset('images/nav_habilidades.png');
    @endphp

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
                        <!-- Calligraphic JC Monogram -->
                        <text x="50%" y="72%" text-anchor="middle" class="logo-script-text">JC</text>
                    </svg>
                </div>
            </div>
        </a>
        
        <!-- Desktop Navigation Links -->
        <div class="navbar-links">
            <a href="#hero">Inicio</a>
            <a href="#biografia">Biografía</a>
            <a href="#habilidades">Habilidades</a>
            <a href="#proyectos">Proyectos</a>
            <a href="#viajes">Viajes</a>
            <a href="#contacto" class="btn-contact">Contáctame</a>
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
        <!-- Background image same as header, but darker -->
        <div class="menu-bg-image" style="background-image: url('{{ $heroBgUrl }}');"></div>
        <div class="menu-bg-overlay"></div>

        <div class="mobile-menu-content">
            <!-- Modal Header: Logo Top-Left & Close Button Top-Right (No line) -->
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
                            <!-- Calligraphic JC Monogram -->
                            <text x="50%" y="72%" text-anchor="middle" class="logo-script-text">JC</text>
                        </svg>
                    </div>
                </div>

                <!-- Close Button Top Right -->
                <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Cerrar menú">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Body: Navigation Links -->
            <div class="mobile-menu-body">
                <nav class="mobile-menu-nav">
                    <a href="#hero" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">1</span>
                        <span class="mobile-menu-link-main">Inicio</span>
                    </a>

                    <a href="#biografia" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">2</span>
                        <span class="mobile-menu-link-main">Biografía</span>
                    </a>

                    <a href="#habilidades" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">3</span>
                        <span class="mobile-menu-link-main">Habilidades</span>
                    </a>
                    
                    <a href="#proyectos" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">4</span>
                        <span class="mobile-menu-link-main">Proyectos</span>
                    </a>

                    <a href="#viajes" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">5</span>
                        <span class="mobile-menu-link-main">Viajes</span>
                    </a>
                    
                    <a href="#contacto" class="mobile-menu-link">
                        <span class="mobile-menu-link-num">6</span>
                        <span class="mobile-menu-link-main">Contáctame</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Hero Section — Clean Left Overlay & Full Crisp Background -->
    <section id="hero" class="hero-split">
        <!-- Natural background image -->
        <div class="hero-bg-image-blur" style="background-image: url('{{ $heroBgUrl }}');"></div>
        <div class="hero-bg-overlay"></div>

        <!-- Left side details -->
        <div class="hero-left">
            <div class="hero-left-content">
                <!-- Name -->
                <h1 class="hero-name">
                    <span class="hero-name-main">{{ $profile->name ?? 'Juan Carlos Chahuayo Martínez' }}</span>
                </h1>

                <!-- Subtitle (No Line) -->
                <div class="hero-subtitle">
                    <span>{{ $profile->title ?? 'Estudiante de ingeniería de sistemas' }}</span>
                </div>

                <!-- Action Button -->
                <div class="hero-action">
                    <a href="#contacto" class="btn-hablemos">Hablemos</a>
                </div>
            </div>
        </div>

        <!-- Bottom scroll indicator -->
        <div class="hero-scroll-indicator">
            <div class="scroll-mouse">
                <div class="scroll-wheel"></div>
            </div>
            <span class="scroll-text">Scroll para explorar</span>
        </div>
    </section>

    <!-- Biography Section — Fullscreen Editorial Layout -->
    <section id="biografia" class="bio-section-fullscreen">
        <!-- Multiple background layers for slideshow -->
        @if(!empty($profile->bio_backgrounds) && count($profile->bio_backgrounds) > 0)
            @foreach($profile->bio_backgrounds as $index => $bg)
                <div class="bio-slide-bg {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset($bg) }}');"></div>
            @endforeach
        @else
            <!-- Fallback to main photoUrl background -->
            <div class="bio-slide-bg active" style="background-image: url('{{ $photoUrl }}');"></div>
        @endif

        <!-- Dark gradient overlay for text readability -->
        <div class="bio-fullscreen-overlay"></div>
        
        <!-- Large outline Title in the background -->
        <h1 class="bio-large-title-outline">{{ $profile->bio_title ?? 'YO' }}</h1>
        
        <div class="editorial-header-global">
            <div>
                <span class="editorial-tag-global">01 / BIOGRAFÍA & PERFIL</span>
            </div>
        </div>

        <div class="bio-fullscreen-container">
            <div class="bio-only-text-container">
                <p class="bio-clean-text">
                    {{ $profile->bio_description ?? 'Soy Juan Carlos Chahuayo Martinez, estudiante de Ingeniería de Sistemas y fundador de CreativeUP Studio. Me dedico principalmente al desarrollo web y la Inteligencia Artificial, fusionando ambas áreas para crear soluciones innovadoras. Mi enfoque está en construir plataformas web escalables y robustas, integrándolas con modelos de IA, visión artificial y análisis de datos para resolver desafíos complejos y generar un impacto tecnológico real.' }}
                </p>
            </div>
        </div>
    </section>

    <!-- Habilidades Section — Clean Educational & Tech Logos Layout -->
    <section id="habilidades" class="skills-section-modern" style="background-image: url('{{ $techBgUrl }}'); position: relative;">
        <!-- Dark gradient overlay for text readability -->
        <div class="skills-bg-overlay"></div>

        <div class="editorial-header-global">
            <div>
                <span class="editorial-tag-global">02 / HABILIDADES & CONOCIMIENTOS</span>
            </div>
        </div>

        <div class="skills-container-modern">
            <div class="skills-content-modern">
                <!-- UNCP Learning Text Block -->
                <div class="skills-text-block">
                    <p class="skills-uncp-text">
                        @if($profile && $profile->tech_desc)
                            {!! nl2br(e($profile->tech_desc)) !!}
                        @else
                            Actualmente cursando el <strong>noveno ciclo de Ingeniería de Sistemas en la Universidad Nacional del Centro del Perú (UNCP)</strong>, he consolidado una sólida base teórica y práctica en el desarrollo de software. Mi formación universitaria me ha permitido profundizar en la optimización de algoritmos, administración de bases de datos avanzadas y el diseño arquitectónico de sistemas. Gracias a esta preparación académica, he aprendido a integrar metodologías ágiles como Scrum y herramientas DevOps para gestionar proyectos de manera estructurada e innovadora.
                        @endif
                    </p>
                </div>

                <!-- Technologies Logos (No Cards, Original Colors) -->
                <div class="tech-logos-grid-clean">
                    @forelse($skills as $skill)
                        <div class="tech-logo-item">
                            @if($skill->icon_class)
                                <i class="{{ $skill->icon_class }} colored"></i>
                            @else
                                <i class="fa-solid fa-code"></i>
                            @endif
                            <span>{{ $skill->name }}</span>
                        </div>
                    @empty
                        <div class="tech-logo-item">
                            <i class="devicon-python-plain colored"></i>
                            <span>PYTHON</span>
                        </div>
                        <div class="tech-logo-item">
                            <i class="devicon-git-plain colored"></i>
                            <span>GIT</span>
                        </div>
                        <div class="tech-logo-item">
                            <i class="devicon-microsoftsqlserver-plain colored"></i>
                            <span>SQL Server</span>
                        </div>
                        <div class="tech-logo-item">
                            <i class="devicon-javascript-plain colored"></i>
                            <span>JS</span>
                        </div>
                        <div class="tech-logo-item">
                            <i class="devicon-php-plain colored"></i>
                            <span>PHP</span>
                        </div>
                        <div class="tech-logo-item">
                            <i class="devicon-mysql-plain colored"></i>
                            <span>MYSQL</span>
                        </div>
                        <div class="tech-logo-item">
                            <i class="devicon-amazonwebservices-original colored"></i>
                            <span>AWS</span>
                        </div>
                        <div class="tech-logo-item">
                            <i class="fa-solid fa-people-group colored"></i>
                            <span>SCRUM</span>
                        </div>
                        <div class="tech-logo-item">
                            <i class="fa-solid fa-diagram-project colored"></i>
                            <span>Gestión de Proyectos</span>
                        </div>
                        <div class="tech-logo-item">
                            <i class="fa-solid fa-sitemap colored"></i>
                            <span>Arq. de Software</span>
                        </div>
                        <div class="tech-logo-item">
                            <i class="fa-solid fa-rotate colored"></i>
                            <span>Met. Ágiles</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section — Premium Dark Editorial with Tech Cards -->
    <section id="proyectos" class="projects-section-modern section-fullscreen">
        <div class="editorial-header-global">
            <div>
                <span class="editorial-tag-global">03 / PORTAFOLIO</span>
                <h2 class="editorial-title-global">Proyectos <span style="background: linear-gradient(135deg, var(--insta-purple) 0%, var(--insta-magenta) 50%, var(--insta-orange) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Destacados</span></h2>
            </div>
            <span style="font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.4); font-family: 'Outfit', sans-serif;">{{ $projects->count() }} PROYECTOS DISPONIBLES</span>
        </div>

        <div class="section-inner-wrapper">

            @if($projects->isEmpty())
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 0; color: rgba(255,255,255,0.5); background: rgba(255,255,255,0.02); border-radius: 20px; border: 1px solid rgba(255,255,255,0.08); width: 100%;">
                    <i class="fa-solid fa-diagram-project" style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--insta-orange);"></i>
                    <p>No hay proyectos registrados actualmente. ¡Vuelve pronto!</p>
                </div>
            @else
                <!-- Grid Container -->
                <div class="proj-grid">
                    @php
                        $sortedProjects = $projects->sortByDesc('created_at');
                        $visibleProjects = $sortedProjects->take(2);
                        $hiddenProjects = $sortedProjects->slice(2);
                    @endphp

                    @foreach($visibleProjects as $index => $project)
                        <article class="proj-card" style="animation-delay: {{ $index * 0.15 }}s;">
                            <!-- Image -->
                            <div class="proj-card-img">
                                <a href="{{ route('portfolio.projects.show', $project) }}" style="display: block; width: 100%; height: 100%;">
                                    @if($project->image_path)
                                        <img src="{{ asset($project->image_path) }}" alt="{{ $project->title }}" loading="lazy">
                                    @else
                                        <div class="proj-card-placeholder">
                                            <i class="fa-solid fa-code"></i>
                                        </div>
                                    @endif
                                </a>
                                <span class="proj-card-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <!-- Hover Overlay with Links -->
                                <div class="proj-card-img-overlay">
                                    <a href="{{ route('portfolio.projects.show', $project) }}" class="proj-overlay-link" title="Ver Detalles del Proyecto">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @if($project->project_url)
                                        <a href="{{ $project->project_url }}" target="_blank" class="proj-overlay-link" title="Ver Demo en Vivo">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                    @endif
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" class="proj-overlay-link" title="Ver Código en GitHub">
                                            <i class="fa-brands fa-github"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="proj-card-body">
                                <h3 class="proj-card-title">
                                    <a href="{{ route('portfolio.projects.show', $project) }}" style="color: inherit; text-decoration: none;">
                                        {{ $project->title }}
                                    </a>
                                </h3>
                                <p class="proj-card-desc">{{ Str::limit($project->description, 120) }}</p>

                                <!-- Tech Tags -->
                                <div class="proj-card-tags">
                                    @foreach(array_slice($project->tech_stack_array, 0, 5) as $tech)
                                        <span class="proj-tag">{{ $tech }}</span>
                                    @endforeach
                                    @if(count($project->tech_stack_array) > 5)
                                        <span class="proj-tag proj-tag-more">+{{ count($project->tech_stack_array) - 5 }}</span>
                                    @endif
                                </div>

                                <!-- Footer Action: Signature Sliding Arrow Button -->
                                <div class="proj-card-footer">
                                    <a href="{{ route('portfolio.projects.show', $project) }}" class="btn-view-project">
                                        <span>Ver Proyecto</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($hiddenProjects->isNotEmpty())
                    <!-- Hidden projects grid -->
                    <div id="hidden-projects-grid" class="proj-grid" style="display: none; opacity: 0; transition: all 0.5s ease; margin-top: 2.5rem;">
                        @foreach($hiddenProjects as $index => $project)
                            <article class="proj-card">
                                <div class="proj-card-img">
                                    <a href="{{ route('portfolio.projects.show', $project) }}" style="display: block; width: 100%; height: 100%;">
                                        @if($project->image_path)
                                            <img src="{{ asset($project->image_path) }}" alt="{{ $project->title }}" loading="lazy">
                                        @else
                                            <div class="proj-card-placeholder">
                                                <i class="fa-solid fa-code"></i>
                                            </div>
                                        @endif
                                    </a>
                                    <span class="proj-card-number">{{ str_pad($index + 3, 2, '0', STR_PAD_LEFT) }}</span>
                                    <div class="proj-card-img-overlay">
                                        <a href="{{ route('portfolio.projects.show', $project) }}" class="proj-overlay-link" title="Ver Detalles del Proyecto">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        @if($project->project_url)
                                            <a href="{{ $project->project_url }}" target="_blank" class="proj-overlay-link" title="Ver Demo en Vivo">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </a>
                                        @endif
                                        @if($project->github_url)
                                            <a href="{{ $project->github_url }}" target="_blank" class="proj-overlay-link" title="Ver Código en GitHub">
                                                <i class="fa-brands fa-github"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="proj-card-body">
                                    <h3 class="proj-card-title">
                                        <a href="{{ route('portfolio.projects.show', $project) }}" style="color: inherit; text-decoration: none;">
                                            {{ $project->title }}
                                        </a>
                                    </h3>
                                    <p class="proj-card-desc">{{ Str::limit($project->description, 120) }}</p>
                                    <div class="proj-card-tags">
                                        @foreach(array_slice($project->tech_stack_array, 0, 5) as $tech)
                                            <span class="proj-tag">{{ $tech }}</span>
                                        @endforeach
                                        @if(count($project->tech_stack_array) > 5)
                                            <span class="proj-tag proj-tag-more">+{{ count($project->tech_stack_array) - 5 }}</span>
                                        @endif
                                    </div>
                                    <div class="proj-card-footer">
                                        <a href="{{ route('portfolio.projects.show', $project) }}" class="btn-view-project">
                                            <span>Ver Proyecto</span>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Show More Button: Signature Sliding Arrow Animation -->
                    <div style="text-align: center; margin-top: 3.5rem;">
                        <button id="btn-toggle-projects" class="new-projects-toggle-btn" onclick="toggleMoreProjects()">
                            <span>Ver más proyectos</span>
                        </button>
                    </div>

                    <script>
                        function toggleMoreProjects() {
                            var container = document.getElementById('hidden-projects-grid');
                            var btn = document.getElementById('btn-toggle-projects');
                            var section = document.getElementById('proyectos');
                            
                            if (container.style.display === 'none') {
                                container.style.display = 'grid';
                                container.offsetHeight; // trigger reflow
                                container.style.opacity = '1';
                                section.style.height = 'auto';
                                section.style.minHeight = 'auto';
                                section.style.overflow = 'visible';
                                btn.querySelector('span').textContent = 'Ver menos proyectos';
                            } else {
                                container.style.opacity = '0';
                                setTimeout(function() {
                                    container.style.display = 'none';
                                    section.scrollIntoView({ behavior: 'smooth' });
                                }, 500);
                                btn.querySelector('span').textContent = 'Ver más proyectos';
                            }
                        }
                    </script>
                @endif
            @endif
        </div>
    </section>

    <!-- Travel Gallery & Bitácora Section — Editorial Photography Layout -->
    <section id="viajes" class="travel-section-modern section-fullscreen">
        <div class="editorial-header-global">
            <div>
                <span class="editorial-tag-global">04 / EXPLORACIÓN & BITÁCORA</span>
                <h2 class="editorial-title-global">Viajes & <span style="background: linear-gradient(135deg, var(--insta-purple) 0%, var(--insta-magenta) 50%, var(--insta-orange) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Bitácora</span></h2>
            </div>
            <span style="font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.4); font-family: 'Outfit', sans-serif;">{{ $travels->count() }} DESTINOS EXPLORADOS</span>
        </div>

        <div class="section-inner-wrapper">

            <div class="travel-grid-modern">
                @if($travels->isEmpty())
                    <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 0; color: rgba(255,255,255,0.5); background: rgba(255,255,255,0.02); border-radius: 20px; border: 1px solid rgba(255,255,255,0.08); width: 100%;">
                        <i class="fa-solid fa-plane-departure" style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--insta-orange);"></i>
                        <p>Pronto se añadirán nuevos destinos y bitácoras de viajes. ¡Vuelve pronto!</p>
                    </div>
                @else
                    @foreach($travels as $travel)
                        <article class="travel-card-modern">
                            <a href="{{ route('portfolio.travels.show', $travel) }}" style="display: block; width: 100%; height: 100%; position: absolute; inset: 0; z-index: 1;"></a>
                            
                            @if($travel->image_path)
                                <img src="{{ asset($travel->image_path) }}" alt="{{ $travel->title }}" class="travel-card-img">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #0d0d12; color: rgba(255,255,255,0.2); font-size: 3rem;">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                            @endif

                            <div class="travel-card-gradient"></div>

                            <span class="travel-card-badge">
                                {{ $travel->location ?? $travel->badge ?? 'Destino' }} · {{ $travel->year ?? '2025' }}
                            </span>

                            <div class="travel-card-content" style="position: relative; z-index: 2;">
                                <h3 class="travel-card-title">
                                    <a href="{{ route('portfolio.travels.show', $travel) }}" style="color: inherit; text-decoration: none;">
                                        {{ $travel->title }}
                                    </a>
                                </h3>
                                <p class="travel-card-desc">{{ Str::limit($travel->description, 100) }}</p>
                                
                                <div class="travel-card-meta">
                                    <span>
                                        <i class="fa-solid fa-location-dot"></i>
                                        {{ $travel->location ?? $travel->badge ?? 'Lugar' }}@if($travel->country), {{ $travel->country }}@endif
                                    </span>
                                    <span>
                                        <i class="fa-regular fa-calendar"></i>
                                        {{ $travel->year ?? '2025' }}
                                    </span>
                                </div>

                                <div style="margin-top: 1.25rem;">
                                    <a href="{{ route('portfolio.travels.show', $travel) }}" class="btn-view-project">
                                        <span>Ver Bitácora</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Contact & Message Submission Section -->
    <section id="contacto" class="section-fullscreen contact-section">
        <div class="editorial-header-global">
            <div>
                <span class="editorial-tag-global">05 / CONTACTO & CONTRATACIÓN</span>
                <h2 class="editorial-title-global">Trabajemos <span style="background: linear-gradient(135deg, var(--insta-purple) 0%, var(--insta-magenta) 50%, var(--insta-orange) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Juntos</span></h2>
            </div>
        </div>

        <div class="section-inner-wrapper" style="max-width: 1200px;">

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
                    
                    <div class="contact-form-grid">
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

        // Biography section background slideshow cross-fade
        const bioSlides = document.querySelectorAll('.bio-slide-bg');
        if (bioSlides.length > 1) {
            let currentBioSlide = 0;
            setInterval(() => {
                bioSlides[currentBioSlide].classList.remove('active');
                currentBioSlide = (currentBioSlide + 1) % bioSlides.length;
                bioSlides[currentBioSlide].classList.add('active');
            }, 6000); // changes background every 6 seconds
        }
    </script>
</body>
</html>
