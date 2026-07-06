<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamSection;
use App\Models\Student;
use App\Models\StudentMark;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        $classroom = Classroom::create([
            'name' => '5 Bestari',
            'tingkatan' => 'Tingkatan 5',
        ]);

        $studentNames = [
            'Ahmad bin Ali',
            'Siti Nurhaliza binti Hassan',
            'Lim Wei Jie',
            'Muthu a/l Subramaniam',
            'Nor Aisyah binti Ibrahim',
            'Tan Mei Ling',
            'Mohd Faizal bin Razak',
            'Priya a/p Krishnan',
            'Hafiz bin Yusof',
            'Chong Hui Min',
        ];

        $students = collect($studentNames)->map(fn ($nama, $i) => Student::create([
            'class_id' => $classroom->id,
            'nama' => $nama,
            'no_pelajar' => sprintf('S%04d', $i + 1),
        ]));

        $exam = Exam::create([
            'class_id' => $classroom->id,
            'nama' => 'Peperiksaan Pertengahan Tahun',
            'jumlah_markah' => 100,
            'tarikh' => now()->toDateString(),
        ]);

        // K1: A, B
        $k1 = ExamSection::create([
            'exam_id' => $exam->id,
            'kod' => 'K1',
            'nama' => 'Kertas 1',
            'urutan' => 1,
        ]);
        $k1Questions = collect(['A', 'B'])->map(fn ($label, $i) => ExamQuestion::create([
            'exam_section_id' => $k1->id,
            'label' => $label,
            'markah_penuh' => 10,
            'urutan' => $i + 1,
        ]));

        // K2: 1..9
        $k2 = ExamSection::create([
            'exam_id' => $exam->id,
            'kod' => 'K2',
            'nama' => 'Kertas 2',
            'urutan' => 2,
        ]);
        $k2Questions = collect(range(1, 9))->map(fn ($n, $i) => ExamQuestion::create([
            'exam_section_id' => $k2->id,
            'label' => (string) $n,
            'markah_penuh' => 5,
            'urutan' => $i + 1,
        ]));

        // K3: INDIVIDU, BERKUMPULAN
        $k3 = ExamSection::create([
            'exam_id' => $exam->id,
            'kod' => 'K3',
            'nama' => 'Kertas 3',
            'urutan' => 3,
        ]);
        $k3Questions = collect(['INDIVIDU', 'BERKUMPULAN'])->map(fn ($label, $i) => ExamQuestion::create([
            'exam_section_id' => $k3->id,
            'label' => $label,
            'markah_penuh' => 10,
            'urutan' => $i + 1,
        ]));

        // K4: single question — will render flat (no sub-header)
        $k4 = ExamSection::create([
            'exam_id' => $exam->id,
            'kod' => 'K4',
            'nama' => 'Kertas 4',
            'urutan' => 4,
        ]);
        $k4Questions = collect([
            ExamQuestion::create([
                'exam_section_id' => $k4->id,
                'label' => '1',
                'markah_penuh' => 20,
                'urutan' => 1,
            ]),
        ]);

        $allQuestions = $k1Questions
            ->concat($k2Questions)
            ->concat($k3Questions)
            ->concat($k4Questions);

        foreach ($students as $student) {
            foreach ($allQuestions as $q) {
                $max = (float) $q->markah_penuh;
                // random score between 40% and 100% of max, rounded to nearest 0.5
                $score = round(mt_rand((int) ($max * 40), (int) ($max * 100)) / 100 * 2) / 2;

                StudentMark::create([
                    'student_id' => $student->id,
                    'exam_question_id' => $q->id,
                    'markah' => min($score, $max),
                ]);
            }
        }
    }
}
