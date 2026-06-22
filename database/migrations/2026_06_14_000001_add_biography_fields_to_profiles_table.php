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
            $table->string('bio_tag')->nullable()->after('bio');
            $table->string('bio_title')->nullable()->after('bio_tag');
            $table->text('bio_description')->nullable()->after('bio_title');
            $table->string('workspace_image')->nullable()->after('photo_path');
            $table->string('tech_image')->nullable()->after('workspace_image');
            $table->string('workspace_title')->nullable()->after('tech_image');
            $table->text('workspace_desc')->nullable()->after('workspace_title');
            $table->string('tech_title')->nullable()->after('workspace_desc');
            $table->text('tech_desc')->nullable()->after('tech_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'bio_tag',
                'bio_title',
                'bio_description',
                'workspace_image',
                'tech_image',
                'workspace_title',
                'workspace_desc',
                'tech_title',
                'tech_desc',
            ]);
        });
    }
};
