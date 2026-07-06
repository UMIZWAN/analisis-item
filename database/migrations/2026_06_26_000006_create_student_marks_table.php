<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('exam_question_id')->constrained('exam_questions')->cascadeOnDelete();
            $table->decimal('markah', 6, 2);
            $table->timestamps();

            $table->unique(['student_id', 'exam_question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_marks');
    }
};
