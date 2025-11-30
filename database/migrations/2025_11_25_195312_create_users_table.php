<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            // Superseded by earlier users migration.
                $table->enum('role', ['admin','member'])->default('member');
                $table->string('phone', 20)->nullable();
                $table->text('address')->nullable();
                $table->string('city', 100)->nullable();
                $table->string('postal_code', 10)->nullable();
                $table->string('photo')->nullable();
                $table->enum('status', ['active','inactive'])->default('active');
            // No-op
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
