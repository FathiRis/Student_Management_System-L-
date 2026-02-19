<p>Hello {{ $admission->student?->student_name ?? 'Student' }},</p>
<p>Your exam admission has been submitted successfully.</p>
<p><strong>Admission No:</strong> {{ $admission->admission_no }}</p>
<p><strong>Exam:</strong> {{ $admission->exam?->name }}</p>
<p><strong>Fee:</strong> {{ number_format((float) $admission->fee_at_submission, 2) }}</p>
<p>Thank you.</p>
