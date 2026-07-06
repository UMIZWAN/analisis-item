<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Masuk &mdash; Analisis Item</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-linear-to-br from-slate-50 via-white to-blue-50">
    <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 rounded-2xl shadow-2xl overflow-hidden bg-white">

        {{-- Left: brand panel --}}
        <div class="bg-linear-to-br from-blue-700 to-blue-500 text-white p-10 flex flex-col justify-center">
            <span class="badge badge-lg bg-white/15 text-white border-0 mb-6 w-fit">Platform Pentaksiran</span>

            <h1 class="text-4xl font-bold mb-4">Analisis Item</h1>

            <p class="text-white/85 mb-8 leading-relaxed max-w-sm">
                Nilai kualiti soalan, indeks kesukaran dan diskriminasi &mdash; semuanya dalam satu platform.
            </p>

            <ul class="space-y-3 text-white/90">
                <li class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Pengiraan kesukaran &amp; diskriminasi automatik</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Pandangan terperinci pada setiap item</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Laporan boleh dieksport untuk pihak berkepentingan</span>
                </li>
            </ul>
        </div>

        {{-- Right: sign-in form --}}
        <div class="p-10 flex flex-col justify-center">
            <h2 class="text-3xl font-bold mb-2">Log Masuk</h2>
            <p class="text-base-content/60 mb-6">Gunakan akaun Analisis Item anda untuk meneruskan.</p>

            @if ($errors->any())
                <div role="alert" class="alert alert-error text-sm mb-4">
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('status'))
                <div role="alert" class="alert alert-success text-sm mb-4">
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-semibold mb-2">Nama Pengguna</label>
                    <input
                        id="username"
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        class="input input-bordered w-full rounded-lg"
                        required
                        autofocus
                    />
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold mb-2">Kata Laluan</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="input input-bordered w-full rounded-lg"
                        required
                    />
                </div>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="checkbox checkbox-sm" />
                    <span class="text-sm">Kekal log masuk selama 30 hari</span>
                </label>

                <button type="submit" class="btn btn-primary w-full bg-blue-600 hover:bg-blue-700 border-0 text-white rounded-lg">
                    Log Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>
