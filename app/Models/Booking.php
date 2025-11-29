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
        
        // Data Kontak
        'customer_name',    
        'customer_email',
        'customer_phone', 
        
        // Detail Booking
        'location',
        'service',
        'booking_date', 
        'booking_time',
        
        'notes',
        'status', 
    ];

    /**
     * Relasi dengan User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}