@extends('app')
@push('page_title') Classes @endpush
@push('page_head') Classes @endpush
@push('side_head') Admin @endpush
@section('content')
    @include('component.flash')
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Add Class</h5>
                    <form method="POST" action="{{ route('admin.class-rooms.store') }}">
                        @csrf
                        <div class="mb-2">
                            <input type="text" class="form-control" name="name" placeholder="Class Name" required>
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control" name="section" placeholder="Section">
                        </div>
                        <button class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead><tr><th>Name</th><th>Section</th></tr></thead>
                        <tbody>
                        @forelse($classRooms as $classRoom)
                            <tr><td>{{ $classRoom->name }}</td><td>{{ $classRoom->section }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-center">No classes found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $classRooms->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
