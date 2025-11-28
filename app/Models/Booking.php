<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'total_price',
        'payment_method',
        'payment_status',
        'status',
        'notes'
    ];
}
