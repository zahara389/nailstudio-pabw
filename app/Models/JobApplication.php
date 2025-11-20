<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $table = 'job_applications'; // Nama tabel plural

    protected $fillable = ['fullname', 'email', 'phone', 'position', 'description', 'cv_filename', 'user_id'];

    public function kendala() { return $this->hasMany(KendalaLowongan::class, 'application_id'); }
}