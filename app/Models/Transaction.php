<?php

namespace App\Models;

class Transaction extends Order
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'payment_method',
        'proof_of_payment_path',
        'order_status',
        'discount_amount',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'order_id');
    }
}
