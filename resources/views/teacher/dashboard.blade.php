@extends('app')

@push('page_title')
Teacher Dashboard
@endpush
@push('page_head')
Teacher Dashboard
@endpush
@push('side_head')
Teacher
@endpush

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Welcome Card -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px;">
            <h2 class="card-title mb-2">👋 Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="card-text mb-0">Here's an overview of your teaching assignments and profile status.</p>
        </div>
    </div>

    @if($teacher)
        <!-- Profile Details Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person-circle"></i> Your Registration Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Teacher Name</label>
                                <p class="fs-5 fw-bold">{{ $teacher->teacher_name ?: '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p class="fs-5">{{ $teacher->email ?: '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Mobile</label>
                                <p class="fs-5">{{ $teacher->mobile_no ?: '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Specialization</label>
                                <p class="fs-5">{{ $teacher->specialization ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards Row -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-people-fill" style="font-size: 2.5rem; color: #0d6efd;"></i>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">Assigned Classes</h6>
                        <h2 class="card-title mb-3" style="color: #0d6efd;">{{ $totalClasses ?? 0 }}</h2>
                        <a href="{{ route('teacher.classes.index') }}" class="btn btn-sm btn-outline-primary">View Classes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-person-badge-fill" style="font-size: 2.5rem; color: #198754;"></i>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">Total Students</h6>
                        <h2 class="card-title mb-3" style="color: #198754;">{{ $totalStudents ?? 0 }}</h2>
                        <a href="{{ route('teacher.classes.index') }}" class="btn btn-sm btn-outline-success">View Students</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-file-earmark-check-fill" style="font-size: 2.5rem; color: #ffc107;"></i>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">Exams in Charge</h6>
                        <h2 class="card-title mb-3" style="color: #ffc107;">{{ $totalExams ?? 0 }}</h2>
                        <a href="{{ route('teacher.exams.index') }}" class="btn btn-sm btn-outline-warning">View Exams</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Status Card -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-shield-check"></i> Account Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted">Current Status</label>
                            <p>
                                <span class="badge {{ $teacher->status === 'active' ? 'bg-success' : 'bg-danger' }} fs-6">
                                    {{ ucfirst($teacher->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Joined Date</label>
                            <p class="fs-5">{{ $teacher->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="mb-0">
                            <label class="form-label text-muted">Last Updated</label>
                            <p class="fs-5">{{ $teacher->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Completion Card -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clipboard-check"></i> Profile Completion
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Teacher Name</span>
                                <span class="badge {{ $teacher->teacher_name ? 'bg-success' : 'bg-warning' }}">
                                    {{ $teacher->teacher_name ? '✓ Complete' : '⚠ Pending' }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Email</span>
                                <span class="badge {{ $teacher->email ? 'bg-success' : 'bg-warning' }}">
                                    {{ $teacher->email ? '✓ Complete' : '⚠ Pending' }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Specialization</span>
                                <span class="badge {{ $teacher->specialization ? 'bg-success' : 'bg-warning' }}">
                                    {{ $teacher->specialization ? '✓ Complete' : '⚠ Pending' }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Mobile Number</span>
                                <span class="badge {{ $teacher->mobile_no ? 'bg-success' : 'bg-warning' }}">
                                    {{ $teacher->mobile_no ? '✓ Complete' : '⚠ Pending' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Card -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-info-circle"></i> Bio
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {{ $teacher->bio ?: 'No bio added yet. Click edit to add one.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-image"></i> Profile Photo
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        @if($teacher->profile_photo)
                            <img src="{{ Storage::url($teacher->profile_photo) }}" alt="Profile Photo" class="img-fluid rounded" style="max-height: 200px;">
                            <p class="mt-3 mb-0"><span class="badge bg-success">Photo Added</span></p>
                        @else
                            <div class="text-muted mb-3">
                                <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                            </div>
                            <p class="text-muted">No profile photo added yet</p>
                            <span class="badge bg-secondary">Not Added</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-lightning-fill"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('teacher.profile.edit') }}" class="btn btn-primary">
                                <i class="bi bi-pencil-square"></i> Edit Profile
                            </a>
                            @if($totalClasses > 0)
                                <a href="{{ route('teacher.classes.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-people"></i> View Classes
                                </a>
                            @endif
                            @if($totalStudents > 0)
                                <a href="{{ route('teacher.classes.index') }}" class="btn btn-outline-success">
                                    <i class="bi bi-person-badge"></i> View Students
                                </a>
                            @endif
                            @if($totalExams > 0)
                                <a href="{{ route('teacher.exams.index') }}" class="btn btn-outline-warning">
                                    <i class="bi bi-clipboard-check"></i> View Exams & Results
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle"></i> Your details will appear here once a registration record is created.
        </div>
    @endif
</div>
@endsection
