<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function dashboard(): View
    {
        $teacher = Teacher::where('email', auth()->user()->email)->latest()->first();

        if ($teacher) {
            $teacher->load(['exams.category', 'classAssignments.students']);
            
            $assignedClasses = $teacher->classAssignments;
            $assignedExams = $teacher->exams()->orderBy('exam_date')->get();
            
            // Get students from assigned classes
            $students = collect();
            foreach ($assignedClasses as $class) {
                $students = $students->merge($class->students);
            }
            
            // Get performance data
            $performanceData = [];
            if ($students->isNotEmpty()) {
                $studentIds = $students->pluck('id');
                $performanceData = DB::table('results')
                    ->whereIn('student_id', $studentIds)
                    ->select('student_id', DB::raw('COUNT(*) as total_exams'), DB::raw('SUM(CASE WHEN is_pass = 1 THEN 1 ELSE 0 END) as passed_exams'))
                    ->groupBy('student_id')
                    ->get()
                    ->keyBy('student_id');
            }
            
            $totalClasses = $assignedClasses->count();
            $totalStudents = $students->count();
            $totalExams = $assignedExams->count();
            
            return view('teacher.dashboard', compact('teacher', 'assignedClasses', 'assignedExams', 'performanceData', 'totalClasses', 'totalStudents', 'totalExams', 'students'));
        }

        return view('teacher.dashboard', compact('teacher'));
    }

    public function classes(): View
    {
        $teacher = Teacher::where('email', auth()->user()->email)->latest()->firstOrFail();
        $assignedClasses = $teacher->classAssignments()->with('students')->paginate(10);

        return view('teacher.classes', compact('assignedClasses'));
    }

    public function classStudents($classId): View
    {
        $teacher = Teacher::where('email', auth()->user()->email)->latest()->firstOrFail();
        $class = $teacher->classAssignments()->findOrFail($classId);
        $class->load(['students' => function ($query) {
            $query->with(['results' => function ($q) {
                $q->orderBy('created_at', 'desc');
            }]);
        }]);

        return view('teacher.class-students', compact('class'));
    }

    public function exams(): View
    {
        $teacher = Teacher::where('email', auth()->user()->email)->latest()->firstOrFail();
        $assignedExams = $teacher->exams()
            ->with(['category', 'results' => function ($query) {
                $query->select('exam_id', DB::raw('COUNT(*) as total'), DB::raw('SUM(CASE WHEN is_pass = 1 THEN 1 ELSE 0 END) as passed'));
            }])
            ->orderBy('exam_date')
            ->paginate(10);

        return view('teacher.exams', compact('assignedExams'));
    }

    public function examResults($examId): View
    {
        $teacher = Teacher::where('email', auth()->user()->email)->latest()->firstOrFail();
        $exam = $teacher->exams()->findOrFail($examId);
        $exam->load(['results' => function ($query) {
            $query->with('student')->latest();
        }, 'category']);

        $stats = [
            'total_results' => $exam->results()->count(),
            'passed' => $exam->results()->where('is_pass', true)->count(),
            'failed' => $exam->results()->where('is_pass', false)->count(),
            'avg_marks' => round($exam->results()->avg('marks'), 2),
        ];

        return view('teacher.exam-results', compact('exam', 'stats'));
    }

    public function editProfile(): View
    {
        $teacher = Teacher::where('email', auth()->user()->email)->latest()->firstOrFail();

        return view('teacher.edit', [
            'teacher' => $teacher,
            'isProfileEdit' => true,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $teacher = Teacher::where('email', auth()->user()->email)->latest()->firstOrFail();

        $payload = $request->validate([
            'teacher_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'mobile_no' => ['nullable', 'string', 'max:25'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($teacher->profile_photo) {
                Storage::disk('public')->delete($teacher->profile_photo);
            }
            $payload['profile_photo'] = $request->file('profile_photo')->store('teachers/photos', 'public');
        }

        DB::transaction(function () use ($teacher, $payload) {
            $teacher->update($payload);

            if ($teacher->user) {
                $teacher->user->update([
                    'name' => $payload['teacher_name'],
                    'email' => $payload['email'],
                ]);
            }
        });

        ActivityLogger::log('teacher.profile.updated', $teacher);

        return redirect()->route('teacher.dashboard')->with('success', 'Your profile has been updated successfully.');
    }
}
