<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendalaLowongan extends Model
{
    use HasFactory;

    protected $table = 'kendalalowongan_db'; // Nama tabel Indo
    public $timestamps = false; // Hanya custom tanggal_kirim

    protected $fillable = ['nama', 'email', 'telepon', 'kategori', 'pesan', 'tanggal_kirim', 'application_id'];

    public function application() { return $this->belongsTo(JobApplication::class, 'application_id'); }
}