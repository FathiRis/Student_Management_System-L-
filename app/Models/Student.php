<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'student_name',
        'mobile_no',
        'email',
        'grade',
        'index_no',
        'dob',
        'gender',
        'father_name',
        'father_no',
        'mother_name',
        'mother_no',
        'address',
        'address2',
        'message',
        'status',
        'photo_path',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function examAdmissions(): HasMany
    {
        return $this->hasMany(ExamAdmission::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
