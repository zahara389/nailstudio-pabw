<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address'); // Tambahkan ini untuk mencatat IP
            $table->date('visit_date');   // Tambahkan ini untuk mencatat tanggal
            $table->timestamps();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // Tambahkan index unik agar 1 IP hanya terhitung 1x per hari
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};