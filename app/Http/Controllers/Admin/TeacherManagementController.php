<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Teacher;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class TeacherManagementController extends Controller
{
    public function index(): View
    {
        $teachers = Teacher::with(['exams:id,name', 'classAssignments:id,name,section'])->latest()->paginate(10);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create(): View
    {
        $classRooms = ClassRoom::orderBy('name')->get();

        return view('admin.teachers.create', compact('classRooms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validateTeacher($request);
        $password = $payload['password'];
        $classRoomIds = $payload['class_room_ids'] ?? [];
        unset($payload['class_room_ids'], $payload['password'], $payload['password_confirmation']);

        if ($request->hasFile('profile_photo')) {
            $payload['profile_photo'] = $request->file('profile_photo')->store('teachers/photos', 'public');
        }

        $teacher = DB::transaction(function () use ($payload, $password, $classRoomIds) {
            $user = User::create([
                'name' => $payload['teacher_name'],
                'email' => $payload['email'],
                'password' => $password,
                'role' => User::ROLE_TEACHER,
            ]);

            $payload['user_id'] = $user->id;
            $teacher = Teacher::create($payload);
            $teacher->classAssignments()->sync($classRoomIds);

            return $teacher;
        });

        ActivityLogger::log('teacher.created', $teacher);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function show(Teacher $teacher): View
    {
        $teacher->load(['exams', 'classAssignments']);

        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher): View
    {
        $classRooms = ClassRoom::orderBy('name')->get();
        $teacher->load('classAssignments');

        return view('admin.teachers.edit', compact('teacher', 'classRooms'));
    }

    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $payload = $this->validateTeacher($request, $teacher->id);
        $password = $payload['password'] ?? null;
        $classRoomIds = $payload['class_room_ids'] ?? [];
        unset($payload['class_room_ids'], $payload['password'], $payload['password_confirmation']);

        if ($request->hasFile('profile_photo')) {
            if ($teacher->profile_photo) {
                Storage::disk('public')->delete($teacher->profile_photo);
            }
            $payload['profile_photo'] = $request->file('profile_photo')->store('teachers/photos', 'public');
        }

        DB::transaction(function () use ($teacher, $payload, $password, $classRoomIds) {
            $userPayload = [
                'name' => $payload['teacher_name'],
                'email' => $payload['email'],
                'role' => User::ROLE_TEACHER,
            ];

            if ($password) {
                $userPayload['password'] = $password;
            }

            if ($teacher->user) {
                $teacher->user->update($userPayload);
            } else {
                $user = User::create($userPayload + ['password' => $password]);
                $payload['user_id'] = $user->id;
            }

            $teacher->update($payload);
            $teacher->classAssignments()->sync($classRoomIds);
        });

        ActivityLogger::log('teacher.updated', $teacher);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        $userId = $teacher->user_id;
        $teacher->forceDelete();
        
        if ($userId) {
            User::find($userId)?->forceDelete();
        }
        
        ActivityLogger::log('teacher.deleted', $teacher);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher and account deleted successfully.');
    }

    private function validateTeacher(Request $request, ?int $teacherId = null): array
    {
        $teacher = $teacherId ? Teacher::find($teacherId) : null;

        return $request->validate([
            'teacher_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('teachers', 'email')->ignore($teacherId),
                Rule::unique('users', 'email')->ignore($teacher?->user_id),
            ],
            'mobile_no' => ['nullable', 'string', 'max:50'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'status' => ['nullable', 'in:active,inactive'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'class_room_ids' => ['nullable', 'array'],
            'class_room_ids.*' => ['exists:class_rooms,id'],
            'password' => [
                Rule::requiredIf(! $teacherId || ($teacher && ! $teacher->user_id)),
                'nullable',
                'string',
                Password::min(8),
                'confirmed',
            ],
        ]);
    }
}
