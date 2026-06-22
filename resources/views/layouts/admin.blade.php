<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ADMIN MODERN STYLES - INLINE FOR IMMEDIATE USE */
        .admin-body { min-height: 100vh; background: linear-gradient(135deg, #0a0a0f 0%, #050508 100%); font-family: var(--font-family); color: var(--text-primary); overflow-x: hidden; }
        .admin-animated-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; overflow: hidden; }
        .admin-gradient-orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.12; animation: float 20s ease-in-out infinite; }
        .orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, var(--insta-blue) 0%, transparent 70%); top: -250px; left: -250px; animation-delay: 0s; }
        .orb-2 { width: 400px; height: 400px; background: radial-gradient(circle, var(--insta-magenta) 0%, transparent 70%); bottom: -200px; right: -200px; animation-delay: 7s; }
        .orb-3 { width: 350px; height: 350px; background: radial-gradient(circle, var(--insta-yellow) 0%, transparent 70%); top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: 14s; }
        @keyframes float { 0%, 100% { transform: translate(0, 0) scale(1); } 33% { transform: translate(30px, -30px) scale(1.1); } 66% { transform: translate(-20px, 20px) scale(0.9); } }
        
        /* SIDEBAR */
        .admin-sidebar-modern { position: fixed; left: 0; top: 0; width: 280px; height: 100vh; background: rgba(10, 10, 12, 0.96); backdrop-filter: blur(20px); border-right: 1px solid rgba(255, 255, 255, 0.05); display: flex; flex-direction: column; z-index: 1000; box-shadow: 2px 0 30px rgba(0, 0, 0, 0.5); transition: transform 0.3s ease; }
        .admin-sidebar-header { padding: 2rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .admin-logo-modern { display: flex; align-items: center; gap: 0.85rem; }
        .logo-icon-wrapper { width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-purple) 25%, var(--insta-magenta) 50%, var(--insta-orange) 75%, var(--insta-yellow) 100%); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.3rem; box-shadow: 0 8px 24px rgba(225, 48, 108, 0.25); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); box-shadow: 0 8px 24px rgba(225, 48, 108, 0.25); } 50% { transform: scale(1.05); box-shadow: 0 12px 32px rgba(225, 48, 108, 0.45); } }
        .logo-text { display: flex; flex-direction: column; gap: 0.15rem; }
        .logo-title { font-size: 1.1rem; font-weight: 800; color: #ffffff; letter-spacing: -0.5px; }
        .logo-subtitle { font-size: 0.7rem; font-weight: 600; color: rgba(255, 255, 255, 0.4); text-transform: uppercase; letter-spacing: 1.5px; }
        
        /* NAVIGATION */
        .admin-nav-modern { flex: 1; padding: 1.5rem 1rem; overflow-y: auto; }
        .nav-section { margin-bottom: 2rem; }
        .nav-section-title { display: block; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255, 255, 255, 0.25); margin-bottom: 0.75rem; padding: 0 0.75rem; }
        .admin-nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 0.75rem; border-radius: 12px; color: rgba(255, 255, 255, 0.55); font-weight: 600; font-size: 0.9rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; margin-bottom: 0.5rem; overflow: hidden; }
        .admin-nav-link::before { content: ''; position: absolute; left: 0; top: 0; width: 3px; height: 100%; background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-magenta) 100%); transform: scaleY(0); transition: transform 0.3s ease; }
        .nav-link-icon { width: 36px; height: 36px; border-radius: 10px; background: rgba(255, 255, 255, 0.02); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: all 0.3s ease; }
        .nav-link-text { flex: 1; }
        .nav-link-badge { padding: 0.2rem 0.5rem; border-radius: 6px; background: rgba(255, 255, 255, 0.05); font-size: 0.7rem; font-weight: 700; color: rgba(255, 255, 255, 0.5); transition: all 0.3s ease; }
        .nav-link-badge.badge-alert { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #ffffff; box-shadow: 0 0 12px rgba(239, 68, 68, 0.4); animation: alertPulse 2s ease-in-out infinite; }
        @keyframes alertPulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        .nav-link-indicator { width: 6px; height: 6px; border-radius: 50%; background: transparent; transition: all 0.3s ease; }
        .admin-nav-link:hover { color: #ffffff; background: rgba(255, 255, 255, 0.04); transform: translateX(4px); }
        .admin-nav-link:hover .nav-link-icon { background: rgba(225, 48, 108, 0.12); color: var(--insta-magenta); transform: scale(1.1); }
        .admin-nav-link:hover .nav-link-indicator { background: var(--insta-magenta); box-shadow: 0 0 8px var(--insta-magenta); }
        .admin-nav-link.active { color: #ffffff; background: rgba(225, 48, 108, 0.08); }
        .admin-nav-link.active::before { transform: scaleY(1); }
        .admin-nav-link.active .nav-link-icon { background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-purple) 50%, var(--insta-magenta) 100%); color: #ffffff; box-shadow: 0 4px 12px rgba(225, 48, 108, 0.3); }
        .admin-nav-link.active .nav-link-badge { background: rgba(255, 255, 255, 0.15); color: #ffffff; }
        .admin-nav-link.active .nav-link-indicator { background: var(--insta-orange); box-shadow: 0 0 12px var(--insta-orange); }
        
        /* SIDEBAR FOOTER */
        .admin-sidebar-footer-modern { padding: 1.5rem 1rem; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; flex-direction: column; gap: 0.5rem; }
        .sidebar-footer-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border-radius: 10px; color: rgba(255, 255, 255, 0.5); font-size: 0.85rem; font-weight: 600; transition: all 0.3s ease; }
        .sidebar-footer-link:hover { background: rgba(255, 255, 255, 0.05); color: #14b8a6; }
        .sidebar-logout-btn { width: 100%; display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border-radius: 10px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        .sidebar-logout-btn:hover { background: rgba(239, 68, 68, 0.2); border-color: rgba(239, 68, 68, 0.4); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2); }
        
        /* MAIN WRAPPER */
        .admin-main-wrapper { margin-left: 280px; min-height: 100vh; display: flex; flex-direction: column; position: relative; z-index: 1; }
        
        /* TOPBAR */
        .admin-topbar { height: 70px; background: rgba(15, 15, 20, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); }
        .topbar-left { display: flex; align-items: center; gap: 1.5rem; }
        .mobile-menu-toggle { display: none; width: 40px; height: 40px; border-radius: 10px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #ffffff; font-size: 1.1rem; cursor: pointer; transition: all 0.3s ease; }
        .mobile-menu-toggle:hover { background: rgba(255, 255, 255, 0.1); transform: scale(1.05); }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: rgba(255, 255, 255, 0.5); }
        .breadcrumb-separator { color: rgba(255, 255, 255, 0.3); }
        .breadcrumb-current { color: #ffffff; font-weight: 600; }
        .topbar-right { display: flex; align-items: center; gap: 1.5rem; }
        
        /* SEARCH */
        .topbar-search { display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem 1rem; border-radius: 12px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.06); transition: all 0.3s ease; }
        .topbar-search:focus-within { background: rgba(255, 255, 255, 0.05); border-color: rgba(225, 48, 108, 0.5); box-shadow: 0 0 0 3px rgba(225, 48, 108, 0.15); }
        .topbar-search i { color: rgba(255, 255, 255, 0.4); font-size: 0.9rem; }
        .topbar-search input { background: none; border: none; outline: none; color: #ffffff; font-size: 0.9rem; width: 200px; }
        .topbar-search input::placeholder { color: rgba(255, 255, 255, 0.3); }
        
        /* NOTIFICATION */
        .topbar-notification { position: relative; }
        .notification-btn { width: 42px; height: 42px; border-radius: 12px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.06); color: rgba(255, 255, 255, 0.6); font-size: 1.1rem; cursor: pointer; transition: all 0.3s ease; position: relative; }
        .notification-btn:hover { background: rgba(255, 255, 255, 0.08); color: #ffffff; transform: scale(1.05); }
        .notification-dot { position: absolute; top: 8px; right: 8px; width: 8px; height: 8px; border-radius: 50%; background: #ef4444; border: 2px solid rgba(15, 15, 20, 0.8); animation: notificationPulse 2s ease-in-out infinite; }
        @keyframes notificationPulse { 0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); } 50% { transform: scale(1.1); box-shadow: 0 0 0 4px rgba(239, 68, 68, 0); } }
        
        /* USER */
        .topbar-user { display: flex; align-items: center; gap: 0.75rem; padding: 0.4rem 0.4rem 0.4rem 0.6rem; border-radius: 12px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.06); cursor: pointer; transition: all 0.3s ease; }
        .topbar-user:hover { background: rgba(255, 255, 255, 0.08); border-color: rgba(255, 255, 255, 0.12); }
        .user-avatar { width: 36px; height: 36px; border-radius: 10px; overflow: hidden; background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-magenta) 100%); }
        .user-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .user-info { display: flex; flex-direction: column; gap: 0.1rem; }
        .user-name { font-size: 0.85rem; font-weight: 600; color: #ffffff; }
        .user-role { font-size: 0.7rem; color: rgba(255, 255, 255, 0.4); }
        .topbar-user i { color: rgba(255, 255, 255, 0.4); font-size: 0.8rem; margin-left: 0.25rem; }
        
        /* CONTENT */
        .admin-content { flex: 1; padding: 2rem; }
        .content-wrapper { max-width: 1400px; margin: 0 auto; }
        
        /* ALERTS MODERN */
        .alert-modern { display: flex; align-items: flex-start; gap: 1rem; padding: 1.25rem 1.5rem; border-radius: 16px; margin-bottom: 1.5rem; border: 1px solid; animation: alertSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; }
        @keyframes alertSlideIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .alert-modern.alert-fade-out { animation: alertFadeOut 0.3s ease forwards; }
        @keyframes alertFadeOut { to { opacity: 0; transform: translateY(-10px); } }
        .alert-modern::before { content: ''; position: absolute; left: 0; top: 0; width: 4px; height: 100%; }
        .alert-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .alert-content { flex: 1; }
        .alert-title { font-size: 1rem; font-weight: 700; margin-bottom: 0.25rem; }
        .alert-message { font-size: 0.9rem; margin: 0; color: rgba(255, 255, 255, 0.7); }
        .alert-list { margin: 0.5rem 0 0 0; padding-left: 1.25rem; color: rgba(255, 255, 255, 0.7); }
        .alert-close { width: 32px; height: 32px; border-radius: 8px; background: rgba(255, 255, 255, 0.05); border: none; color: rgba(255, 255, 255, 0.5); font-size: 1rem; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; }
        .alert-close:hover { background: rgba(255, 255, 255, 0.1); color: #ffffff; transform: scale(1.1); }
        .alert-success { background: rgba(16, 185, 129, 0.08); border-color: rgba(16, 185, 129, 0.2); }
        .alert-success::before { background: #10b981; }
        .alert-success .alert-icon { background: rgba(16, 185, 129, 0.15); color: #10b981; }
        .alert-success .alert-title { color: #10b981; }
        .alert-error { background: rgba(239, 68, 68, 0.08); border-color: rgba(239, 68, 68, 0.2); }
        .alert-error::before { background: #ef4444; }
        .alert-error .alert-icon { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
        .alert-error .alert-title { color: #ef4444; }
        
        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .admin-sidebar-modern { transform: translateX(-100%); }
            .admin-sidebar-modern.sidebar-open { transform: translateX(0); }
            .admin-main-wrapper { margin-left: 0; }
            .mobile-menu-toggle { display: flex; }
            .topbar-search { display: none; }
        }
        
        @media (max-width: 768px) {
            .admin-topbar { padding: 0 1rem; }
            .admin-content { padding: 1.5rem 1rem; }
            .topbar-user .user-info { display: none; }
            .topbar-notification, .topbar-search { display: none; }
        }
    </style>
</head>
<body class="admin-body">
    @include('partials.preloader')
    
    <!-- Animated Background -->
    <div class="admin-animated-bg">
        <div class="admin-gradient-orb orb-1"></div>
        <div class="admin-gradient-orb orb-2"></div>
        <div class="admin-gradient-orb orb-3"></div>
    </div>

    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar-modern" id="adminSidebar">
        <!-- Logo -->
        <div class="admin-sidebar-header">
            <div class="admin-logo-modern">
                <div class="logo-svg-container" style="width: 44px; height: 44px;">
                    <svg class="logo-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="admin-logo-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#405de6" />
                                <stop offset="25%" stop-color="#833ab4" />
                                <stop offset="50%" stop-color="#e1306c" />
                                <stop offset="75%" stop-color="#f56040" />
                                <stop offset="100%" stop-color="#fcaf45" />
                            </linearGradient>
                        </defs>
                        <!-- Path D -->
                        <path class="logo-path-d" d="M 22,26 L 47,26 A 20,20 0 0 1 67,46 A 20,20 0 0 1 47,66 L 22,66" stroke="url(#admin-logo-grad)" stroke-width="8.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                        <!-- Path J -->
                        <path class="logo-path-j" d="M 77,43 L 77,56 A 20,20 0 0 1 57,76 L 42,76" stroke="url(#admin-logo-grad)" stroke-width="8.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                    </svg>
                </div>
                <div class="logo-text">
                    <span class="logo-title">Portfolio</span>
                    <span class="logo-subtitle">Admin Panel</span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="admin-nav-modern">
            <div class="nav-section">
                <span class="nav-section-title">Principal</span>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <div class="nav-link-icon">
                        <i class="fa-solid fa-home"></i>
                    </div>
                    <span class="nav-link-text">Dashboard</span>
                    <div class="nav-link-indicator"></div>
                </a>
                
                <a href="{{ route('admin.biography.edit') }}" class="admin-nav-link {{ Route::is('admin.biography.*') ? 'active' : '' }}">
                    <div class="nav-link-icon">
                        <i class="fa-solid fa-user-astronaut"></i>
                    </div>
                    <span class="nav-link-text">Biografía</span>
                    <div class="nav-link-indicator"></div>
                </a>
            </div>

            <div class="nav-section">
                <span class="nav-section-title">Contenido</span>
                <a href="{{ route('admin.projects.index') }}" class="admin-nav-link {{ Route::is('admin.projects.*') ? 'active' : '' }}">
                    <div class="nav-link-icon">
                        <i class="fa-solid fa-diagram-project"></i>
                    </div>
                    <span class="nav-link-text">Proyectos</span>
                    <span class="nav-link-badge">{{ \App\Models\Project::count() }}</span>
                    <div class="nav-link-indicator"></div>
                </a>
                
                <a href="{{ route('admin.skills.index') }}" class="admin-nav-link {{ Route::is('admin.skills.*') ? 'active' : '' }}">
                    <div class="nav-link-icon">
                        <i class="fa-solid fa-brain"></i>
                    </div>
                    <span class="nav-link-text">Habilidades</span>
                    <span class="nav-link-badge">{{ \App\Models\Skill::count() }}</span>
                    <div class="nav-link-indicator"></div>
                </a>

                <a href="{{ route('admin.travels.index') }}" class="admin-nav-link {{ Route::is('admin.travels.*') ? 'active' : '' }}">
                    <div class="nav-link-icon">
                        <i class="fa-solid fa-plane"></i>
                    </div>
                    <span class="nav-link-text">Viajes</span>
                    <span class="nav-link-badge">{{ \App\Models\Travel::count() }}</span>
                    <div class="nav-link-indicator"></div>
                </a>
                
                <a href="{{ route('admin.messages.index') }}" class="admin-nav-link {{ Route::is('admin.messages.*') ? 'active' : '' }}">
                    <div class="nav-link-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <span class="nav-link-text">Mensajes</span>
                    @php
                        $unreadCount = \App\Models\Message::where('is_read', false)->count();
                    @endphp
                    @if ($unreadCount > 0)
                        <span class="nav-link-badge badge-alert">{{ $unreadCount }}</span>
                    @endif
                    <div class="nav-link-indicator"></div>
                </a>
            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class="admin-sidebar-footer-modern">
            <a href="{{ route('portfolio.index') }}" class="sidebar-footer-link" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Ver Portafolio</span>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" style="width: 100%;">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="admin-main-wrapper">
        <!-- Top Bar -->
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="topbar-breadcrumb">
                    <i class="fa-solid fa-home"></i>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-current">@yield('page_title', 'Dashboard')</span>
                </div>
            </div>
            
            <div class="topbar-right">
                <!-- Search Bar -->
                <div class="topbar-search">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="Buscar...">
                </div>

                <!-- Notifications -->
                <div class="topbar-notification">
                    <button class="notification-btn">
                        <i class="fa-solid fa-bell"></i>
                        @if ($unreadCount > 0)
                            <span class="notification-dot"></span>
                        @endif
                    </button>
                </div>

                <!-- User Profile -->
                <div class="topbar-user">
                    <div class="user-avatar">
                        <img src="{{ Auth::user()->profile_photo ?? asset('images/default_engineer.png') }}" alt="Avatar">
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">Administrador</span>
                    </div>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="admin-content">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert-modern alert-success" id="alertSuccess">
                    <div class="alert-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="alert-content">
                        <h4 class="alert-title">¡Éxito!</h4>
                        <p class="alert-message">{{ session('success') }}</p>
                    </div>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-modern alert-error" id="alertError">
                    <div class="alert-icon">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <div class="alert-content">
                        <h4 class="alert-title">Error</h4>
                        <p class="alert-message">{{ session('error') }}</p>
                    </div>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-modern alert-error" id="alertErrors">
                    <div class="alert-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="alert-content">
                        <h4 class="alert-title">Errores de Validación</h4>
                        <ul class="alert-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <!-- Page Content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuToggle')?.addEventListener('click', function() {
            document.getElementById('adminSidebar').classList.toggle('sidebar-open');
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.getElementById('alertSuccess')?.classList.add('alert-fade-out');
            document.getElementById('alertError')?.classList.add('alert-fade-out');
            document.getElementById('alertErrors')?.classList.add('alert-fade-out');
            
            setTimeout(() => {
                document.getElementById('alertSuccess')?.remove();
                document.getElementById('alertError')?.remove();
                document.getElementById('alertErrors')?.remove();
            }, 300);
        }, 5000);

        // Image preview function
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
