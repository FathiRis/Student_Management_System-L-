<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard');
    }

    public function studentRegister(): View
    {
        return view('student.student_register');
    }
}
