<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Exam extends Model
{
    protected $fillable = [
        'class_id',
        'nama',
        'jumlah_markah',
        'tarikh',
    ];

    protected $casts = [
        'tarikh' => 'date',
        'jumlah_markah' => 'integer',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(ExamSection::class)->orderBy('urutan');
    }

    public function questions(): HasManyThrough
    {
        return $this->hasManyThrough(
            ExamQuestion::class,
            ExamSection::class,
            'exam_id',
            'exam_section_id'
        );
    }
}
