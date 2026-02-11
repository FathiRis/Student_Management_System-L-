<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboardRedirect'])->name('dashboard');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])
        ->middleware('role:teacher')
        ->name('teacher.dashboard');

    Route::view('/student/dashboard', 'student.dashboard')
        ->middleware('role:student')
        ->name('student.dashboard');

    Route::get('/student-register', [AdminController::class, 'studentRegister'])
        ->middleware('role:admin')
        ->name('student.register');

    Route::post('/student-register', [StudentController::class, 'store'])
        ->middleware('role:admin')
        ->name('student.store');

    Route::get('/students', [StudentController::class, 'index'])
        ->middleware('role:admin')
        ->name('students.index');
});
