<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Alex+Brush&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ADMIN PREMIUM ULTRA-MODERN DARK THEME */
        :root {
            --bg-dark: #050508;
            --bg-panel: #0d0e14;
            --bg-card: rgba(255, 255, 255, 0.025);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(255, 255, 255, 0.22);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --insta-blue: #405de6;
            --insta-purple: #833ab4;
            --insta-magenta: #e1306c;
            --insta-orange: #f56040;
            --insta-yellow: #fcaf45;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(5, 5, 8, 0.5); }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--insta-magenta); }

        .admin-body { 
            min-height: 100vh; 
            background: radial-gradient(circle at 10% 20%, #0d0e15 0%, #050508 100%); 
            font-family: 'Outfit', sans-serif; 
            color: var(--text-primary); 
            overflow-x: hidden; 
        }
        
        /* SIDEBAR */
        .admin-sidebar-modern { 
            position: fixed; 
            left: 0; 
            top: 0; 
            width: 280px; 
            height: 100vh; 
            background: rgba(13, 14, 20, 0.95); 
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid var(--border-color); 
            display: flex; 
            flex-direction: column; 
            z-index: 1000; 
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1); 
        }
        .admin-sidebar-header { 
            padding: 2.2rem 2rem; 
            border-bottom: 1px solid var(--border-color); 
        }
        .admin-logo-modern { 
            display: flex; 
            align-items: center; 
            gap: 1.25rem; 
        }
        .logo-icon-script {
            font-family: 'Alex Brush', cursive;
            font-size: 3rem;
            color: #ffffff;
            line-height: 1;
            cursor: default;
            transition: all 0.4s ease;
            filter: drop-shadow(0 0 12px rgba(225, 48, 108, 0.25));
        }
        .logo-icon-script:hover {
            background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-purple) 25%, var(--insta-magenta) 50%, var(--insta-orange) 75%, var(--insta-yellow) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 16px rgba(225, 48, 108, 0.5));
        }
        .logo-text { display: flex; flex-direction: column; gap: 0.15rem; }
        .logo-title { font-size: 1.05rem; font-weight: 700; color: #ffffff; letter-spacing: -0.5px; }
        .logo-subtitle { font-size: 0.65rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px; }
        
        /* NAVIGATION */
        .admin-nav-modern { flex: 1; padding: 1.5rem 1rem; overflow-y: auto; }
        .nav-section { margin-bottom: 2rem; }
        .nav-section-title { display: block; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); margin-bottom: 0.75rem; padding: 0 0.75rem; }
        .admin-nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 0.85rem; border-radius: 14px; color: var(--text-secondary); font-weight: 500; font-size: 0.92rem; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); position: relative; margin-bottom: 0.35rem; text-decoration: none; }
        .admin-nav-link::before { content: ''; position: absolute; left: 0; top: 0; width: 4px; height: 100%; background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-magenta) 50%, var(--insta-orange) 100%); transform: scaleY(0); transition: transform 0.3s ease; border-radius: 0 4px 4px 0; }
        .nav-link-icon { width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-size: 1.05rem; transition: all 0.3s ease; color: var(--text-secondary); }
        .nav-link-text { flex: 1; }
        .nav-link-badge { padding: 0.25rem 0.6rem; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); font-size: 0.72rem; font-weight: 700; color: var(--text-secondary); transition: all 0.3s ease; }
        .nav-link-badge.badge-alert { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #ffffff; border: none; box-shadow: 0 0 12px rgba(239, 68, 68, 0.4); }
        .nav-link-indicator { width: 6px; height: 6px; border-radius: 50%; background: transparent; transition: all 0.3s ease; }
        
        .admin-nav-link:hover { color: #ffffff; background: rgba(255, 255, 255, 0.04); }
        .admin-nav-link:hover .nav-link-icon { border-color: var(--border-hover); color: #ffffff; transform: scale(1.06); }
        .admin-nav-link:hover .nav-link-indicator { background: var(--insta-magenta); box-shadow: 0 0 10px var(--insta-magenta); }
        
        .admin-nav-link.active { color: #ffffff; background: rgba(255, 255, 255, 0.05); }
        .admin-nav-link.active::before { transform: scaleY(1); }
        .admin-nav-link.active .nav-link-icon { background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-magenta) 50%, var(--insta-orange) 100%); color: #ffffff; border: none; box-shadow: 0 4px 14px rgba(225, 48, 108, 0.35); }
        .admin-nav-link.active .nav-link-badge { border-color: rgba(255,255,255,0.15); color: #ffffff; }
        .admin-nav-link.active .nav-link-indicator { background: var(--insta-orange); box-shadow: 0 0 12px var(--insta-orange); }
        
        /* SIDEBAR FOOTER */
        .admin-sidebar-footer-modern { padding: 1.5rem 1rem; border-top: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 0.5rem; }
        .sidebar-footer-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.8rem 1rem; border-radius: 12px; color: var(--text-secondary); font-size: 0.88rem; font-weight: 500; transition: all 0.3s ease; text-decoration: none; }
        .sidebar-footer-link:hover { background: rgba(255,255,255,0.04); color: #ffffff; }
        .sidebar-logout-btn { width: 100%; display: flex; align-items: center; gap: 0.75rem; padding: 0.8rem 1rem; border-radius: 12px; background: rgba(239, 68, 68, 0.06); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; font-size: 0.88rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        .sidebar-logout-btn:hover { background: rgba(239, 68, 68, 0.15); border-color: rgba(239, 68, 68, 0.35); color: #ffffff; transform: translateY(-2px); box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2); }
        
        /* MAIN WRAPPER */
        .admin-main-wrapper { margin-left: 280px; min-height: 100vh; display: flex; flex-direction: column; position: relative; z-index: 1; }
        
        /* TOPBAR */
        .admin-topbar { height: 80px; background: rgba(13, 14, 20, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 2.2rem; position: sticky; top: 0; z-index: 100; }
        .topbar-left { display: flex; align-items: center; gap: 1.5rem; }
        .mobile-menu-toggle { display: none; width: 42px; height: 42px; border-radius: 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: #ffffff; font-size: 1.1rem; cursor: pointer; transition: all 0.3s ease; align-items: center; justify-content: center; }
        .mobile-menu-toggle:hover { background: rgba(255,255,255,0.06); border-color: var(--border-hover); transform: scale(1.05); }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 0.6rem; font-size: 0.92rem; color: var(--text-secondary); }
        .breadcrumb-separator { color: var(--text-muted); }
        .breadcrumb-current { color: #ffffff; font-weight: 600; }
        .topbar-right { display: flex; align-items: center; gap: 1.5rem; }
        
        /* SEARCH */
        .topbar-search { display: flex; align-items: center; gap: 0.75rem; padding: 0.65rem 1.25rem; border-radius: 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); transition: all 0.3s ease; }
        .topbar-search:focus-within { background: rgba(255,255,255,0.06); border-color: var(--border-hover); box-shadow: 0 0 15px rgba(255,255,255,0.05); }
        .topbar-search i { color: var(--text-muted); font-size: 0.9rem; }
        .topbar-search input { background: none; border: none; outline: none; color: #ffffff; font-size: 0.9rem; width: 190px; }
        .topbar-search input::placeholder { color: var(--text-muted); }
        
        /* NOTIFICATION */
        .topbar-notification { position: relative; }
        .notification-btn { width: 44px; height: 44px; border-radius: 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: var(--text-secondary); font-size: 1.15rem; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; }
        .notification-btn:hover { background: rgba(255,255,255,0.07); color: #ffffff; transform: scale(1.05); border-color: var(--border-hover); }
        .notification-dot { position: absolute; top: 10px; right: 10px; width: 8px; height: 8px; border-radius: 50%; background: #ef4444; border: 2px solid var(--bg-panel); box-shadow: 0 0 8px #ef4444; }
        
        /* USER */
        .topbar-user { display: flex; align-items: center; gap: 0.85rem; padding: 0.45rem 0.8rem 0.45rem 0.45rem; border-radius: 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); cursor: pointer; transition: all 0.3s ease; }
        .topbar-user:hover { background: rgba(255,255,255,0.07); border-color: var(--border-hover); }
        .user-avatar { width: 38px; height: 38px; border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-orange) 100%); border: 1px solid rgba(255,255,255,0.2); }
        .user-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .user-info { display: flex; flex-direction: column; gap: 0.1rem; }
        .user-name { font-size: 0.88rem; font-weight: 600; color: #ffffff; }
        .user-role { font-size: 0.72rem; color: var(--text-muted); }
        .topbar-user > i { color: var(--text-muted); font-size: 0.8rem; margin-left: 0.25rem; }
        
        /* CONTENT */
        .admin-content { flex: 1; padding: 2.5rem 2.2rem; background: transparent; }
        .content-wrapper { max-width: 1400px; margin: 0 auto; }
        
        /* CARDS (GLASSMORPHISM) */
        .admin-card { 
            background: var(--bg-card); 
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 20px; 
            padding: 2.2rem; 
            border: 1px solid var(--border-color); 
            margin-bottom: 1.75rem; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); 
        }
        .admin-card:hover { 
            border-color: var(--border-hover); 
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
        }
        .admin-card-title { font-size: 1.25rem; font-weight: 700; color: #ffffff; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.85rem; letter-spacing: -0.3px; }
        .admin-card-title i { color: var(--insta-orange); font-size: 1.3rem; }
        
        /* TABLES */
        .admin-table-container {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            background: rgba(10, 10, 15, 0.6);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .admin-table th {
            padding: 1.1rem 1.25rem;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid var(--border-color);
        }

        .admin-table td {
            padding: 1.1rem 1.25rem;
            font-size: 0.92rem;
            color: #ffffff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            vertical-align: middle;
        }

        .admin-table tbody tr {
            transition: background 0.3s ease;
        }

        .admin-table tbody tr:hover td {
            background: rgba(255, 255, 255, 0.03);
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* FORMS */
        .form-group { margin-bottom: 1.75rem; }
        .form-label { display: block; font-size: 0.82rem; font-weight: 700; color: var(--text-primary); text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 0.65rem; }
        .form-input, .form-textarea { width: 100%; padding: 0.95rem 1.25rem; font-size: 0.95rem; border: 1px solid var(--border-color); border-radius: 14px; background: rgba(255, 255, 255, 0.03); color: #ffffff; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); font-family: inherit; font-weight: 300; }
        .form-input:focus, .form-textarea:focus { outline: none; border-color: rgba(225, 48, 108, 0.5); box-shadow: 0 0 0 4px rgba(225, 48, 108, 0.15); transform: translateY(-2px); background: rgba(255, 255, 255, 0.05); }
        .form-input::placeholder, .form-textarea::placeholder { color: var(--text-muted); }
        select.form-input option { background-color: #0d0e14 !important; color: #ffffff !important; }
        
        /* CUSTOM FILE INPUT BUTTONS & DROPZONES */
        input[type="file"] {
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed rgba(255, 255, 255, 0.18);
            padding: 0.65rem 0.85rem;
            border-radius: 14px;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.88rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.35s ease;
        }

        input[type="file"]:hover {
            border-color: rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.04);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        input[type="file"]::file-selector-button,
        input[type="file"]::-webkit-file-upload-button {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.03) 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 0.55rem 1.1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            margin-right: 1rem;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        input[type="file"]::file-selector-button:hover,
        input[type="file"]::-webkit-file-upload-button:hover {
            background: linear-gradient(135deg, var(--insta-purple) 0%, var(--insta-magenta) 50%, var(--insta-orange) 100%);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 6px 20px rgba(225, 48, 108, 0.45);
            transform: translateY(-2px);
            color: #ffffff;
        }
        
        /* BUTTONS */
        .btn-primary { 
            padding: 0.95rem 1.9rem; 
            font-size: 0.95rem; 
            font-weight: 700; 
            color: #ffffff; 
            background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-purple) 25%, var(--insta-magenta) 50%, var(--insta-orange) 75%, var(--insta-yellow) 100%); 
            background-size: 200% auto;
            border: none; 
            border-radius: 14px; 
            cursor: pointer; 
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            gap: 0.65rem; 
            box-shadow: 0 4px 20px rgba(225, 48, 108, 0.25);
            text-decoration: none;
        }
        .btn-primary:hover { 
            background-position: right center;
            transform: translateY(-3px) scale(1.02); 
            box-shadow: 0 10px 30px rgba(225, 48, 108, 0.5); 
            color: #ffffff;
        }
        .btn-action { 
            padding: 0.55rem 0.85rem; 
            font-size: 0.85rem; 
            font-weight: 600; 
            border-radius: 10px; 
            cursor: pointer; 
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            gap: 0.5rem; 
            color: #38bdf8; 
            background: rgba(56, 189, 248, 0.08); 
            border: 1px solid rgba(56, 189, 248, 0.2); 
        }
        .btn-action:hover { 
            background: rgba(56, 189, 248, 0.22); 
            color: #ffffff; 
            transform: translateY(-2px); 
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.3); 
        }
        .btn-action.btn-delete { 
            color: #f87171; 
            background: rgba(239, 68, 68, 0.08); 
            border: 1px solid rgba(239, 68, 68, 0.2); 
        }
        .btn-action.btn-delete:hover { 
            background: rgba(239, 68, 68, 0.22); 
            color: #ffffff; 
            transform: translateY(-2px); 
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); 
        }
        .btn-action-text {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.6rem 1.1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .btn-action-text:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }
        
        /* ALERTS MODERN */
        .alert-modern { display: flex; align-items: flex-start; gap: 1rem; padding: 1.25rem 1.5rem; border-radius: 16px; margin-bottom: 1.5rem; border: 1px solid; animation: alertSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; }
        @keyframes alertSlideIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .alert-modern.alert-fade-out { animation: alertFadeOut 0.3s ease forwards; }
        @keyframes alertFadeOut { to { opacity: 0; transform: translateY(-10px); } }
        .alert-modern::before { content: ''; position: absolute; left: 0; top: 0; width: 4px; height: 100%; }
        .alert-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
        .alert-content { flex: 1; }
        .alert-title { font-size: 0.95rem; font-weight: 700; margin-bottom: 0.25rem; }
        .alert-message { font-size: 0.88rem; margin: 0; color: var(--text-secondary); }
        .alert-list { margin: 0.5rem 0 0 0; padding-left: 1.25rem; color: var(--text-secondary); font-size: 0.88rem; }
        .alert-close { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: var(--text-secondary); font-size: 1rem; cursor: pointer; transition: all 0.3s ease; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
        .alert-close:hover { background: rgba(255,255,255,0.06); color: #ffffff; transform: scale(1.05); }
        .alert-success { background: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2); }
        .alert-success::before { background: #10b981; }
        .alert-success .alert-icon { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .alert-success .alert-title { color: #10b981; }
        .alert-error { background: rgba(239, 68, 68, 0.05); border-color: rgba(239, 68, 68, 0.25); }
        .alert-error::before { background: #ef4444; }
        .alert-error .alert-icon { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .alert-error .alert-title { color: #ef4444; }
        
        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .admin-sidebar-modern { transform: translateX(-100%); }
            .admin-sidebar-modern.sidebar-open { transform: translateX(0); box-shadow: 4px 0 25px rgba(0, 0, 0, 0.6); }
            .admin-main-wrapper { margin-left: 0; }
            .mobile-menu-toggle { display: flex; }
            .topbar-search { display: none; }
        }
        
        @media (max-width: 768px) {
            .admin-topbar { padding: 0 1.25rem; height: 75px; }
            .admin-content { padding: 1.75rem 1.25rem; }
            .topbar-user .user-info { display: none; }
            .topbar-notification { display: none; }
            .admin-sidebar-modern { width: 260px; }
        }
        
        @media (max-width: 640px) {
            .admin-sidebar-modern { width: 100%; max-width: 270px; }
            .breadcrumb-current { font-size: 0.85rem; }
        }

        /* DYNAMIC TOAST ANIMATIONS */
        @keyframes toastSlideIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes toastSlideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(120%); opacity: 0; }
        }
        .toast-fade-out {
            animation: toastSlideOut 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
        }
    </style>
</head>
<body class="admin-body">

    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar-modern" id="adminSidebar">
        <!-- Logo -->
        <div class="admin-sidebar-header">
            <div class="admin-logo-modern">
                <div class="logo-icon-script">JC</div>
                <div class="logo-text">
                    <span class="logo-title">CreativeUP</span>
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

        // Floating Toast Notification
        function showToast(message, type = 'success') {
            const existing = document.querySelectorAll('.dynamic-toast');
            existing.forEach(el => el.remove());

            const toast = document.createElement('div');
            toast.className = `alert-modern alert-${type} dynamic-toast`;
            toast.style.position = 'fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '99999';
            toast.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.4)';
            toast.style.minWidth = '320px';
            toast.style.maxWidth = '450px';
            toast.style.margin = '0';
            toast.style.animation = 'toastSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1)';

            const icon = type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation';
            const title = type === 'success' ? '¡Éxito!' : '¡Error!';

            toast.innerHTML = `
                <div class="alert-icon">
                    <i class="fa-solid ${icon}"></i>
                </div>
                <div class="alert-content">
                    <h4 class="alert-title">${title}</h4>
                    <p class="alert-message">${message}</p>
                </div>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('toast-fade-out');
                setTimeout(() => toast.remove(), 400);
            }, 5000);
        }

        // Global AJAX Form Interceptor
        document.addEventListener('submit', function(e) {
            const form = e.target;
            
            // Skip logout form
            if (form.action.includes('logout')) return;
            
            // Handle lists and settings forms without refreshing page
            const isDelete = form.querySelector('input[name="_method"][value="DELETE"]') !== null;
            const isToggle = form.action.includes('toggle-visibility') || form.action.includes('toggle') || form.action.includes('status');
            const isSettings = form.action.includes('update-text') || form.action.includes('biography') || form.action.includes('profile') || (form.method.toUpperCase() === 'POST' && !form.action.includes('skills') && !form.action.includes('projects') && !form.action.includes('travels'));
            
            if (!isDelete && !isToggle && !isSettings) return;
            
            e.preventDefault();
            
            // Show loading on submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalHTML = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn && isSettings) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right: 0.5rem;"></i> Guardando...';
            }
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: form.method || 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server returned error status ' + response.status);
                }
                return response.text();
            })
            .then(htmlText => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(htmlText, 'text/html');
                
                // If there was validation/server errors, display them
                const errorAlert = doc.querySelector('.alert-modern.alert-error');
                if (errorAlert) {
                    if (submitBtn && isSettings) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHTML;
                    }
                    const currentError = document.querySelector('.alert-modern.alert-error');
                    if (currentError) {
                        currentError.replaceWith(errorAlert);
                    } else {
                        const contentWrapper = document.querySelector('.content-wrapper');
                        if (contentWrapper) {
                            contentWrapper.insertBefore(errorAlert, contentWrapper.firstChild);
                        }
                    }
                    showToast('Hubo un error al procesar tu solicitud.', 'error');
                    return;
                }
                
                // Update content in place!
                const newContent = doc.querySelector('.content-wrapper');
                const oldContent = document.querySelector('.content-wrapper');
                if (newContent && oldContent) {
                    oldContent.innerHTML = newContent.innerHTML;
                }
                
                // Clear any existing errors block
                document.querySelector('.alert-modern.alert-error')?.remove();
                
                // Extract success message
                const successAlert = doc.querySelector('.alert-modern.alert-success, #alertSuccess');
                const msg = successAlert ? successAlert.querySelector('.alert-message').textContent : 'Los cambios han sido guardados.';
                
                showToast(msg, 'success');
            })
            .catch(err => {
                if (submitBtn && isSettings) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                }
                console.error(err);
                showToast('Error al conectar con el servidor.', 'error');
            });
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
                        preview.style.opacity = '1';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Global Page Helpers (keep defined after DOM replacements)
        function handleImageUpload(input) {
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileNameDisplay = document.getElementById('hero-file-name');
                if (fileNameDisplay) fileNameDisplay.textContent = fileName;
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview-hero');
                    const placeholder = document.getElementById('preview-placeholder');
                    
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function handleBackgroundsUpload(input) {
            const fileCount = input.files.length;
            const displaySpan = document.getElementById('bg-file-count');
            if (displaySpan) {
                if (fileCount > 0) {
                    displaySpan.textContent = fileCount === 1 ? '1 archivo seleccionado' : fileCount + ' archivos seleccionados';
                } else {
                    displaySpan.textContent = 'Sin archivos seleccionados';
                }
            }
        }

        function markBackgroundForDeletion(bgPath, index) {
            const container = document.getElementById('deleted-backgrounds-container');
            if (container) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_backgrounds[]';
                input.value = bgPath;
                container.appendChild(input);
            }

            const thumbCard = document.getElementById('bg-thumb-' + index);
            if (thumbCard) {
                thumbCard.style.opacity = '0.35';
                thumbCard.style.pointerEvents = 'none';
                const btn = thumbCard.querySelector('button');
                if (btn) btn.style.display = 'none';
            }
        }
    </script>
</body>
</html>
