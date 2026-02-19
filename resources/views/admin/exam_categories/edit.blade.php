@extends('app')
@push('page_title') Edit Exam Category @endpush
@push('page_head') Edit Exam Category @endpush
@push('side_head') Admin @endpush
@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.exam-categories.update', $examCategory) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $examCategory->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description', $examCategory->description) }}</textarea>
                </div>
                <button class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
