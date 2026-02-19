<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->decimal('marks', 5, 2);
            $table->string('grade');
            $table->boolean('is_pass')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'exam_id']);
            $table->index(['exam_id', 'is_pass']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
