@extends('app')

@push('page_title')
My Exams
@endpush
@push('page_head')
My Exams
@endpush
@push('side_head')
Teacher
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="mb-3">Exams in Charge</h4>
        
        @if($assignedExams->isEmpty())
            <p class="text-muted">No exams assigned yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Exam Name</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Results Submitted</th>
                            <th>Pass Rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignedExams as $exam)
                            @php
                                $totalResults = $exam->results()->count();
                                $passedResults = $exam->results()->where('is_pass', true)->count();
                                $passRate = $totalResults > 0 ? round(($passedResults / $totalResults) * 100, 2) : 0;
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $exam->name }}</strong>
                                </td>
                                <td>{{ $exam->category->name ?? '-' }}</td>
                                <td>{{ $exam->exam_date ? $exam->exam_date->format('M d, Y') : '-' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $totalResults }} results</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $passRate >= 75 ? 'success' : ($passRate >= 50 ? 'warning' : 'danger') }}">
                                        {{ $passRate }}%
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('teacher.exams.results', $exam->id) }}" class="btn btn-sm btn-primary">
                                        View Results
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($assignedExams->hasPages())
                {{ $assignedExams->links() }}
            @endif
        @endif
    </div>
</div>
@endsection
