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
        Schema::table('travels', function (Blueprint $table) {
            $table->string('travel_date')->nullable()->after('year');
            $table->string('audio_path')->nullable()->after('image_path');
            $table->string('media_type')->default('image')->after('audio_path'); // 'image' or 'video'
            $table->string('video_path')->nullable()->after('media_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travels', function (Blueprint $table) {
            $table->dropColumn(['travel_date', 'audio_path', 'media_type', 'video_path']);
        });
    }
};
