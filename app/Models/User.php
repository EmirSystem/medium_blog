<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillalbe = [
        'role_id',
        'name',
        'email',
        'password',
        'bio',
        'avatar',
        'status',
    ];

    protected $hidden =
    [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function isSuperAdmin()
    {
        return $this->role?->slug === 'super-admin';
    }

    public function isYazar()
    {
        return $this->role?->slug === 'yazar';
    }
}
