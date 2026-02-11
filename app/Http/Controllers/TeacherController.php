<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TeacherController extends Controller
{
    public function dashboard(): View
    {
        return view('teacher.dashboard');
    }
}
