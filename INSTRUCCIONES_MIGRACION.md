# Instrucciones para Activar la Edición de Biografía en Admin

## Paso 1: Ejecutar la Migración

Abre tu terminal en la carpeta del proyecto y ejecuta:

```bash
php artisan migrate
```

Esto agregará los nuevos campos a la tabla `profiles`:
- `bio_tag` - Etiqueta superior
- `bio_title` - Título principal
- `bio_description` - Descripción detallada
- `workspace_image` - Imagen del workspace
- `tech_image` - Imagen del tech stack
- `workspace_title` - Título del workspace
- `workspace_desc` - Descripción del workspace
- `tech_title` - Título del tech stack
- `tech_desc` - Descripción del tech stack

## Paso 2: Verificar el Formulario Admin

1. Ve a tu panel admin: `http://localhost/portfolio/admin`
2. Deberías ver una nueva sección llamada **"Contenido Sección de Biografía"**
3. Allí podrás editar:
   - **Imagen Grande (Perfil Principal)**
     - Etiqueta Superior
     - Título Principal
     - Descripción Detallada
   
   - **Imagen Workspace**
     - Subir imagen personalizada
     - Título
     - Descripción
   
   - **Imagen Tech Stack**
     - Subir imagen personalizada
     - Título
     - Descripción

## Paso 3: Editar el Contenido

1. Cambia los textos según tus preferencias
2. Sube imágenes personalizadas si lo deseas (opcional - hay defaults)
3. Haz clic en **"Guardar Todo el Perfil"**

## Valores por Defecto

Si no editas nada, se mostrarán estos textos predeterminados:

- **Etiqueta**: "El Humano Detrás del Código"
- **Título**: "Transformo Ideas en Realidad Digital"
- **Descripción**: "Arquitecto de experiencias digitales..."
- **Workspace Título**: "Mi Laboratorio"
- **Workspace Desc**: "Donde las ideas cobran vida y el café se transforma en código"
- **Tech Título**: "Stack Tecnológico"
- **Tech Desc**: "Herramientas de vanguardia para construir el futuro"

## Imágenes

Las imágenes se guardarán en: `public/uploads/`
- `workspace_TIMESTAMP.jpg/png`
- `tech_TIMESTAMP.jpg/png`

Si no subes imágenes personalizadas, se usarán las defaults:
- `public/images/bio_workspace.png`
- `public/images/bio_tech.png`

## ¡Listo!

Ahora todo el contenido de la sección de biografía es 100% editable desde el panel admin.
