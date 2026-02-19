<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamAdmission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'exam_id',
        'admission_no',
        'fee_at_submission',
        'payment_status',
        'remarks',
        'admitted_by',
    ];

    protected $casts = [
        'fee_at_submission' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function admittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admitted_by');
    }
}
