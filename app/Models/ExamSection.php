<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSection extends Model
{
    protected $fillable = [
        'exam_id',
        'kod',
        'nama',
        'urutan',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class)->orderBy('urutan');
    }

    /**
     * True when the section has only one question, so the table should
     * render it as a single column instead of a section header + 1 sub-column.
     */
    public function displaysFlat(): bool
    {
        return $this->questions->count() <= 1;
    }

    /**
     * Total possible marks for this section.
     */
    public function jumlahMarkah(): float
    {
        return (float) $this->questions->sum('markah_penuh');
    }
}
