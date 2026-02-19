<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'exam_category_id',
        'name',
        'exam_date',
        'fee',
        'eligibility_rules',
        'is_active',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExamCategory::class, 'exam_category_id');
    }

    public function examAdmissions(): HasMany
    {
        return $this->hasMany(ExamAdmission::class);
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class)->withTimestamps();
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
