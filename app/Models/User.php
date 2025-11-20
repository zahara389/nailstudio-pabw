<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Tabel 'users' sudah default, tidak perlu $table

    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'role',
        'photo',
        'status',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi
    public function addresses() { return $this->hasMany(Address::class); }
    public function carts() { return $this->hasMany(Cart::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function favorites() { return $this->hasMany(Favorite::class); }
}