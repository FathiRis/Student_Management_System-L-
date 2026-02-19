<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\ExamAdmissionController as AdminExamAdmissionController;
use App\Http\Controllers\Admin\ExamCategoryController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\TeacherManagementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student\ExamAdmissionController as StudentExamAdmissionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboardRedirect'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/students-export-csv', [StudentController::class, 'exportCsv'])->name('students.export.csv');
        Route::get('/students/{student}/id-card', [StudentController::class, 'idCard'])->name('students.id-card');
        Route::patch('/students/{student}/toggle-status', [StudentController::class, 'toggleStatus'])->name('students.toggle-status');
        Route::resource('students', StudentController::class)->except(['show'])->names('students');
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::resource('teachers', TeacherManagementController::class)->names('teachers');
        Route::resource('exam-categories', ExamCategoryController::class)->except(['show'])->names('exam-categories');
        Route::resource('exams', ExamController::class)->except(['show'])->names('exams');

        Route::resource('exam-admissions', AdminExamAdmissionController::class)->except(['show', 'edit', 'update'])->names('exam-admissions');
        Route::patch('/exam-admissions/{examAdmission}/payment-status', [AdminExamAdmissionController::class, 'updatePaymentStatus'])->name('exam-admissions.payment-status');
        Route::get('/exam-categories/{examCategory}/exams', [AdminExamAdmissionController::class, 'examsByCategory'])->name('exam-categories.exams');

        Route::resource('results', ResultController::class)->except(['show'])->names('results');
        Route::get('/class-rooms', [ClassRoomController::class, 'index'])->name('class-rooms.index');
        Route::post('/class-rooms', [ClassRoomController::class, 'store'])->name('class-rooms.store');
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    });

    Route::prefix('teacher')->name('teacher.')->middleware('role:teacher')->group(function () {
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile/edit', [TeacherController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [TeacherController::class, 'updateProfile'])->name('profile.update');
        Route::get('/classes', [TeacherController::class, 'classes'])->name('classes.index');
        Route::get('/classes/{classId}/students', [TeacherController::class, 'classStudents'])->name('classes.students');
        Route::get('/exams', [TeacherController::class, 'exams'])->name('exams.index');
        Route::get('/exams/{examId}/results', [TeacherController::class, 'examResults'])->name('exams.results');
    });

    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile/edit', [StudentController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');

        Route::get('/exam-admission', [StudentExamAdmissionController::class, 'create'])->name('exam-admission.create');
        Route::post('/exam-admission', [StudentExamAdmissionController::class, 'store'])->name('exam-admission.store');
        Route::get('/exam-categories/{examCategory}/exams', [StudentExamAdmissionController::class, 'examsByCategory'])->name('exam-categories.exams');
    });
});
