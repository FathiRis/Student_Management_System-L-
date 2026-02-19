@extends('app')
@push('page_title') Results @endpush
@push('page_head') Results @endpush
@push('side_head') Admin @endpush

@section('content')
    @include('component.flash')

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.results.index') }}" class="row g-2">
                <div class="col-md-4">
                    <select name="student_id" class="form-select">
                        <option value="">All Students</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" @selected($studentId === $student->id)>{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="exam_id" class="form-select">
                        <option value="">All Exams</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" @selected($examId === $exam->id)>{{ $exam->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-outline-primary">Filter</button>
                    <a href="{{ route('admin.results.create') }}" class="btn btn-primary">Add Result</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between">
            <div><strong>Total Results:</strong> {{ $stats['total'] }}</div>
            <div><strong>Pass Percentage:</strong> {{ $stats['pass_percentage'] }}%</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Student</th><th>Exam</th><th>Marks</th><th>Grade</th><th>Result</th><th>Action</th></tr></thead>
                <tbody>
                @forelse($results as $result)
                    <tr>
                        <td>{{ $result->student?->student_name }}</td>
                        <td>{{ $result->exam?->name }}</td>
                        <td>{{ $result->marks }}</td>
                        <td>{{ $result->grade }}</td>
                        <td>
                            <span class="badge {{ $result->is_pass ? 'bg-success' : 'bg-danger' }}">{{ $result->is_pass ? 'Pass' : 'Fail' }}</span>
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.results.edit', $result) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.results.destroy', $result) }}" onsubmit="return confirm('Delete this result?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No results found.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $results->links() }}
        </div>
    </div>
@endsection
