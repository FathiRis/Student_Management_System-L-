@extends('app')
@push('page_title') Add Teacher @endpush
@push('page_head') Add Teacher @endpush
@push('side_head') Admin @endpush
@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin.teachers.partials.form', ['teacher' => null])
                <button class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
