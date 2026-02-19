<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->string('admission_no')->unique();
            $table->decimal('fee_at_submission', 10, 2)->default(0);
            $table->string('payment_status')->default('pending');
            $table->text('remarks')->nullable();
            $table->foreignId('admitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['student_id', 'exam_id']);
            $table->index(['exam_id', 'payment_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_admissions');
    }
};
