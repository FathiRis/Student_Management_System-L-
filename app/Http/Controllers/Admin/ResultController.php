<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Student;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResultController extends Controller
{
    public function index(Request $request): View
    {
        $examId = $request->integer('exam_id');
        $studentId = $request->integer('student_id');

        $resultQuery = Result::with(['student:id,student_name', 'exam:id,name'])
            ->when($examId, fn ($q) => $q->where('exam_id', $examId))
            ->when($studentId, fn ($q) => $q->where('student_id', $studentId));

        $results = (clone $resultQuery)->latest()->paginate(15);

        $exams = Exam::orderBy('name')->get(['id', 'name']);
        $students = Student::orderBy('student_name')->get(['id', 'student_name']);

        $stats = [
            'total' => (clone $resultQuery)->count(),
            'pass_percentage' => round((clone $resultQuery)->where('is_pass', true)->count() / max(1, (clone $resultQuery)->count()) * 100, 2),
        ];

        return view('admin.results.index', compact('results', 'exams', 'students', 'stats', 'examId', 'studentId'));
    }

    public function create(): View
    {
        $students = Student::orderBy('student_name')->get();
        $exams = Exam::orderBy('name')->get();

        return view('admin.results.create', compact('students', 'exams'));
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validateResult($request);
        [$grade, $isPass] = $this->gradeAndPass((float) $payload['marks']);

        $result = Result::updateOrCreate(
            [
                'student_id' => $payload['student_id'],
                'exam_id' => $payload['exam_id'],
            ],
            [
                'marks' => $payload['marks'],
                'grade' => $grade,
                'is_pass' => $isPass,
                'published_at' => now(),
            ]
        );

        ActivityLogger::log('result.saved', $result, ['marks' => $payload['marks']]);

        return redirect()->route('admin.results.index')->with('success', 'Result saved successfully.');
    }

    public function edit(Result $result): View
    {
        $students = Student::orderBy('student_name')->get();
        $exams = Exam::orderBy('name')->get();

        return view('admin.results.edit', compact('result', 'students', 'exams'));
    }

    public function update(Request $request, Result $result): RedirectResponse
    {
        $payload = $this->validateResult($request);
        [$grade, $isPass] = $this->gradeAndPass((float) $payload['marks']);

        $result->update([
            'student_id' => $payload['student_id'],
            'exam_id' => $payload['exam_id'],
            'marks' => $payload['marks'],
            'grade' => $grade,
            'is_pass' => $isPass,
            'published_at' => now(),
        ]);

        ActivityLogger::log('result.updated', $result, ['marks' => $payload['marks']]);

        return redirect()->route('admin.results.index')->with('success', 'Result updated.');
    }

    public function destroy(Result $result): RedirectResponse
    {
        $result->forceDelete();
        ActivityLogger::log('result.deleted', $result);

        return redirect()->route('admin.results.index')->with('success', 'Result deleted.');
    }

    private function validateResult(Request $request): array
    {
        return $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'exam_id' => ['required', 'exists:exams,id'],
            'marks' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);
    }

    private function gradeAndPass(float $marks): array
    {
        if ($marks >= 85) {
            return ['A', true];
        }
        if ($marks >= 70) {
            return ['B', true];
        }
        if ($marks >= 55) {
            return ['C', true];
        }
        if ($marks >= 40) {
            return ['D', true];
        }

        return ['F', false];
    }
}
