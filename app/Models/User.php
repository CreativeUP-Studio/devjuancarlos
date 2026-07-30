<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'avatar_path',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get user avatar URL with graceful fallback to profile photo or lifestyle image
     */
    public function getProfilePhotoAttribute(): string
    {
        if (!empty($this->avatar_path) && file_exists(public_path($this->avatar_path))) {
            return asset($this->avatar_path);
        }

        $profile = Profile::first();
        if ($profile && !empty($profile->photo_path) && file_exists(public_path($profile->photo_path))) {
            return asset($profile->photo_path);
        }

        return asset('images/bio_lifestyle.png');
    }
}
