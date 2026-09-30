<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $exam->nama ?? 'Analysis Subject' }} &mdash; Analysis Subject</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200">

    @include('partials.navbar')

    <main class="max-w-350 mx-auto p-6 space-y-6">

        {{-- Title banner like the screenshot --}}
        <div class="bg-blue-700 text-white text-center py-4 rounded-lg shadow">
            <h1 class="text-2xl font-bold underline tracking-wide">
                ANALISIS ITEM (PENETAPAN SASARAN SPM)
            </h1>
        </div>

        {{-- Exam selector pills --}}
        @if ($exams->isNotEmpty())
            <div class="flex flex-wrap gap-2 items-center">
                <span class="font-semibold text-sm me-2">Pilih Peperiksaan:</span>
                @foreach ($exams as $e)
                    @php $active = $exam && $e->id === $exam->id; @endphp
                    <a href="{{ url('/?exam=' . $e->id) }}"
                       class="btn btn-sm rounded-full {{ $active ? 'btn-primary' : 'btn-outline' }}">
                        {{ $e->nama }}
                        @if ($e->tarikh)
                            <span class="opacity-70 text-xs ms-1">({{ $e->tarikh->format('d/m/Y') }})</span>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Exam table --}}
        @if ($exam)
            <div class="card bg-base-100 shadow-md">
                <div class="card-body p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h2 class="text-lg font-bold">{{ $exam->nama }}</h2>
                            <p class="text-sm text-base-content/60">
                                Kelas: {{ $exam->classroom->name ?? '-' }}
                                @if ($exam->tarikh) &middot; {{ $exam->tarikh->format('d M Y') }} @endif
                            </p>
                        </div>
                        <div class="text-sm text-base-content/70">
                            Jumlah Pelajar: <span class="font-semibold">{{ $students->count() }}</span>
                        </div>
                    </div>

                    @include('partials.exam-marks-table', ['exam' => $exam, 'students' => $students])
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <span>Tiada peperiksaan untuk dipaparkan. Jalankan <code>php artisan migrate:fresh --seed</code>.</span>
            </div>
        @endif
    </main>

</body>
</html>
