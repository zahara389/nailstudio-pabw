<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
// HAPUS: use Laravel\Sanctum\HasApiTokens; // Baris ini dihapus

class User extends Authenticatable
{
    // HAPUS: use HasApiTokens, HasFactory, Notifiable;
    use HasFactory, Notifiable; 

    /**
     * Kolom yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'phone',
        'address',
        'city',
        'postal_code',
        'photo',
        'status',
        'last_login'
    ];

    /**
     * Kolom yang harus disembunyikan untuk serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Kolom yang harus di-cast ke tipe data tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login' => 'datetime',
    ];
    
    // ==========================================
    // OVERRIDE AUTHENTICATION METHOD (Wajib untuk 'username' login)
    // ==========================================

    /**
     * Mengambil user berdasarkan kolom username untuk otentikasi.
     * Overrides default Laravel behavior (which looks for 'email').
     */
    public function findForLogin($username)
    {
        return $this->where('username', $username)->first();
    }


    // ==========================================
    // RELATIONS
    // ==========================================

    public function carts(): HasMany { return $this->hasMany(Cart::class); }
    public function orders(): HasMany { return $this->hasMany(Order::class); }
    public function reviews(): HasMany { return $this->hasMany(Review::class); }
    public function favorites(): HasMany { return $this->hasMany(Favorite::class); }
    public function bookings(): HasMany { return $this->hasMany(Booking::class); }
    public function questions(): HasMany { return $this->hasMany(UserQuestion::class); }
    public function jobApplications(): HasMany { return $this->hasMany(JobApplication::class); }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeCustomer($query)
    {
        return $query->where('role', 'member'); 
    }
}