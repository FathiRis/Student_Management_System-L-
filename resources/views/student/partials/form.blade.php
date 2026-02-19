<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Student Name</label>
        <input type="text" class="form-control" name="student_name" value="{{ old('student_name', $student?->student_name) }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Mobile No</label>
        <input type="text" class="form-control" name="mobile_no" value="{{ old('mobile_no', $student?->mobile_no) }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="{{ old('email', $student?->email) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Grade</label>
        <select class="form-select" name="grade" required>
            <option value="">Select</option>
            @foreach(['Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'O/L', 'A/L'] as $grade)
                <option value="{{ $grade }}" @selected(old('grade', $student?->grade) === $grade)>{{ $grade }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Index No</label>
        <input type="text" class="form-control" name="index_no" value="{{ old('index_no', $student?->index_no) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">DOB</label>
        <input type="date" class="form-control" name="dob" value="{{ old('dob', optional($student?->dob)->format('Y-m-d')) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Gender</label>
        <select class="form-select" name="gender">
            <option value="">Select</option>
            @foreach(['Male', 'Female', 'Other'] as $gender)
                <option value="{{ $gender }}" @selected(old('gender', $student?->gender) === $gender)>{{ $gender }}</option>
            @endforeach
        </select>
    </div>
    @if(! $isProfileEdit)
        <div class="col-md-6 mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
                <option value="active" @selected(old('status', $student?->status ?? 'active') === 'active')>Active</option>
                <option value="inactive" @selected(old('status', $student?->status) === 'inactive')>Inactive</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Password {{ $student ? '(Leave blank to keep current)' : '' }}</label>
            <input type="password" class="form-control" name="password" {{ $student ? '' : 'required' }}>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" {{ $student ? '' : 'required' }}>
        </div>
    @endif
    <div class="col-md-6 mb-3">
        <label class="form-label">Father Name</label>
        <input type="text" class="form-control" name="father_name" value="{{ old('father_name', $student?->father_name) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Father No</label>
        <input type="text" class="form-control" name="father_no" value="{{ old('father_no', $student?->father_no) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Mother Name</label>
        <input type="text" class="form-control" name="mother_name" value="{{ old('mother_name', $student?->mother_name) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Mother No</label>
        <input type="text" class="form-control" name="mother_no" value="{{ old('mother_no', $student?->mother_no) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Address 1</label>
        <input type="text" class="form-control" name="address" value="{{ old('address', $student?->address) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Address 2</label>
        <input type="text" class="form-control" name="address2" value="{{ old('address2', $student?->address2) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Student Photo</label>
        <input type="file" class="form-control" name="photo">
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Message</label>
        <textarea class="form-control" rows="3" name="message">{{ old('message', $student?->message) }}</textarea>
    </div>
</div>
