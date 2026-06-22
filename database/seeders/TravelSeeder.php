<?php

namespace Database\Seeders;

use App\Models\Travel;
use Illuminate\Database\Seeder;

class TravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Travel::create([
            'title' => 'Machu Picchu',
            'description' => 'Explorando la imponente ciudadela inca oculta entre los picos andinos, donde la historia y la neblina se encuentran.',
            'image_path' => 'images/travel_peru.png',
            'badge' => 'Perú · 2025',
            'meta_1_icon' => 'fa-solid fa-plane-departure',
            'meta_1_text' => 'Aventura',
            'meta_2_icon' => 'fa-solid fa-camera',
            'meta_2_text' => 'Fotografía',
            'order' => 1,
        ]);

        Travel::create([
            'title' => 'Tokio y Kioto',
            'description' => 'El contraste perfecto entre el bullicio tecnológico de Shibuya y los tranquilos santuarios y templos de Kioto.',
            'image_path' => 'images/travel_japan.png',
            'badge' => 'Japón · 2024',
            'meta_1_icon' => 'fa-solid fa-train-subway',
            'meta_1_text' => 'Cultural',
            'meta_2_icon' => 'fa-solid fa-city',
            'meta_2_text' => 'Urbana',
            'order' => 2,
        ]);

        Travel::create([
            'title' => 'Auroras en Islandia',
            'description' => 'Recorrido por paisajes volcánicos, glaciares y cascadas salvajes bajo el mágico baile de las luces del norte.',
            'image_path' => 'images/travel_iceland.png',
            'badge' => 'Islandia · 2025',
            'meta_1_icon' => 'fa-solid fa-snowflake',
            'meta_1_text' => 'Glaciares',
            'meta_2_icon' => 'fa-solid fa-mountain',
            'meta_2_text' => 'Naturaleza',
            'order' => 3,
        ]);

        Travel::create([
            'title' => 'Historia en Roma',
            'description' => 'Caminando por las calles de piedra de la ciudad eterna, reviviendo la grandeza del Coliseo y el Vaticano.',
            'image_path' => 'images/travel_italy.png',
            'badge' => 'Italia · 2023',
            'meta_1_icon' => 'fa-solid fa-monument',
            'meta_1_text' => 'Histórico',
            'meta_2_icon' => 'fa-solid fa-utensils',
            'meta_2_text' => 'Gastronomía',
            'order' => 4,
        ]);
    }
}
