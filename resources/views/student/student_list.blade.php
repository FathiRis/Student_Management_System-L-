@extends('app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h3>Student List</h3>
        <a href="{{ route('student.register') }}" class="btn btn-primary">Add Student</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Grade</th>
                <th>Mobile</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->student_name }}</td>
                <td>{{ $student->course }}</td>
                <td>{{ $student->mobile_no }}</td>
                <td>{{ $student->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
