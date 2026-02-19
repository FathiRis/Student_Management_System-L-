<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAdmission;
use App\Models\Result;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalExams = Exam::count();
        $studentsRegisteredForExams = ExamAdmission::distinct('student_id')->count('student_id');

        $totalResults = Result::count();
        $passedResults = Result::where('is_pass', true)->count();
        $passRate = $totalResults > 0 ? round(($passedResults / $totalResults) * 100, 2) : 0;

        $recentStudentRegistrations = Student::latest()->limit(5)->get();
        $recentExamAdmissions = ExamAdmission::with(['student:id,student_name', 'exam:id,name'])
            ->latest()
            ->limit(5)
            ->get();

        $monthlyAdmissions = ExamAdmission::selectRaw('MONTH(created_at) as month_number, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->pluck('total', 'month_number');

        $chartLabels = [];
        $chartData = [];
        for ($month = 1; $month <= 12; $month++) {
            $chartLabels[] = now()->startOfYear()->addMonths($month - 1)->format('M');
            $chartData[] = $monthlyAdmissions[$month] ?? 0;
        }

        return view('dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalExams',
            'studentsRegisteredForExams',
            'passRate',
            'recentStudentRegistrations',
            'recentExamAdmissions',
            'chartLabels',
            'chartData'
        ));
    }
}
