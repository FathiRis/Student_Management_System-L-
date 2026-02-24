<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('students', 'course') && ! Schema::hasColumn('students', 'grade')) {
            DB::statement('ALTER TABLE `students` CHANGE `course` `grade` VARCHAR(255) NOT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('students', 'grade') && ! Schema::hasColumn('students', 'course')) {
            DB::statement('ALTER TABLE `students` CHANGE `grade` `course` VARCHAR(255) NOT NULL');
        }
    }
};
