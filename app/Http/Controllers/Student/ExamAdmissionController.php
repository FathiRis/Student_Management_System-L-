<?php

namespace App\Http\Controllers\Student;

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
    public function create(): RedirectResponse|View
    {
        $student = Student::where('email', auth()->user()->email)->latest()->first();
        if (! $student) {
            return redirect()->route('student.dashboard')->with('error', 'No student profile found for your account.');
        }

        $categories = ExamCategory::orderBy('name')->get();

        return view('student.exam_admission.create', compact('student', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $student = Student::where('email', auth()->user()->email)->latest()->firstOrFail();

        $payload = $request->validate([
            'exam_category_id' => ['required', 'exists:exam_categories,id'],
            'exam_id' => ['required', 'exists:exams,id'],
        ]);

        $exam = Exam::findOrFail($payload['exam_id']);
        $admission = ExamAdmission::create([
            'student_id' => $student->id,
            'exam_id' => $exam->id,
            'admission_no' => 'ADM-'.now()->format('Ymd').'-'.str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT),
            'fee_at_submission' => $exam->fee,
            'payment_status' => 'pending',
            'admitted_by' => auth()->id(),
        ]);

        ActivityLogger::log('student.exam_admission.created', $admission);
        $this->sendAdmissionEmail($admission);

        return redirect()->route('student.dashboard')->with('success', "Admission submitted successfully. No: {$admission->admission_no}");
    }

    public function examsByCategory(ExamCategory $examCategory): JsonResponse
    {
        return response()->json(
            $examCategory->exams()->where('is_active', true)->get(['id', 'name', 'fee'])
        );
    }

    private function sendAdmissionEmail(ExamAdmission $admission): void
    {
        $admission->loadMissing(['student:id,email', 'exam:id,name']);

        if (! $admission->student?->email) {
            return;
        }

        try {
            Mail::to($admission->student->email)->send(new ExamAdmissionSubmittedMail($admission));
        } catch (\Throwable $exception) {
            Log::warning('Student admission email failed', ['message' => $exception->getMessage()]);
        }
    }
}
