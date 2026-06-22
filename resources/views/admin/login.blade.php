<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Administrador del Portafolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-container">
    @include('partials.preloader')

    <div class="login-card glass shadow-glow">
        <div class="login-header">
            <h2>Panel de <span class="text-gradient">Control</span></h2>
            <p>Ingresa tus credenciales para acceder</p>
        </div>

        @if ($errors->any())
            <div class="alert-box alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-input" placeholder="admin@portfolio.com" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem;">
                <input type="checkbox" name="remember" id="remember" style="accent-color: var(--accent-cyan);">
                <label for="remember" class="form-label" style="margin-bottom: 0; cursor: pointer;">Recordarme en este equipo</label>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1.5rem; text-align: center;">
                Iniciar Sesión
            </button>
        </form>
        
        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('portfolio.index') }}" style="font-size: 0.85rem; color: var(--text-secondary); text-decoration: underline;">
                ← Volver al Portafolio
            </a>
        </div>
    </div>

</body>
</html>
