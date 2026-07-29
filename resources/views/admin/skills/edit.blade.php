@extends('layouts.admin')

@section('title', 'Editar Habilidad')
@section('page_title', 'Editar Habilidad')

@section('content')

<div class="admin-card glass" style="max-width: 600px;">
    <div class="admin-card-title">Detalles de la Habilidad: {{ $skill->name }}</div>

    <form action="{{ route('admin.skills.update', $skill) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="predefined_tech" class="form-label" style="color: var(--insta-orange); font-weight: 700;">Pre-cargar Tecnología Común (Opcional)</label>
            <select id="predefined_tech" class="form-input" style="cursor: pointer; border-color: rgba(245, 96, 64, 0.4);">
                <option value="">-- Selecciona una tecnología para auto-completar --</option>
                <option value="python" data-name="PYTHON" data-icon="devicon-python-plain" data-category="Backend">PYTHON (Python Logo)</option>
                <option value="git" data-name="GIT" data-icon="devicon-git-plain" data-category="Herramientas / Otros">GIT (Git Logo)</option>
                <option value="sqlserver" data-name="SQLServer" data-icon="devicon-microsoftsqlserver-plain" data-category="Bases de Datos">SQLServer (SQL Server Logo)</option>
                <option value="js" data-name="JS" data-icon="devicon-javascript-plain" data-category="Frontend">JS (JavaScript Logo)</option>
                <option value="php" data-name="PHP" data-icon="devicon-php-plain" data-category="Backend">PHP (PHP Logo)</option>
                <option value="mysql" data-name="MYSQL" data-icon="devicon-mysql-plain" data-category="Bases de Datos">MYSQL (MySQL Logo)</option>
                <option value="postgresql" data-name="PostgreSQL" data-icon="devicon-postgresql-plain" data-category="Bases de Datos">PostgreSQL (PostgreSQL Logo)</option>
                <option value="aws" data-name="AWS" data-icon="devicon-amazonwebservices-original" data-category="DevOps / Nube">AWS (Amazon Web Services)</option>
                <option value="scrum" data-name="SCRUM" data-icon="fa-solid fa-people-group" data-category="Herramientas / Otros">SCRUM (Metodología Ágil)</option>
                <option value="gestion_proyectos" data-name="Gestión de Proyectos" data-icon="fa-solid fa-diagram-project" data-category="Herramientas / Otros">Gestión de Proyectos (Ing. de Sistemas)</option>
                <option value="arquitectura_software" data-name="Arquitectura de Software" data-icon="fa-solid fa-sitemap" data-category="Herramientas / Otros">Arquitectura de Software (Diseño de Sistemas)</option>
                <option value="metodologias_agiles" data-name="Metodologías Ágiles" data-icon="fa-solid fa-rotate" data-category="Herramientas / Otros">Metodologías Ágiles (Desarrollo Ágil)</option>
                <option value="laravel" data-name="Laravel" data-icon="devicon-laravel-plain" data-category="Backend">Laravel (Laravel Logo)</option>
                <option value="react" data-name="React" data-icon="devicon-react-original" data-category="Frontend">React (React Logo)</option>
                <option value="nodejs" data-name="Node.js" data-icon="devicon-nodejs-plain" data-category="Backend">Node.js (Node.js Logo)</option>
                <option value="docker" data-name="Docker" data-icon="devicon-docker-plain" data-category="DevOps / Nube">Docker (Docker Logo)</option>
                <option value="html5" data-name="HTML5" data-icon="devicon-html5-plain" data-category="Frontend">HTML5 (HTML5 Logo)</option>
                <option value="css3" data-name="CSS3" data-icon="devicon-css3-plain" data-category="Frontend">CSS3 (CSS3 Logo)</option>
                <option value="mongodb" data-name="MongoDB" data-icon="devicon-mongodb-plain" data-category="Bases de Datos">MongoDB (MongoDB Logo)</option>
                <option value="angular" data-name="Angular" data-icon="devicon-angularjs-plain" data-category="Frontend">Angular (Angular Logo)</option>
                <option value="vuejs" data-name="Vue.js" data-icon="devicon-vuejs-plain" data-category="Frontend">Vue.js (Vue Logo)</option>
                <option value="typescript" data-name="TypeScript" data-icon="devicon-typescript-plain" data-category="Frontend">TypeScript (TypeScript Logo)</option>
                <option value="linux" data-name="Linux" data-icon="devicon-linux-plain" data-category="Herramientas / Otros">Linux (Linux Logo)</option>
                <option value="nginx" data-name="Nginx" data-icon="devicon-nginx-plain" data-category="DevOps / Nube">Nginx (Nginx Logo)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="name" class="form-label">Nombre de la Habilidad *</label>
            <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $skill->name) }}" required>
        </div>

        <div class="form-group">
            <label for="category" class="form-label">Categoría *</label>
            <select name="category" id="category" class="form-input" required style="cursor: pointer;">
                <option value="">Selecciona una categoría...</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category', $skill->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="proficiency" class="form-label">Porcentaje de Dominio (1-100) *</label>
                <input type="number" name="proficiency" id="proficiency" class="form-input" min="1" max="100" value="{{ old('proficiency', $skill->proficiency) }}" required>
            </div>
            
            <div class="form-group">
                <label for="order" class="form-label">Orden de Prioridad *</label>
                <input type="number" name="order" id="order" class="form-input" value="{{ old('order', $skill->order) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="icon_class" class="form-label">Clase de Icono (FontAwesome o Devicon, Opcional)</label>
            <input type="text" name="icon_class" id="icon_class" class="form-input" value="{{ old('icon_class', $skill->icon_class) }}">
            <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">
                Clase de FontAwesome (ej: <code>fa-brands fa-laravel</code>) o de Devicon (ej: <code>devicon-python-plain</code>).
            </span>
        </div>

        <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.skills.index') }}" class="btn-action-text" style="display: flex; align-items: center; justify-content: center;">
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

    <script>
        document.getElementById('predefined_tech').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const name = selectedOption.getAttribute('data-name');
                const icon = selectedOption.getAttribute('data-icon');
                const category = selectedOption.getAttribute('data-category');
                
                const nameInput = document.getElementById('name');
                const iconInput = document.getElementById('icon_class');
                const catSelect = document.getElementById('category');
                
                if (nameInput) nameInput.value = name;
                if (iconInput) iconInput.value = icon;
                if (catSelect) {
                    for (let i = 0; i < catSelect.options.length; i++) {
                        if (catSelect.options[i].value === category) {
                            catSelect.selectedIndex = i;
                            break;
                        }
                    }
                }
            }
        });
    </script>
@endsection
