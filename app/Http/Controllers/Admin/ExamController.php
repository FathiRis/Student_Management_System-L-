<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\Teacher;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function index(): View
    {
        $exams = Exam::with('category')->latest()->paginate(10);

        return view('admin.exams.index', compact('exams'));
    }

    public function create(): View
    {
        $categories = ExamCategory::orderBy('name')->get();
        $teachers = Teacher::orderBy('teacher_name')->get();

        return view('admin.exams.create', compact('categories', 'teachers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validateExam($request);
        $teacherIds = $payload['teacher_ids'] ?? [];
        unset($payload['teacher_ids']);

        $exam = Exam::create($payload);
        $exam->teachers()->sync($teacherIds);
        ActivityLogger::log('exam.created', $exam, ['teacher_ids' => $teacherIds]);

        return redirect()->route('admin.exams.index')->with('success', 'Exam created successfully.');
    }

    public function edit(Exam $exam): View
    {
        $categories = ExamCategory::orderBy('name')->get();
        $teachers = Teacher::orderBy('teacher_name')->get();
        $exam->load('teachers');

        return view('admin.exams.edit', compact('exam', 'categories', 'teachers'));
    }

    public function update(Request $request, Exam $exam): RedirectResponse
    {
        $payload = $this->validateExam($request);
        $teacherIds = $payload['teacher_ids'] ?? [];
        unset($payload['teacher_ids']);

        $exam->update($payload);
        $exam->teachers()->sync($teacherIds);
        ActivityLogger::log('exam.updated', $exam, ['teacher_ids' => $teacherIds]);

        return redirect()->route('admin.exams.index')->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam): RedirectResponse
    {
        $exam->forceDelete();
        ActivityLogger::log('exam.deleted', $exam);

        return redirect()->route('admin.exams.index')->with('success', 'Exam deleted.');
    }

    private function validateExam(Request $request): array
    {
        return $request->validate([
            'exam_category_id' => ['required', 'exists:exam_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'exam_date' => ['nullable', 'date'],
            'fee' => ['required', 'numeric', 'min:0'],
            'eligibility_rules' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'teacher_ids' => ['nullable', 'array'],
            'teacher_ids.*' => ['exists:teachers,id'],
        ]);
    }
}
