<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'preferred_categories'];

    protected $casts = [
        'preferred_categories' => 'array',
    ];

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function events() {
        return $this->hasMany(Event::class, 'created_by');
    }
}
