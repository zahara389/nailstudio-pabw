<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('job_category_id')->constrained('job_categories')->onDelete('restrict');
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('location', 150);
            $table->enum('employment_type', ['full_time','part_time','internship']);
            $table->string('salary_range', 100)->nullable();
            $table->enum('status', ['open','closed','draft'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
