@extends('app')

@push('page_title')
Edit Student
@endpush
@push('page_head')
Edit Student
@endpush
@push('side_head')
{{ $isProfileEdit ? 'Student' : 'Admin' }}
@endpush

@section('content')
    @include('component.flash')

    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">Update Student Details</h4>
            <form method="POST" action="{{ $isProfileEdit ? route('student.profile.update') : route('admin.students.update', $student) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('student.partials.form', ['student' => $student, 'isProfileEdit' => $isProfileEdit])
                <button type="submit" class="btn btn-primary">Update Details</button>
            </form>
        </div>
    </div>
@endsection
