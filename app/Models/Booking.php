<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'location',
        'service',
        'booking_date',
        'booking_time',
        'notes',
        'status', 
    ];

    protected $casts = [];

  
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}