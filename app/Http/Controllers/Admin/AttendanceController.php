<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        $attendances = Attendance::with(['student:id,student_name,grade', 'classRoom:id,name,section'])
            ->latest('attendance_date')
            ->paginate(15);

        $students = Student::orderBy('student_name')->get(['id', 'student_name', 'index_no', 'grade']);
        $classRooms = ClassRoom::orderBy('name')->get(['id', 'name', 'section']);

        return view('admin.attendance.index', compact('attendances', 'students', 'classRooms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'class_room_id' => ['nullable', 'exists:class_rooms,id'],
            'attendance_date' => ['required', 'date'],
            'status' => ['required', 'in:present,absent,late'],
        ]);
        $payload['marked_by'] = auth()->id();

        $attendance = Attendance::updateOrCreate([
            'student_id' => $payload['student_id'],
            'class_room_id' => $payload['class_room_id'] ?? null,
            'attendance_date' => $payload['attendance_date'],
        ], $payload);

        ActivityLogger::log('attendance.saved', $attendance);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance saved.');
    }
}
