<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Category</label>
        <select class="form-select" name="exam_category_id" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('exam_category_id', $exam?->exam_category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Exam Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $exam?->name) }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Exam Date</label>
        <input type="date" name="exam_date" class="form-control" value="{{ old('exam_date', optional($exam?->exam_date)->format('Y-m-d')) }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Exam Fee</label>
        <input type="number" name="fee" step="0.01" min="0" class="form-control" value="{{ old('fee', $exam?->fee ?? 0) }}" required>
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Eligibility Rules</label>
        <textarea name="eligibility_rules" class="form-control" rows="3">{{ old('eligibility_rules', $exam?->eligibility_rules) }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Assign Teachers</label>
        <select name="teacher_ids[]" class="form-select" multiple>
            @php($selectedTeachers = old('teacher_ids', isset($exam) ? $exam->teachers->pluck('id')->toArray() : []))
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" @selected(in_array($teacher->id, $selectedTeachers))>{{ $teacher->teacher_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Active</label>
        <select name="is_active" class="form-select">
            <option value="1" @selected((string) old('is_active', $exam?->is_active ?? 1) === '1')>Yes</option>
            <option value="0" @selected((string) old('is_active', $exam?->is_active ?? 1) === '0')>No</option>
        </select>
    </div>
</div>
