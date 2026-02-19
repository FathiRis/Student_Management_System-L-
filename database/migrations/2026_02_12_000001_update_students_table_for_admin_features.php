<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('status')->default('active')->after('message');
            $table->string('photo_path')->nullable()->after('status');
            $table->softDeletes();

            $table->index('status');
            $table->index('student_name');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropSoftDeletes();
            $table->dropIndex(['status']);
            $table->dropIndex(['student_name']);
            $table->dropIndex(['email']);
            $table->dropColumn(['status', 'photo_path']);
        });
    }
};
