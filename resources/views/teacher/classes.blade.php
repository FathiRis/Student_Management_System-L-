@extends('app')

@push('page_title')
My Classes
@endpush
@push('page_head')
My Classes
@endpush
@push('side_head')
Teacher
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="mb-3">Assigned Classes</h4>
        
        @if($assignedClasses->isEmpty())
            <p class="text-muted">No classes assigned yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>section</th>
                            <th>Students</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignedClasses as $class)
                            <tr>
                                <td>
                                    <strong>{{ $class->name }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $class->section }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $class->students->count() }} students</span>
                                </td>
                                <td>
                                    <a href="{{ route('teacher.classes.students', $class->id) }}" class="btn btn-sm btn-primary">
                                        View Students
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($assignedClasses->hasPages())
                {{ $assignedClasses->links() }}
            @endif
        @endif
    </div>
</div>
@endsection
