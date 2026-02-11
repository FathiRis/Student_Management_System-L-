@extends('app')

@push('page_title')
    Student Register
@endpush
@push('side_head')
    Admin
@endpush

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card p-4">
                    <h3 class="text-center mb-4">Student Registration Form</h3>

                    <form method="POST" action="">
                        @csrf

                        <div class="form-group mb-3">
                            <label>Student Name</label>
                            <input type="text" class="form-control" name="student_name">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Mobile No.</label>
                                <input type="text" class="form-control" name="mobile_no" placeholder="+94 077 987 6543">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email Id</label>
                                <input type="email" class="form-control" name="email" placeholder="abc@gmail.com">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Select Grade</label>
                                <select class="form-control" name="course">
                                    <option selected> Grade 06</option>
                                    <option> Grade 07</option>
                                    <option> Grade 08</option>
                                    <option> Grade 09</option>
                                    <option> Grade 10</option>
                                    <option> O/L </option>
                                    <option> A/L </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Index</label>
                                <input type="text" class="form-control" name="index" placeholder="0000">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Date Of Birth</label>
                                <input type="date" class="form-control" name="dob">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Gender</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="male" name="gender" value="Male">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="female" name="gender" value="Female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Father Name</label>
                                <input type="text" class="form-control" name="father_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Mobile No</label>
                                <input type="text" class="form-control" name="father_no" placeholder="+94 077 987 6543 ">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Mother Name</label>
                                <input type="text" class="form-control" name="mother_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Mobile No</label>
                                <input type="text" class="form-control" name="mother_no" placeholder="+94 077 987 6543">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="123, Main St">
                        </div>

                        <div class="form-group mb-3">
                            <label for="inputAddress2">Address 2</label>
                            <input type="text" class="form-control" id="inputAddress2"
                                placeholder="Apartment, studio, or floor">
                        </div>

                        <div class="mb-3">
                            <label>Any Messages</label>
                            <textarea class="form-control" rows="3" name="message" placeholder="Type here"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Submit
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection