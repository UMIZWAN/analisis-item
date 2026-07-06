<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamQuestion extends Model
{
    protected $fillable = [
        'exam_section_id',
        'label',
        'markah_penuh',
        'urutan',
    ];

    protected $casts = [
        'markah_penuh' => 'decimal:2',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(ExamSection::class, 'exam_section_id');
    }

    public function marks(): HasMany
    {
        return $this->hasMany(StudentMark::class);
    }
}
