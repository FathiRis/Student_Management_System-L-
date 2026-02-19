<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Student</label>
        <select name="student_id" class="form-select" required>
            <option value="">Select Student</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}" @selected(old('student_id', $result?->student_id) == $student->id)>{{ $student->student_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Exam</label>
        <select name="exam_id" class="form-select" required>
            <option value="">Select Exam</option>
            <option>1st Term</option>
            <option>2nd Term</option>
            <option>3rd Term</option>
            @foreach($exams as $exam)
                <option value="{{ $exam->id }}" @selected(old('exam_id', $result?->exam_id) == $exam->id)>{{ $exam->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Marks</label>
        <input type="number" name="marks" step="0.01" min="0" max="100" class="form-control" value="{{ old('marks', $result?->marks) }}" required>
    </div>
</div>
