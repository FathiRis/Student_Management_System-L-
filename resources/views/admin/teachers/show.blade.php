@extends('app')
@push('page_title') Teacher Profile @endpush
@push('page_head') Teacher Profile @endpush
@push('side_head') Admin @endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <h4>{{ $teacher->teacher_name }}</h4>
            <p><strong>Email:</strong> {{ $teacher->email ?: '-' }}</p>
            <p><strong>Mobile:</strong> {{ $teacher->mobile_no ?: '-' }}</p>
            <p><strong>Specialization:</strong> {{ $teacher->specialization ?: '-' }}</p>
            <p><strong>Bio:</strong> {{ $teacher->bio ?: '-' }}</p>
            <div class="mb-2">
                <strong>Assigned Classes:</strong>
                @forelse($teacher->classAssignments as $classRoom)
                    <span class="badge bg-secondary">{{ $classRoom->name }} {{ $classRoom->section }}</span>
                @empty
                    <span class="text-muted">None</span>
                @endforelse
            </div>
            <div>
                <strong>Assigned Exams:</strong>
                @forelse($teacher->exams as $exam)
                    <span class="badge bg-info">{{ $exam->name }}</span>
                @empty
                    <span class="text-muted">None</span>
                @endforelse
            </div>
        </div>
    </div>
@endsection
