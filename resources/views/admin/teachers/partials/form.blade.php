<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Teacher Name</label>
        <input type="text" name="teacher_name" class="form-control" value="{{ old('teacher_name', $teacher?->teacher_name) }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $teacher?->email) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Mobile</label>
        <input type="text" name="mobile_no" class="form-control" value="{{ old('mobile_no', $teacher?->mobile_no) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Specialization</label>
        <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $teacher?->specialization) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" @selected(old('status', $teacher?->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $teacher?->status) === 'inactive')>Inactive</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Password {{ $teacher ? '(Leave blank to keep current)' : '' }}</label>
        <input type="password" name="password" class="form-control" {{ $teacher ? '' : 'required' }}>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ $teacher ? '' : 'required' }}>
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Class Assignments</label>
        @php($selectedClasses = old('class_room_ids', isset($teacher) ? $teacher->classAssignments->pluck('id')->toArray() : []))
        <select name="class_room_ids[]" class="form-select" multiple>
            @foreach($classRooms as $classRoom)
                <option value="{{ $classRoom->id }}" @selected(in_array($classRoom->id, $selectedClasses))>
                    {{ $classRoom->name }} {{ $classRoom->section }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Bio</label>
        <textarea name="bio" class="form-control" rows="3">{{ old('bio', $teacher?->bio) }}</textarea>
    </div>
</div>
