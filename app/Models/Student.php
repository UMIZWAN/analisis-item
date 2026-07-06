<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'class_id',
        'nama',
        'no_pelajar',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function marks(): HasMany
    {
        return $this->hasMany(StudentMark::class);
    }

    /**
     * Total marks the student scored on a given exam.
     */
    public function totalForExam(Exam $exam): float
    {
        return (float) $this->marks()
            ->whereHas('question.section', fn ($q) => $q->where('exam_id', $exam->id))
            ->sum('markah');
    }
}
