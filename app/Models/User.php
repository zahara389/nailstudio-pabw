<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'role', // Penting untuk membedakan Admin dan Customer
        'photo',
        'status',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login' => 'datetime', // Casting last_login ke datetime
    ];

    // --- RELATIONS ---

    public function addresses() { return $this->hasMany(Address::class); }
    // Relasi ke tabel 'cart' (pastikan nama Model Cart benar)
    public function carts() { return $this->hasMany(Cart::class); } 
    public function reviews() { return $this->hasMany(Review::class); }
    public function favorites() { return $this->hasMany(Favorite::class); }


    // --- HELPERS (Untuk memudahkan di View/Controller) ---

    /**
     * Accessor: Mendapatkan nama lengkap (Fullname) atau Username jika fullname kosong.
     */
    public function getNameAttribute()
    {
        return $this->fullname ?? $this->username;
    }

    /**
     * Scope: Hanya mengambil user dengan role 'admin'.
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope: Hanya mengambil user dengan role 'customer'.
     */
    public function scopeCustomer($query)
    {
        return $query->where('role', 'customer');
    }

    /**
     * Helper: Mengecek apakah user adalah admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}