<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $table = 'visitor_logs'; // Nama tabel plural
    public $timestamps = false; // Hanya custom created_at

    protected $fillable = ['ip_address', 'user_agent', 'created_at', 'user_id'];
}