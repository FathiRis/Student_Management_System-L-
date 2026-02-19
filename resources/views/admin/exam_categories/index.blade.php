@extends('app')
@push('page_title') Exam Categories @endpush
@push('page_head') Exam Categories @endpush
@push('side_head') Admin @endpush

@section('content')
    @include('component.flash')
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Add Category</h5>
                    <form method="POST" action="{{ route('admin.exam-categories.store') }}">
                        @csrf
                        <div class="mb-2">
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="mb-2">
                            <textarea class="form-control" name="description" rows="3" placeholder="Description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead><tr><th>Category</th><th>Description</th><th>Action</th></tr></thead>
                        <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('admin.exam-categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('admin.exam-categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">No categories found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
