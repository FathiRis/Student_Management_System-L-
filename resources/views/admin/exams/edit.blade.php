@extends('app')
@push('page_title') Edit Exam @endpush
@push('page_head') Edit Exam @endpush
@push('side_head') Admin @endpush
@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.exams.update', $exam) }}">
                @csrf
                @method('PUT')
                @include('admin.exams.partials.form', ['exam' => $exam])
                <button class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
