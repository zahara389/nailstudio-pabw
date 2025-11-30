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

    // Tidak ada $casts yang diperlukan karena semua data sudah dalam format string atau date/time sederhana.
    protected $casts = [];

    /**
     * Relasi dengan User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}