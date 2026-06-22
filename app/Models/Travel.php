<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;

    protected $table = 'travels';

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'badge',
        'meta_1_icon',
        'meta_1_text',
        'meta_2_icon',
        'meta_2_text',
        'order',
    ];
}
