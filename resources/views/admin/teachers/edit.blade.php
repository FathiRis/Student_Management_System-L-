@extends('app')
@push('page_title') Edit Teacher @endpush
@push('page_head') Edit Teacher @endpush
@push('side_head') Admin @endpush
@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.teachers.partials.form', ['teacher' => $teacher])
                <button class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
