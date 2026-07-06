{{--
    Usage: @include('partials.exam-marks-table', ['exam' => $exam, 'students' => $students])
    Expects $exam with sections.questions eager-loaded, and $students with marks eager-loaded.
--}}
@php
    $sections = $exam->sections;
    $jumlahPenuh = $sections->sum(fn ($s) => $s->questions->sum('markah_penuh'));

    $gred = function (float $peratus): string {
        return match (true) {
            $peratus >= 80 => 'A',
            $peratus >= 60 => 'B',
            $peratus >= 40 => 'C',
            $peratus >= 20 => 'D',
            default        => 'E',
        };
    };
@endphp

<div class="overflow-x-auto border border-base-300 rounded-lg">
    <table class="table table-zebra table-xs text-center w-full">
        <thead>
            {{-- Row 1: top headers --}}
            <tr class="bg-pink-200 text-base-content">
                <th rowspan="2" class="align-middle">BIL</th>
                <th rowspan="2" class="align-middle">NO. PELAJAR</th>
                <th rowspan="2" class="align-middle">NAMA</th>
                <th rowspan="2" class="align-middle">KELAS</th>

                @foreach ($sections as $section)
                    @php
                        $flat = $section->displaysFlat();
                        $qCount = max(1, $section->questions->count());
                    @endphp

                    {{-- Section header. If flat, span 1 row too (no sub-header below). --}}
                    <th @if ($flat) rowspan="2" @endif
                        colspan="{{ $flat ? 1 : $qCount }}"
                        class="align-middle
                            @if ($section->kod === 'K1') bg-amber-200
                            @elseif ($section->kod === 'K2') bg-cyan-200
                            @elseif ($section->kod === 'K3') bg-green-200
                            @else bg-orange-300 @endif">
                        {{ $section->kod }}
                    </th>

                    {{-- Per-section JUMLAH only when section is multi-question --}}
                    @if (! $flat)
                        <th rowspan="2" class="align-middle bg-cyan-300">JUMLAH</th>
                    @endif
                @endforeach

                <th rowspan="2" class="align-middle bg-pink-300">JUMLAH<br>MARKAH</th>
                <th rowspan="2" class="align-middle bg-slate-200">PERATUS</th>
                <th rowspan="2" class="align-middle bg-slate-200">GRED</th>
            </tr>

            {{-- Row 2: question sub-labels for multi-question sections --}}
            <tr class="bg-base-200">
                @foreach ($sections as $section)
                    @if (! $section->displaysFlat())
                        @foreach ($section->questions as $q)
                            <th class="text-xs">{{ $q->label }}</th>
                        @endforeach
                    @endif
                @endforeach
            </tr>
        </thead>

        <tbody>
            @forelse ($students as $i => $student)
                @php
                    $marksByQuestion = $student->marks->keyBy('exam_question_id');
                    $jumlahMarkah = 0;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $student->no_pelajar }}</td>
                    <td class="text-left">{{ $student->nama }}</td>
                    <td>{{ $student->classroom->name ?? '-' }}</td>

                    @foreach ($sections as $section)
                        @php
                            $sectionTotal = 0;
                        @endphp
                        @foreach ($section->questions as $q)
                            @php
                                $m = (float) ($marksByQuestion[$q->id]->markah ?? 0);
                                $sectionTotal += $m;
                                $jumlahMarkah += $m;
                            @endphp
                            <td>{{ $marksByQuestion[$q->id]->markah ?? '-' }}</td>
                        @endforeach
                        @if (! $section->displaysFlat())
                            <td class="font-semibold bg-cyan-50">{{ rtrim(rtrim(number_format($sectionTotal, 2), '0'), '.') }}</td>
                        @endif
                    @endforeach

                    @php
                        $peratus = $jumlahPenuh > 0 ? ($jumlahMarkah / $jumlahPenuh) * 100 : 0;
                    @endphp
                    <td class="font-bold bg-pink-50">{{ rtrim(rtrim(number_format($jumlahMarkah, 2), '0'), '.') }}</td>
                    <td>{{ number_format($peratus, 1) }}%</td>
                    <td class="font-bold">{{ $gred($peratus) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="100" class="text-base-content/60 italic py-6">Tiada pelajar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
