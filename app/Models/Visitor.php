<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',    // Pastikan kutip tertutup dan ada koma
        'ip_address', 
        'visit_date'
    ];

    // Opsional: Tambahkan relasi ke User jika ingin tahu siapa yang login
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}