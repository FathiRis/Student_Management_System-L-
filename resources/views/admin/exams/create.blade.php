@extends('app')
@push('page_title') Add Exam @endpush
@push('page_head') Add Exam @endpush
@push('side_head') Admin @endpush
@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.exams.store') }}">
                @csrf
                @include('admin.exams.partials.form', ['exam' => null])
                <button class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
