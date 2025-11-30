<?php

namespace App\Models;

class TransactionDetail extends OrderItem
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'discount_amount',
        'subtotal_item',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'order_id');
    }
}