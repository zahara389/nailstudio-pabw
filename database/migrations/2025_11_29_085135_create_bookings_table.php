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
        if (!Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('customer_phone');
                $table->string('location');
                $table->string('service');
                $table->date('booking_date');
                $table->time('booking_time');
                $table->text('notes')->nullable();
                $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
                $table->timestamps();
            });
        }
    }

    /**
     * Balikkan migrasi (Menghapus tabel bookings).
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};