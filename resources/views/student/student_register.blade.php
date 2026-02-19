@extends('app')

@push('page_title')
Student Register
@endpush
@push('page_head')
Student Register
@endpush
@push('side_head')
Admin
@endpush

@section('content')
    @include('component.flash')

    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">Student Registration Form</h4>
            <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data">
                @csrf
                @include('student.partials.form', ['student' => null, 'isProfileEdit' => false])
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
