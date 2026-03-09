@extends('app')

@push('page_title')
Student ID Card
@endpush
@push('page_head')
Student ID Card
@endpush
@push('side_head')
Admin
@endpush

@section('content')
    <div class="card student-id-card">
        <div class="card-body">
            <h5 class="mb-3">Student ID Card</h5>
            @if($student->photo_path)
                <img src="/{{ $student->photo_path }}" alt="photo" width="90" class="rounded mb-3" />
            @endif
            <p class="mb-1"><strong>Name:</strong> {{ $student->student_name }}</p>
            <p class="mb-1"><strong>Index No:</strong> {{ $student->index_no ?: '-' }}</p>
            <p class="mb-1"><strong>grade:</strong> {{ $student->grade }}</p>
            <p class="mb-1"><strong>Mobile:</strong> {{ $student->mobile_no }}</p>
            <p class="mb-0"><strong>Status:</strong> {{ ucfirst($student->status) }}</p>
        </div>
    </div>
@endsection
