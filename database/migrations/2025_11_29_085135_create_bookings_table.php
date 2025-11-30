<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi (Membuat tabel bookings).
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Kunci Asing (Diubah menjadi nullable untuk tamu/guest)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); 
            
            // Kolom Kontak Pelanggan
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 15); // Batasi panjang di DB
            
            // Detail Booking
            $table->string('location');
            $table->string('service');
            
            // Kolom Tanggal dan Waktu
            $table->date('booking_date');
            $table->time('booking_time');
            
            $table->text('notes')->nullable();
            
            // Status Booking
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            
            $table->timestamps();

            // INDEKS UNIK: Pastikan kombinasi tanggal, waktu, dan status aktif tidak bentrok
            $table->unique(['booking_date', 'booking_time', 'status']);
        });
    }

    /**
     * Balikkan migrasi (Menghapus tabel bookings).
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};