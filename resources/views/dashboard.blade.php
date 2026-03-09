@extends('app')

@push('page_title')
Admin Dashboard
@endpush
@push('page_head')
Admin Dashboard
@endpush
@push('side_head')
Admin
@endpush

@section('content')
    @include('component.flash')

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Students</p>
                    <h3 class="mb-0">{{ $totalStudents }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Teachers</p>
                    <h3 class="mb-0">{{ $totalTeachers }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Exams</p>
                    <h3 class="mb-0">{{ $totalExams }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Students In Admissions</p>
                    <h3 class="mb-0">{{ $studentsRegisteredForExams }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Admissions Trend ({{ now()->year }})</h5>
                    <span class="badge bg-success">Pass Rate: {{ $passRate }}%</span>
                </div>
                <div class="card-body">
                    <canvas id="admissionChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Performance Summary</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1">Current pass percentage</p>
                    <h2 class="text-primary">{{ $passRate }}%</h2>
                    <small class="text-muted">Based on all published results</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Recent Student Registrations</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentStudentRegistrations as $student)
                            <tr>
                                <td>{{ $student->student_name }}</td>
                                <td>{{ $student->grade }}</td>
                                <td>{{ $student->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-3">No data</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Recent Exam Admissions</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>Admission No</th>
                            <th>Student</th>
                            <th>Exam</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentExamAdmissions as $admission)
                            <tr>
                                <td>{{ $admission->admission_no }}</td>
                                <td>{{ $admission->student?->student_name ?? '-' }}</td>
                                <td>{{ $admission->exam?->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-3">No data</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('admissionChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Admissions',
                        data: @json($chartData),
                        borderWidth: 1
                    }]
                },
                options: {responsive: true}
            });
        }
    </script>
@endsection
