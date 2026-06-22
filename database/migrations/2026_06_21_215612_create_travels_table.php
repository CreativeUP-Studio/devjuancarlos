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
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->string('badge')->nullable(); // e.g. "Perú · 2025"
            $table->string('meta_1_icon')->default('fa-solid fa-plane-departure');
            $table->string('meta_1_text')->nullable(); // e.g. "Aventura"
            $table->string('meta_2_icon')->default('fa-solid fa-camera');
            $table->string('meta_2_text')->nullable(); // e.g. "Fotografía"
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};
