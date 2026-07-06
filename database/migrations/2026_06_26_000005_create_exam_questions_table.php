<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_section_id')->constrained('exam_sections')->cascadeOnDelete();
            $table->string('label', 16);
            $table->decimal('markah_penuh', 6, 2);
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();

            $table->unique(['exam_section_id', 'label']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
