@extends('app')

@push('page_title')
    Exam Admission
@endpush
@push('page_head')
    Exam Admission
@endpush
@push('side_head')
    Student
@endpush

@section('content')
    @include('component.flash')

    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">Exam Admission Form</h4>
            <form method="POST" action="{{ route('student.exam-admission.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Exam Category</label>
                    <select class="form-select" name="exam_category_id" id="categorySelect" required>
                        <option value="">Select Category</option>
                        <option value="">Select Exam</option>
                        <option>Term Exam</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Exam</label>
                    <select class="form-select" name="exam_id" id="examSelect" required>
                        <option value="">Select Exam</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fee</label>
                    <input type="text" class="form-control" id="examFee" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Submit Admission</button>
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

            const response = await fetch(`{{ url('/student/exam-categories') }}/${this.value}/exams`);
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