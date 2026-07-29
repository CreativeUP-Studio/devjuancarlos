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
        'steps',
        'features',
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

    /**
     * Get development steps as an array (split by lines or commas).
     */
    public function getStepsArrayAttribute(): array
    {
        if (empty($this->steps)) {
            return [];
        }
        $lines = array_map('trim', explode("\n", $this->steps));
        return array_values(array_filter($lines));
    }

    /**
     * Get key features as an array (split by lines or commas).
     */
    public function getFeaturesArrayAttribute(): array
    {
        if (empty($this->features)) {
            return [];
        }
        $lines = array_map('trim', explode("\n", $this->features));
        return array_values(array_filter($lines));
    }
}
