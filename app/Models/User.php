<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name',
        'email',
        'username',
        'password',
        'role',          // 'admin' atau 'member'
        'phone',
        'address',
        'city',
        'postal_code',
        'photo',
        'status',        // 'active' atau 'inactive'
        'last_login'
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
        'last_login' => 'datetime',
    ];

    // ==========================================
    // RELATIONS (Hubungan antar Tabel)
    // ==========================================

    public function carts() 
    { 
        return $this->hasMany(Cart::class); 
    }

    public function orders() 
    { 
        return $this->hasMany(Order::class); 
    }

    public function reviews() 
    { 
        return $this->hasMany(Review::class); 
    }

    public function favorites() 
    { 
        return $this->hasMany(Favorite::class); 
    }

    public function bookings() 
    { 
        return $this->hasMany(Booking::class); 
    }

    public function questions() 
    { 
        return $this->hasMany(UserQuestion::class); 
    }

    public function jobApplications() 
    { 
        return $this->hasMany(JobApplication::class); 
    }

    // ==========================================
    // HELPER METHODS (Untuk kemudahan logika)
    // ==========================================

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Scope: Query khusus admin
     * Cara pakai: User::admin()->get();
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope: Query khusus customer/member
     * Cara pakai: User::customer()->get();
     */
    public function scopeCustomer($query)
    {
        return $query->where('role', 'member'); // Sesuaikan dengan enum di database ('member' atau 'customer')
    }
}