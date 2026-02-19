<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ExamAdmissionSubmittedMail;
use App\Models\Exam;
use App\Models\ExamAdmission;
use App\Models\ExamCategory;
use App\Models\Student;
use App\Support\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ExamAdmissionController extends Controller
{
    public function index(): View
    {
        $admissions = ExamAdmission::with(['student:id,student_name', 'exam:id,name,exam_date'])
            ->latest()
            ->paginate(10);

        return view('admin.exam_admissions.index', compact('admissions'));
    }

    public function create(): View
    {
        $students = Student::where('status', 'active')->orderBy('student_name')->get();
        $categories = ExamCategory::orderBy('name')->get();

        return view('admin.exam_admissions.create', compact('students', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'exam_category_id' => ['required', 'exists:exam_categories,id'],
            'exam_id' => ['required', 'exists:exams,id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $exam = Exam::findOrFail($payload['exam_id']);
        $admission = ExamAdmission::create([
            'student_id' => $payload['student_id'],
            'exam_id' => $payload['exam_id'],
            'admission_no' => $this->generateAdmissionNumber(),
            'fee_at_submission' => $exam->fee,
            'payment_status' => 'pending',
            'remarks' => $payload['remarks'] ?? null,
            'admitted_by' => auth()->id(),
        ]);

        ActivityLogger::log('exam_admission.created', $admission);
        $this->sendAdmissionEmail($admission);

        return redirect()
            ->route('admin.exam-admissions.index')
            ->with('success', "Admission submitted. Admission No: {$admission->admission_no}");
    }

    public function updatePaymentStatus(Request $request, ExamAdmission $examAdmission): RedirectResponse
    {
        $payload = $request->validate([
            'payment_status' => ['required', 'in:pending,paid,waived'],
        ]);

        $examAdmission->update($payload);
        ActivityLogger::log('exam_admission.payment_status.updated', $examAdmission, $payload);

        return redirect()->route('admin.exam-admissions.index')->with('success', 'Payment status updated.');
    }

    public function destroy(ExamAdmission $examAdmission): RedirectResponse
    {
        $examAdmission->forceDelete();
        ActivityLogger::log('exam_admission.deleted', $examAdmission);

        return redirect()->route('admin.exam-admissions.index')->with('success', 'Admission deleted.');
    }

    public function examsByCategory(ExamCategory $examCategory): JsonResponse
    {
        $exams = $examCategory->exams()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'fee']);

        return response()->json($exams);
    }

    private function generateAdmissionNumber(): string
    {
        return 'ADM-'.now()->format('Ymd').'-'.str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
    }

    private function sendAdmissionEmail(ExamAdmission $admission): void
    {
        $admission->loadMissing(['student:id,email,student_name', 'exam:id,name']);

        if (! $admission->student?->email) {
            return;
        }

        try {
            Mail::to($admission->student->email)->send(new ExamAdmissionSubmittedMail($admission));
        } catch (\Throwable $exception) {
            Log::warning('Exam admission email failed', [
                'admission_id' => $admission->id,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
