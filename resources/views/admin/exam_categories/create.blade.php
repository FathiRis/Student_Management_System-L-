@extends('app')
@push('page_title') Add Exam Category @endpush
@push('page_head') Add Exam Category @endpush
@push('side_head') Admin @endpush
@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.exam-categories.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                </div>
                <button class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
