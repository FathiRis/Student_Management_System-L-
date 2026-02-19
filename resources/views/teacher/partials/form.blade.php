<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Teacher Name</label>
        <input type="text" class="form-control" name="teacher_name" value="{{ old('teacher_name', $teacher?->teacher_name) }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Mobile No</label>
        <input type="text" class="form-control" name="mobile_no" value="{{ old('mobile_no', $teacher?->mobile_no) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="{{ old('email', $teacher?->email) }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Specialization</label>
        <input type="text" class="form-control" name="specialization" value="{{ old('specialization', $teacher?->specialization) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Profile Photo</label>
        <input type="file" class="form-control" name="profile_photo" accept="image/*">
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Bio</label>
        <textarea class="form-control" rows="3" name="bio">{{ old('bio', $teacher?->bio) }}</textarea>
    </div>
</div>
