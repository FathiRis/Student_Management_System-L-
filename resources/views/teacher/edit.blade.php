@extends('app')

@push('page_title')
Edit Teacher
@endpush
@push('page_head')
Edit Teacher
@endpush
@push('side_head')
{{ $isProfileEdit ? 'Teacher' : 'Admin' }}
@endpush

@section('content')
    @include('component.flash')

    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">Update Teacher Details</h4>
            <form method="POST" action="{{ $isProfileEdit ? route('teacher.profile.update') : route('admin.teachers.update', $teacher) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('teacher.partials.form', ['teacher' => $teacher, 'isProfileEdit' => $isProfileEdit])
                <button type="submit" class="btn btn-primary">Update Details</button>
            </form>
        </div>
    </div>
@endsection
