@extends('app')
@push('page_title') Teachers @endpush
@push('page_head') Teachers @endpush
@push('side_head') Admin @endpush

@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" id="searchInput" class="form-control table-search-input" placeholder="Search by name or email...">
                <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">Add Teacher</a>
            </div>
            <table class="table table-bordered" id="teachersTable">
                <thead><tr><th>Name</th><th>Email</th><th>Classes</th><th>Exams</th><th>Action</th></tr></thead>
                <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->teacher_name }}</td>
                        <td>{{ $teacher->email ?: '-' }}</td>
                        <td>
                            @foreach($teacher->classAssignments as $classRoom)
                                <span class="badge bg-secondary">{{ $classRoom->name }} {{ $classRoom->section }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach($teacher->exams as $exam)
                                <span class="badge bg-info">{{ $exam->name }}</span>
                            @endforeach 
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-sm btn-info">Profile</a>
                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" class="delete-teacher-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No teachers found.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $teachers->links() }}
        </div>
    </div>

    <div class="delete-warning-overlay" id="deleteWarningOverlay" role="dialog" aria-modal="true" aria-labelledby="deleteWarningTitle">
        <div class="delete-warning-box">
            <div class="delete-warning-header">
                <span class="title" id="deleteWarningTitle">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Delete teacher?
                </span>
                <button type="button" class="close-btn" id="closeDeleteWarning" aria-label="Close">&times;</button>
            </div>
            <div class="delete-warning-body">
                Are you sure you want to delete this teacher? This action cannot be undone.
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
            const tableRows = document.querySelectorAll('#teachersTable tbody tr');
            
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
        const deleteForms = document.querySelectorAll('.delete-teacher-form');
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
