<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name','email','username','password','role','phone','address',
        'city','postal_code','photo','status','last_login'
    ];

    public function carts() { return $this->hasMany(Cart::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function favorites() { return $this->hasMany(Favorite::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
    public function questions() { return $this->hasMany(UserQuestion::class); }
    public function jobApplications() { return $this->hasMany(JobApplication::class); }
}
