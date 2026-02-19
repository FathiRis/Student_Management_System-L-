@extends('app')

@push('page_title')
Exam Results
@endpush
@push('page_head')
{{ $exam->name }} - Results
@endpush
@push('side_head')
Teacher
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('teacher.exams.index') }}" class="btn btn-sm btn-outline-secondary mb-3">← Back to Exams</a>
        
        <div class="row mb-4">
            <div class="col-md-8">
                <h4>{{ $exam->name }}</h4>
                <p class="text-muted">
                    Category: <strong>{{ $exam->category->name }}</strong> | 
                    Date: <strong>{{ $exam->exam_date ? $exam->exam_date->format('M d, Y') : '-' }}</strong>
                </p>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <div class="card" style="flex: 1;">
                        <div class="card-body text-center">
                            <h6 class="card-subtitle mb-2 text-muted">Total Results</h6>
                            <h3>{{ $stats['total_results'] }}</h3>
                        </div>
                    </div>
                    <div class="card" style="flex: 1;">
                        <div class="card-body text-center">
                            <h6 class="card-subtitle mb-2 text-muted">Passed</h6>
                            <h3 class="text-success">{{ $stats['passed'] }}</h3>
                        </div>
                    </div>
                    <div class="card" style="flex: 1;">
                        <div class="card-body text-center">
                            <h6 class="card-subtitle mb-2 text-muted">Avg Marks</h6>
                            <h3>{{ $stats['avg_marks'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($exam->results->isEmpty())
            <p class="text-muted">No results submitted yet for this exam.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Marks</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exam->results as $result)
                            <tr>
                                <td>
                                    <strong>{{ $result->student->student_name }}</strong>
                                </td>
                                <td>{{ $result->student->email ?: '-' }}</td>
                                <td>{{ $result->marks }}</td>
                                <td>{{ $result->grade }}</td>
                                <td>
                                    <span class="badge {{ $result->is_pass ? 'bg-success' : 'bg-danger' }}">
                                        {{ $result->is_pass ? 'Pass' : 'Fail' }}
                                    </span>
                                </td>
                                <td>{{ $result->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
