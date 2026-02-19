@extends('app')

@push('page_title')
Student Dashboard
@endpush
@push('page_head')
Student Dashboard
@endpush
@push('side_head')
Student
@endpush

@section('content')
<div class="student-dashboard">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="dashboard-hero">
        <h2>Registration & Requirements</h2>
        <p>Welcome {{ auth()->user()->name }}. Complete all required details to finalize your registration.</p>
    </div>

    <div class="dashboard-grid">
        

        
        <section class="dashboard-card wide">
            <h4>Your Registration Details</h4>
            @if($student)
                <div class="summary-grid">
                    <div class="summary-box">
                        <label>Student Name</label>
                        <p>{{ $student->student_name ?: '-' }}</p>
                    </div>
                    <div class="summary-box">
                        <label>Email</label>
                        <p>{{ $student->email ?: '-' }}</p>
                    </div>
                    <div class="summary-box">
                        <label>Mobile</label>
                        <p>{{ $student->mobile_no ?: '-' }}</p>
                    </div>
                    <div class="summary-box">
                        <label>Grade</label>
                        <p>{{ $student->grade ?: '-' }}</p>
                    </div>
                </div>
            @else
                <p class="small-text mb-0">Your details will appear here once a registration record is created.</p>
            @endif
        </section>

        <section class="dashboard-card wide">
            <h4>Action</h4>
            @if($student)
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('student.profile.edit') }}" class="btn btn-primary">Edit / Update My Details</a>
                    <a href="{{ route('student.exam-admission.create') }}" class="btn btn-outline-primary">Apply for Exam</a>
                </div>
            @else
                <button class="btn btn-secondary" disabled>Edit / Update My Details</button>
            @endif
        </section>
    </div>
</div>
@endsection
