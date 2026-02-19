@extends('app')
@push('page_title') Add Exam Admission @endpush
@push('page_head') Add Exam Admission @endpush
@push('side_head') Admin @endpush

@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.exam-admissions.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Student</label>
                        <select name="student_id" class="form-select" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->student_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Exam Category</label>
                        <select name="exam_category_id" class="form-select" id="categorySelect" required>
                            <option value="">Select Category</option>
                            <option>Term Exam</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Exam</label>
                        <select name="exam_id" class="form-select" id="examSelect" required>
                            <option value="">Select Exam</option>
                            <option>1st Term</option>
                            <option>2nd Term</option>
                            <option>3rd Term</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Exam Fee</label>
                        <input type="text" id="examFee" class="form-control" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" rows="3"></textarea>
                    </div>
                </div>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        const categorySelect = document.getElementById('categorySelect');
        const examSelect = document.getElementById('examSelect');
        const examFee = document.getElementById('examFee');

        categorySelect?.addEventListener('change', async function () {
            examSelect.innerHTML = '<option value="">Loading...</option>';
            examFee.value = '';
            if (!this.value) {
                examSelect.innerHTML = '<option value="">Select Exam</option>';
                return;
            }

            const response = await fetch(`{{ url('/admin/exam-categories') }}/${this.value}/exams`);
            const exams = await response.json();
            examSelect.innerHTML = '<option value="">Select Exam</option>';
            exams.forEach(exam => {
                const option = document.createElement('option');
                option.value = exam.id;
                option.textContent = exam.name;
                option.dataset.fee = exam.fee;
                examSelect.appendChild(option);
            });
        });

        examSelect?.addEventListener('change', function () {
            examFee.value = this.selectedOptions[0]?.dataset?.fee ?? '';
        });
    </script>
@endsection
