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
<<<<<<<< HEAD:database/migrations/2025_11_25_182405_create_core_tables.php
        Schema::create('core_tables', function (Blueprint $table) {
            $table->id();
========
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
>>>>>>>> tazkya:database/migrations/2025_11_20_224136_create_faqs_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2025_11_25_182405_create_core_tables.php
        Schema::dropIfExists('core_tables');
========
        Schema::dropIfExists('faqs');
>>>>>>>> tazkya:database/migrations/2025_11_20_224136_create_faqs_table.php
    }
};
