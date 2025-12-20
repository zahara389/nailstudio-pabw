<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            // RELASI KATEGORI 
            $table->foreignId('job_category_id')
                  ->constrained('job_categories')
                  ->onDelete('cascade');

            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('location')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('salary_range')->nullable();

            $table->enum('status', ['draft', 'open', 'closed'])->default('draft');

            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
