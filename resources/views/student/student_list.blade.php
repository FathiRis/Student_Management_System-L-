@extends('app')

@push('page_title')
Students
@endpush
@push('page_head')
Student List
@endpush
@push('side_head')
Admin
@endpush

@section('content')
    @include('component.flash')

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <input type="text" id="searchInput" class="form-control table-search-input" placeholder="Search students...">
                <div class="d-flex gap-2">
                    <!-- <a href="{{ route('admin.students.export.csv') }}" class="btn btn-outline-success">Export CSV</a> -->
                    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">Add Student</a>
                </div>
            </div>

            <table class="table table-bordered table-hover align-middle" id="studentsTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Grade</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th width="280">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $students->firstItem() + $loop->index }}</td>
                        <td>
                            @if($student->photo_path)
                                <img src="/{{ $student->photo_path }}" alt="photo" width="40" height="40" class="rounded-circle" />
                            @else
                                <span class="text-muted">No photo</span>
                            @endif
                        </td>
                        <td>{{ $student->student_name }}</td>
                        <td>{{ $student->grade }}</td>
                        <td>{{ $student->mobile_no }}</td>
                        <td>
                            <span class="badge {{ $student->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                        <td class="d-flex flex-wrap gap-1">
                            <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="{{ route('admin.students.id-card', $student) }}" class="btn btn-sm btn-outline-dark">ID Card</a>

                            <form method="POST" action="{{ route('admin.students.toggle-status', $student) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-primary">Toggle Status</button>
                            </form>

                            <form method="POST" action="{{ route('admin.students.destroy', $student) }}" class="delete-student-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No students found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $students->links() }}
        </div>
    </div>

    <div class="delete-warning-overlay" id="deleteWarningOverlay" role="dialog" aria-modal="true" aria-labelledby="deleteWarningTitle">
        <div class="delete-warning-box">
            <div class="delete-warning-header">
                <span class="title" id="deleteWarningTitle">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Delete student?
                </span>
                <button type="button" class="close-btn" id="closeDeleteWarning" aria-label="Close">&times;</button>
            </div>
            <div class="delete-warning-body">
                Are you sure you want to delete this student? This action cannot be undone.
            </div>
            <div class="delete-warning-actions">
                <button type="button" class="btn btn-cancel" id="cancelDeleteWarning">Cancel</button>
                <button type="button" class="btn btn-delete" id="confirmDeleteWarning">Delete</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#studentsTable tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        const deleteOverlay = document.getElementById('deleteWarningOverlay');
        const closeDeleteWarning = document.getElementById('closeDeleteWarning');
        const cancelDeleteWarning = document.getElementById('cancelDeleteWarning');
        const confirmDeleteWarning = document.getElementById('confirmDeleteWarning');
        const deleteForms = document.querySelectorAll('.delete-student-form');
        let pendingDeleteForm = null;

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                pendingDeleteForm = form;
                deleteOverlay.classList.add('show');
            });
        });

        function closeDeleteModal() {
            deleteOverlay.classList.remove('show');
            pendingDeleteForm = null;
        }

        closeDeleteWarning.addEventListener('click', closeDeleteModal);
        cancelDeleteWarning.addEventListener('click', closeDeleteModal);

        deleteOverlay.addEventListener('click', function (event) {
            if (event.target === deleteOverlay) {
                closeDeleteModal();
            }
        });

        confirmDeleteWarning.addEventListener('click', function () {
            if (pendingDeleteForm) {
                pendingDeleteForm.submit();
            }
        });
    </script>
@endsection
