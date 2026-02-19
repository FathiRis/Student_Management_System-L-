@extends('app')
@push('page_title') Attendance @endpush
@push('page_head') Attendance @endpush
@push('side_head') Admin @endpush
@section('content')
    @include('component.flash')
    <div class="card mb-3">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.attendance.store') }}" class="row g-2">
                @csrf
                <div class="col-md-3">
                    <select name="student_id" class="form-select" required>
                        <option value="">Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="class_room_id" class="form-select" required>
                        <option value="">Class</option>
                        <option value="1"> Grade 06 </option>
                        <option value="2">Grade 07 </option>
                        <option value="3"> Grade 08 </option>
                        <option value="4"> Grade 09 </option>
                        <option value="4"> O/L </option>
                        <option value="4"> A/L </option>

                        @foreach($classRooms as $classRoom)
                            <option value="{{ $classRoom->id }}">{{ $classRoom->name }} {{ $classRoom->section }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="attendance_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select" required>
                        @foreach(['present', 'absent', 'late'] as $status)
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Date</th><th>Student</th><th>Class</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->attendance_date->format('d M Y') }}</td>
                        <td>{{ $attendance->student?->student_name }}</td>
                        <td>{{ $attendance->classRoom?->name }} {{ $attendance->classRoom?->section }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($attendance->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No attendance data found.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $attendances->links() }}
        </div>
    </div>
@endsection
