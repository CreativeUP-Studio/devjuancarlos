<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'bio',
        'bio_tag',
        'bio_title',
        'bio_description',
        'photo_path',
        'hero_bg_image',
        'workspace_image',
        'tech_image',
        'workspace_title',
        'workspace_desc',
        'tech_title',
        'tech_desc',
        'github_url',
        'linkedin_url',
        'email',
        'phone',
        'location',
        'cv_path',
    ];
}
