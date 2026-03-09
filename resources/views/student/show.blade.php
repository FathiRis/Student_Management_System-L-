@extends('app')

@push('page_title')
Student Details
@endpush
@push('page_head')
Student Details
@endpush
@push('side_head')
Admin
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h4>{{ $student->student_name }}</h4>
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Back</a>
            </div>

            <div class="row">
                <div class="col-md-3">
                    @if($student->photo_path)
                        <img src="/{{ $student->photo_path }}" class="img-fluid rounded" alt="photo" />
                    @endif
                </div>
                <div class="col-md-9">
                    <p><strong>Email:</strong> {{ $student->email ?: '-' }}</p>
                    <p><strong>Mobile:</strong> {{ $student->mobile_no }}</p>
                    <p><strong>Grade:</strong> {{ $student->grade }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($student->status) }}</p>
                    <p><strong>Address:</strong> {{ $student->address ?: '-' }}</p>
                </div>
            </div>

            <hr>
            <h5>Exam Admissions</h5>
            <ul>
                @forelse($student->examAdmissions as $admission)
                    <li>{{ $admission->exam?->name }} ({{ $admission->admission_no }}) - {{ ucfirst($admission->payment_status) }}</li>
                @empty
                    <li>No admissions found.</li>
                @endforelse
            </ul>

            <h5>Results</h5>
            <ul>
                @forelse($student->results as $result)
                    <li>{{ $result->exam?->name }} - {{ $result->marks }} ({{ $result->grade }})</li>
                @empty
                    <li>No results found.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
