<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiBayar extends Model
{
    use HasFactory;

    protected $table = 'bukti_bayar'; // Nama tabel Indo
    public $timestamps = false; // Tidak ada created_at/updated_at standar (adanya uploaded_at)

    protected $fillable = ['cart_id', 'file_path', 'uploaded_at'];

    public function cart() { return $this->belongsTo(Cart::class, 'cart_id'); }
}