<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed default admin user
        User::create([
            'name' => 'Carlos Mendoza',
            'email' => 'admin@portfolio.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Seed profile information
        Profile::create([
            'name' => 'Carlos Mendoza',
            'title' => 'Ingeniero de Sistemas / Arquitecto Cloud',
            'bio' => 'Soy Ingeniero de Sistemas especializado en el desarrollo e integración de soluciones en la nube, optimización de infraestructura y automatización de despliegues (CI/CD). Cuento con sólida experiencia liderando proyectos backend complejos y diseñando arquitecturas basadas en microservicios.',
            'photo_path' => 'images/default_engineer.png',
            'cv_path' => null, // CV starts as null, can be uploaded via panel
            'email' => 'carlos.mendoza@portfolio.com',
            'phone' => '+57 300 123 4567',
            'github_url' => 'https://github.com',
            'linkedin_url' => 'https://linkedin.com',
        ]);

        // 3. Seed technical skills
        // Backend Skills
        Skill::create([
            'name' => 'Laravel / PHP',
            'category' => 'Backend',
            'proficiency' => 92,
            'icon_class' => 'fa-brands fa-laravel',
            'order' => 1,
        ]);
        Skill::create([
            'name' => 'Python / Django',
            'category' => 'Backend',
            'proficiency' => 85,
            'icon_class' => 'fa-brands fa-python',
            'order' => 2,
        ]);
        Skill::create([
            'name' => 'Node.js / Express',
            'category' => 'Backend',
            'proficiency' => 80,
            'icon_class' => 'fa-brands fa-node-js',
            'order' => 3,
        ]);

        // Frontend Skills
        Skill::create([
            'name' => 'JavaScript (ES6+)',
            'category' => 'Frontend',
            'proficiency' => 88,
            'icon_class' => 'fa-brands fa-square-js',
            'order' => 1,
        ]);
        Skill::create([
            'name' => 'React / Vue.js',
            'category' => 'Frontend',
            'proficiency' => 78,
            'icon_class' => 'fa-brands fa-react',
            'order' => 2,
        ]);
        Skill::create([
            'name' => 'HTML5 / CSS3',
            'category' => 'Frontend',
            'proficiency' => 90,
            'icon_class' => 'fa-brands fa-css3-alt',
            'order' => 3,
        ]);

        // Database Skills
        Skill::create([
            'name' => 'PostgreSQL / MySQL',
            'category' => 'Bases de Datos',
            'proficiency' => 88,
            'icon_class' => 'fa-solid fa-database',
            'order' => 1,
        ]);
        Skill::create([
            'name' => 'Redis (Caching)',
            'category' => 'Bases de Datos',
            'proficiency' => 80,
            'icon_class' => 'fa-solid fa-bolt',
            'order' => 2,
        ]);

        // DevOps / Cloud Skills
        Skill::create([
            'name' => 'Docker',
            'category' => 'DevOps / Nube',
            'proficiency' => 90,
            'icon_class' => 'fa-brands fa-docker',
            'order' => 1,
        ]);
        Skill::create([
            'name' => 'Amazon Web Services (AWS)',
            'category' => 'DevOps / Nube',
            'proficiency' => 85,
            'icon_class' => 'fa-brands fa-aws',
            'order' => 2,
        ]);
        Skill::create([
            'name' => 'Kubernetes (K8s)',
            'category' => 'DevOps / Nube',
            'proficiency' => 75,
            'icon_class' => 'fa-solid fa-circle-nodes',
            'order' => 3,
        ]);
        Skill::create([
            'name' => 'CI/CD (GitHub Actions)',
            'category' => 'DevOps / Nube',
            'proficiency' => 82,
            'icon_class' => 'fa-solid fa-arrows-spin',
            'order' => 4,
        ]);

        // 4. Seed sample systems engineering projects
        Project::create([
            'title' => 'Orquestación de Microservicios Cloud',
            'description' => 'Diseño e implementación de una infraestructura de microservicios escalable y tolerante a fallos en AWS utilizando Kubernetes (EKS). Automatización mediante Helm Charts e integración de Prometheus y Grafana para monitorización.',
            'image_path' => 'uploads/projects/project_cloud.png',
            'tech_stack' => 'Kubernetes, AWS EKS, Docker, Helm, Prometheus, Grafana',
            'project_url' => 'https://github.com',
            'github_url' => 'https://github.com',
            'order' => 1,
        ]);

        Project::create([
            'title' => 'Clúster PostgreSQL de Alta Disponibilidad',
            'description' => 'Arquitectura y despliegue de un clúster relacional PostgreSQL con replicación streaming activa y recuperación ante fallos automático gestionada por Patroni. Balanceo de conexiones a través de PgBouncer.',
            'image_path' => 'uploads/projects/project_database.png',
            'tech_stack' => 'PostgreSQL, Patroni, Consul, PgBouncer, Ansible, Linux',
            'project_url' => 'https://github.com',
            'github_url' => 'https://github.com',
            'order' => 2,
        ]);

        $this->call(TravelSeeder::class);
    }
}
