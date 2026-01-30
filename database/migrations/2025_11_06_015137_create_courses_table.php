<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('path_trailer')->nullable();
            $table->text('about')->nullable();
            $table->string('thumbnail')->nullable();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['teacher_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
