<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'tech_stack',
        'project_url',
        'github_url',
        'order',
    ];

    /**
     * Get technologies as an array.
     */
    public function getTechStackArrayAttribute(): array
    {
        if (empty($this->tech_stack)) {
            return [];
        }
        return array_map('trim', explode(',', $this->tech_stack));
    }
}
