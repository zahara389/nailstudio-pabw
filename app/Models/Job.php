<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    // Asumsi: Tabel bernama 'jobs'
    protected $fillable = ['title', 'type', 'location', 'description', 'requirements', 'is_active']; 

    // Kolom 'requirements' disimpan sebagai JSON di database
    protected $casts = [
        'requirements' => 'array', 
    ];
}