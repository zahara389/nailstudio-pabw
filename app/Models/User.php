<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    
    use HasApiTokens, HasFactory, Notifiable; 

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

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login' => 'datetime',
    ];
    
   
    public function findForLogin($username)
    {
        return $this->where('username', $username)->first();
    }


    public function carts(): HasMany { return $this->hasMany(Cart::class); }
    public function orders(): HasMany { return $this->hasMany(Order::class); }
    public function reviews(): HasMany { return $this->hasMany(Review::class); }
    public function favorites(): HasMany { return $this->hasMany(Favorite::class); }
    public function bookings(): HasMany { return $this->hasMany(Booking::class); }
    public function questions(): HasMany { return $this->hasMany(UserQuestion::class); }
    public function jobApplications(): HasMany { return $this->hasMany(JobApplication::class); }
    public function addresses(): HasMany { return $this->hasMany(Address::class); }


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