<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabel FAQ (Digunakan untuk pesan masuk dan tampilan FAQ)
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            // user_id dibuat nullable jika pengirim pesan adalah tamu (guest)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->text('question'); // Menggunakan text karena pesan bisa panjang
            $table->text('answer')->nullable(); // Nullable karena awalnya belum dijawab
            $table->string('status')->default('pending'); // 'pending' atau 'answered'
            $table->timestamps();
        });


    public function down()
    {
        // Urutan drop harus benar jika ada foreign key
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('faqs');
    }
};