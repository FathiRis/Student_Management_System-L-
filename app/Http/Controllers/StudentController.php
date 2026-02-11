<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = Student::latest()->get();

        return view('student.student_list', compact('students'));
    }

    public function store(Request $request): RedirectResponse
    {
        Student::create([
            'student_name' => $request->student_name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'course' => $request->course,
            'index_no' => $request->index,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'father_name' => $request->father_name,
            'father_no' => $request->father_no,
            'mother_name' => $request->mother_name,
            'mother_no' => $request->mother_no,
            'address' => $request->inputAddress,
            'address2' => $request->inputAddress2,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Student registered successfully.');
    }
}
