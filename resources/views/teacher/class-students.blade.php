@extends('app')

@push('page_title')
Class Students
@endpush
@push('page_head')
{{ $class->name }} - Students
@endpush
@push('side_head')
Teacher
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('teacher.classes.index') }}" class="btn btn-sm btn-outline-secondary mb-3">← Back to Classes</a>
        
        <h4 class="mb-3">{{ $class->name }} - Students Performance</h4>
        
        @if($class->students->isEmpty())
            <p class="text-muted">No students in this class yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Grade</th>
                            <th>Exams Taken</th>
                            <th>Passed</th>
                            <th>Pass Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($class->students as $student)
                            @php
                                $results = $student->results ?? collect();
                                $totalExams = $results->count();
                                $passedExams = $results->where('is_pass', true)->count();
                                $passRate = $totalExams > 0 ? round(($passedExams / $totalExams) * 100, 2) : 0;
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $student->student_name }}</strong>
                                </td>
                                <td>{{ $student->email ?: '-' }}</td>
                                <td>{{ $student->grade }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $totalExams }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $passedExams }}</span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar{{ $passRate >= 75 ? ' bg-success' : ($passRate >= 50 ? ' bg-warning' : ' bg-danger') }}" 
                                             role="progressbar" 
                                             style="width: {{ $passRate }}%"
                                             aria-valuenow="{{ $passRate }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            {{ $passRate }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
