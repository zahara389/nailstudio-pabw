<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendalalowongan_db', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon');
            $table->enum('kategori', ['kurangnya info', 'pelayanan', 'lainnya', ''])->default('lainnya');
            $table->text('pesan');
            $table->timestamp('tanggal_kirim')->useCurrent();
            $table->foreignId('application_id')->nullable()->constrained('job_applications')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendalalowongan_db');
    }
};