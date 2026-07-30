<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Panel de Administración</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Alex+Brush&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-light: #ffffff;
            --bg-panel: #ffffff;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --insta-blue: #405de6;
            --insta-purple: #833ab4;
            --insta-magenta: #e1306c;
            --insta-orange: #f56040;
            --insta-yellow: #fcaf45;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            overflow-x: hidden;
        }

        .login-split-container {
            display: flex;
            min-height: 100vh;
            min-height: 100dvh;
            width: 100vw;
            overflow: hidden;
        }

        /* Left Panel - Crisp White Side */
        .login-left-panel {
            flex: 0 0 520px;
            width: 520px;
            background-color: var(--bg-panel);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3.5rem 4rem;
            position: relative;
            z-index: 10;
            animation: panelFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes panelFadeIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Right Panel - Pure Image Side (No Text) */
        .login-right-panel {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .login-right-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-image: url('{{ asset('images/bio_workspace.png') }}');
            transform: scale(1.05);
            animation: zoomBg 12s ease-in-out infinite alternate;
        }

        @keyframes zoomBg {
            from { transform: scale(1.03); }
            to { transform: scale(1.08); }
        }

        /* Brand / Calligraphic JC Logo in dark */
        .login-brand {
            font-family: 'Alex Brush', cursive;
            font-size: 2.8rem;
            color: #0f172a;
            line-height: 1;
            margin-bottom: 2rem;
            width: fit-content;
            cursor: default;
            transition: all 0.4s ease;
        }

        .login-brand:hover {
            background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-purple) 25%, var(--insta-magenta) 50%, var(--insta-orange) 75%, var(--insta-yellow) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Form Container */
        .login-form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .login-header {
            margin-bottom: 2.2rem;
            animation: formFadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards;
            opacity: 0;
        }

        .login-header h1 {
            font-size: 1.85rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            font-size: 0.95rem;
            color: var(--text-secondary);
            font-weight: 300;
        }

        /* Forms Layout & Inputs */
        .form-group {
            margin-bottom: 1.4rem;
            opacity: 0;
            animation: formFadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.3s; }
        .form-group:nth-child(3) { animation-delay: 0.4s; }

        @keyframes formFadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.6rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .form-input {
            width: 100%;
            padding: 0.9rem 1.2rem 0.9rem 2.8rem;
            font-size: 0.95rem;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: #0f172a;
            font-family: inherit;
            font-weight: 300;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .form-input:focus {
            outline: none;
            background: #ffffff;
            border-color: #94a3b8;
            box-shadow: 0 0 0 4px rgba(148, 163, 184, 0.08);
            transform: translateY(-2px);
        }

        .form-input:focus + .input-icon {
            color: #0f172a;
        }

        /* Checkbox customization */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-top: 0;
        }

        .checkbox-input {
            width: 16px;
            height: 16px;
            accent-color: var(--insta-magenta);
            cursor: pointer;
            border-radius: 4px;
            background: #f8fafc;
            border: 1px solid var(--border-color);
        }

        .checkbox-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 300;
            cursor: pointer;
            user-select: none;
        }

        .toggle-password-btn {
            position: absolute;
            right: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1rem;
            cursor: pointer;
            padding: 0.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s ease;
            z-index: 5;
        }

        .toggle-password-btn:hover {
            color: #0f172a;
        }

        .form-input.has-toggle {
            padding-right: 2.8rem;
        }

        .form-row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .forgot-password-link {
            font-size: 0.85rem;
            color: var(--insta-magenta);
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .forgot-password-link:hover {
            opacity: 0.85;
            text-decoration: underline;
        }

        .auth-footer-prompt {
            text-align: center;
            margin-top: 1.8rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
            animation: formFadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.4s forwards;
            opacity: 0;
        }

        .auth-footer-prompt a {
            color: var(--insta-purple);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .auth-footer-prompt a:hover {
            color: var(--insta-magenta);
            text-decoration: underline;
        }

        .alert-success-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 0.9rem 1.2rem;
            margin-bottom: 1.8rem;
            color: #166534;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: formFadeInUp 0.5s ease;
        }

        /* Alert Box */
        .alert-box {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            border-radius: 12px;
            padding: 0.9rem 1.2rem;
            margin-bottom: 1.8rem;
            animation: formShake 0.5s ease;
        }

        @keyframes formShake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-8px); }
            40%, 80% { transform: translateX(8px); }
        }

        .alert-box p {
            color: #ef4444;
            font-size: 0.88rem;
            margin: 0;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Submit Button with Sunset Glow */
        .btn-submit {
            width: 100%;
            padding: 1rem 1.8rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: #ffffff;
            background: linear-gradient(135deg, var(--insta-blue) 0%, var(--insta-purple) 25%, var(--insta-magenta) 50%, var(--insta-orange) 75%, var(--insta-yellow) 100%);
            background-size: 200% auto;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            margin-top: 1.8rem;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            box-shadow: 0 4px 15px rgba(225, 48, 108, 0.15);
        }

        .btn-submit:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(225, 48, 108, 0.45);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Back link styling */
        .back-link {
            animation: formFadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.5s forwards;
            opacity: 0;
        }

        .back-link a {
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 400;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-link a:hover {
            color: #0f172a;
            gap: 0.75rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .login-left-panel {
                flex: 0 0 460px;
                width: 460px;
                padding: 3rem 2.5rem;
            }
        }

        @media (max-width: 900px) {
            .login-right-panel {
                display: none;
            }

            .login-left-panel {
                flex: 1;
                width: 100%;
                max-width: none;
                justify-content: center;
                padding: 3.5rem 3rem;
            }

            .login-brand {
                position: absolute;
                top: 3.5rem;
                left: 3rem;
            }

            .login-form-container {
                justify-content: center;
                max-width: 440px;
                width: 100%;
                margin: 0 auto;
            }

            .back-link {
                position: absolute;
                bottom: 3.5rem;
                left: 3rem;
            }
        }

        @media (max-width: 480px) {
            .login-left-panel {
                padding: 2.5rem 1.5rem;
            }

            .login-brand {
                position: relative;
                top: 0;
                left: 0;
                margin-bottom: 2rem;
            }

            .back-link {
                position: relative;
                bottom: 0;
                left: 0;
                margin-top: 2rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="login-split-container">
        
        <!-- Left Panel: Form Section (White Theme) -->
        <div class="login-left-panel">
            <!-- Caligraphic Script Logo -->
            <div class="login-brand">JC</div>

            <div class="login-form-container">
                <div class="login-header">
                    <h1>Iniciar Sesión</h1>
                    <p>Accede con tus credenciales de administrador</p>
                </div>

                @if (session('status'))
                    <div class="alert-success-box">
                        <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-box">
                        @foreach ($errors->all() as $error)
                            <p><i class="fa-solid fa-triangle-exclamation"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-input" 
                                placeholder="juan@creativeup.com" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                            >
                            <i class="fa-regular fa-envelope input-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-input has-toggle" 
                                placeholder="••••••••" 
                                required
                            >
                            <i class="fa-solid fa-lock input-icon"></i>
                            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('password', this)" tabindex="-1" title="Mostrar/Ocultar contraseña">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group form-row-between">
                        <div class="checkbox-group">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                id="remember" 
                                class="checkbox-input"
                            >
                            <label for="remember" class="checkbox-label">
                                Recordar mi sesión
                            </label>
                        </div>
                        <a href="{{ route('admin.password.request') }}" class="forgot-password-link">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <button type="submit" class="btn-submit">
                        Ingresar al Panel
                    </button>
                </form>

                <div class="auth-footer-prompt">
                    ¿No tienes una cuenta? 
                    <a href="{{ route('admin.register') }}">
                        Regístrate aquí
                    </a>
                </div>
            </div>
            
            <div class="back-link">
                <a href="{{ route('portfolio.index') }}">
                    <i class="fa-solid fa-arrow-left"></i> Volver al Portafolio
                </a>
            </div>
        </div>

        <!-- Right Panel: Image Section (Only Clean Image, No Overlay Text) -->
        <div class="login-right-panel">
            <div class="login-right-image"></div>
        </div>

    </div>

    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
