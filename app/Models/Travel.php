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
        'location',
        'country',
        'year',
        'travel_date',
        'description',
        'content',
        'image_path',
        'audio_path',
        'media_type',
        'video_path',
        'badge',
        'meta_1_icon',
        'meta_1_text',
        'meta_2_icon',
        'meta_2_text',
        'order',
    ];
}
