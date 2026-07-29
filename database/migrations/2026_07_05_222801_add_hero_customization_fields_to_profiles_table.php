<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('hero_status_text')->nullable()->default('Disponible para proyectos')->after('location');
            $table->string('hero_float_icon')->nullable()->default('fa-solid fa-code')->after('hero_status_text');
            $table->string('hero_float_label')->nullable()->default('Experiencia')->after('hero_float_icon');
            $table->string('hero_float_value')->nullable()->default('Full-Stack Dev')->after('hero_float_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'hero_status_text',
                'hero_float_icon',
                'hero_float_label',
                'hero_float_value',
            ]);
        });
    }
};
