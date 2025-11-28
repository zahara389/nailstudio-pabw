<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    // Tabel yang digunakan oleh Model ini
    protected $table = 'newsletter_subscribers';
    
    // Field yang boleh diisi (mass assignable)
    protected $fillable = [
        'email',
        'user_id',
    ];
    
    // Opsional: Hubungan ke User
    // public function user()
    // {
    //     return $this->belongsTo(\App\Models\User::class);
    // }
}