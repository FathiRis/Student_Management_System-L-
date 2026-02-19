@extends('app')
@push('page_title') Exam Admissions @endpush
@push('page_head') Exam Admissions @endpush
@push('side_head') Admin @endpush

@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <div class="mb-3 text-end">
                <a href="{{ route('admin.exam-admissions.create') }}" class="btn btn-primary">Add Admission</a>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Admission No</th>
                    <th>Student</th>
                    <th>Exam</th>
                    <th>Fee</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($admissions as $admission)
                    <tr>
                        <td>{{ $admission->admission_no }}</td>
                        <td>{{ $admission->student?->student_name }}</td>
                        <td>{{ $admission->exam?->name }}</td>
                        <td>{{ number_format((float) $admission->fee_at_submission, 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.exam-admissions.payment-status', $admission) }}" class="d-flex gap-2">
                                @csrf
                                @method('PATCH')
                                <select class="form-select form-select-sm" name="payment_status">
                                    @foreach(['pending', 'paid', 'waived'] as $status)
                                        <option value="{{ $status }}" @selected($admission->payment_status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-outline-primary">Save</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.exam-admissions.destroy', $admission) }}" onsubmit="return confirm('Delete this admission?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No admissions found.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $admissions->links() }}
        </div>
    </div>
@endsection
