<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $students = Student::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('student_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile_no', 'like', "%{$search}%")
                        ->orWhere('index_no', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10, ['*'], 'page', 1);

        return view('student.student_list', compact('students', 'search'));
    }

    public function create(): View
    {
        return view('student.student_register');
    }

    public function show(Student $student): View
    {
        $student->load(['examAdmissions.exam', 'results.exam']);

        return view('student.show', compact('student'));
    }

    public function dashboard(): View
    {
        $student = Student::where('email', auth()->user()->email)->latest()->first();

        $requiredFields = [
            'student_name',
            'mobile_no',
            'email',
            'grade',
            'dob',
            'gender',
            'father_name',
            'father_no',
            'mother_name',
            'mother_no',
            'address',
        ];
        
        $completedFields = 0;
        if ($student) {
            foreach ($requiredFields as $field) {
                if (! empty($student->{$field})) {
                    $completedFields++;
                }
            }
        }

        $completionPercentage = (int) round(($completedFields / count($requiredFields)) * 100);

        return view('student.dashboard', compact('student', 'requiredFields', 'completedFields', 'completionPercentage'));
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validatedStudentData($request);
        $password = $payload['password'];
        unset($payload['password'], $payload['password_confirmation']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/students'), $filename);
            $payload['photo_path'] = 'assets/img/students/' . $filename;
        }

        $student = DB::transaction(function () use ($payload, $password) {
            $user = User::create([
                'name' => $payload['student_name'],
                'email' => $payload['email'],
                'password' => $password,
                'role' => User::ROLE_STUDENT,
            ]);

            $payload['user_id'] = $user->id;

            return Student::create($payload);
        });

        ActivityLogger::log('student.created', $student);

        return redirect()->route('admin.students.index')->with('success', 'Student registered successfully.');
    }

    public function edit(Student $student): View
    {
        return view('student.edit', [
            'student' => $student,
            'isProfileEdit' => false,
        ]);
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $payload = $this->validatedStudentData($request, $student->id);
        $password = $payload['password'] ?? null;
        unset($payload['password'], $payload['password_confirmation']);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($student->photo_path && file_exists(public_path($student->photo_path))) {
                unlink(public_path($student->photo_path));
            }
            // Save new photo
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/students'), $filename);
            $payload['photo_path'] = 'assets/img/students/' . $filename;
        }

        DB::transaction(function () use ($student, $payload, $password) {
            $userPayload = [
                'name' => $payload['student_name'],
                'email' => $payload['email'],
                'role' => User::ROLE_STUDENT,
            ];

            if ($password) {
                $userPayload['password'] = $password;
            }

            if ($student->user) {
                $student->user->update($userPayload);
            } else {
                $user = User::create($userPayload + ['password' => $password]);
                $payload['user_id'] = $user->id;
            }

            $student->update($payload);
        });

        ActivityLogger::log('student.updated', $student);

        return redirect()->route('admin.students.index')->with('success', 'Student details updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        // Delete photo if exists
        if ($student->photo_path && file_exists(public_path($student->photo_path))) {
            unlink(public_path($student->photo_path));
        }

        $userId = $student->user_id;
        $student->forceDelete();
        
        if ($userId) {
            User::find($userId)?->forceDelete();
        }
        
        ActivityLogger::log('student.deleted', $student);

        return redirect()->route('admin.students.index')->with('success', 'Student and account deleted successfully.');
    }

    public function toggleStatus(Student $student): RedirectResponse
    {
        $student->update([
            'status' => $student->status === 'active' ? 'inactive' : 'active',
        ]);
        ActivityLogger::log('student.status.updated', $student, ['status' => $student->status]);

        return redirect()->route('admin.students.index')->with('success', 'Student status updated.');
    }

    public function editProfile(): RedirectResponse|View
    {
        $student = Student::where('email', auth()->user()->email)->latest()->first();

        if (! $student) {
            return redirect()
                ->route('student.dashboard')
                ->with('error', 'No registration record found for your account email.');
        }

        return view('student.edit', [
            'student' => $student,
            'isProfileEdit' => true,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $student = Student::where('email', auth()->user()->email)->latest()->first();

        if (! $student) {
            return redirect()
                ->route('student.dashboard')
                ->with('error', 'No registration record found for your account email.');
        }

        $payload = $this->validatedStudentData($request, $student->id, true);

        DB::transaction(function () use ($student, $payload) {
            $student->update($payload);

            if ($student->user) {
                $student->user->update([
                    'name' => $payload['student_name'],
                    'email' => $payload['email'],
                ]);
            }
        });

        ActivityLogger::log('student.profile.updated', $student);

        return redirect()->route('student.dashboard')->with('success', 'Your details have been updated successfully.');
    }

    public function exportCsv(): StreamedResponse
    {
        $fileName = 'students-'.now()->format('YmdHis').'.csv';

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Mobile', 'Grade', 'Status']);

            Student::query()->orderBy('student_name')->chunk(500, function ($students) use ($handle) {
                foreach ($students as $student) {
                    fputcsv($handle, [
                        $student->id,
                        $student->student_name,
                        $student->email,
                        $student->mobile_no,
                        $student->grade,
                        $student->status,
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function idCard(Student $student): View
    {
        return view('student.id_card', compact('student'));
    }

    private function validatedStudentData(Request $request, ?int $studentId = null, bool $profileEdit = false): array
    {
        $student = $studentId ? Student::find($studentId) : null;

        $rules = [
            'student_name' => ['required', 'string', 'max:255'],
            'mobile_no' => ['required', 'string', 'max:25'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($studentId)],
            'grade' => ['required', 'string', 'max:50'],
            'index_no' => ['nullable', 'string', 'max:50'],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'father_no' => ['nullable', 'string', 'max:25'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'mother_no' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string', 'max:255'],
            'address2' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];

        if (! $profileEdit) {
            $rules['status'] = ['nullable', 'in:active,inactive'];
            $rules['email'][] = Rule::unique('users', 'email')->ignore($student?->user_id);
            $rules['password'] = [
                Rule::requiredIf(! $studentId || ($student && ! $student->user_id)),
                'nullable',
                'string',
                Password::min(8),
                'confirmed',
            ];
        } else {
            $rules['email'][] = Rule::unique('users', 'email')->ignore($student?->user_id);
        }

        return $request->validate($rules);
    }
}
