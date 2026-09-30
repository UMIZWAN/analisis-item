{{--
    Top navigation bar. The three links are placeholders (href="#") — point them at real routes later.
--}}
@php
    $links = [
        ['label' => 'Pautan 1', 'href' => '#'],
        ['label' => 'Pautan 2', 'href' => '#'],
        ['label' => 'Pautan 3', 'href' => '#'],
    ];
@endphp

<header class="sticky top-0 z-50 bg-linear-to-r from-blue-800 via-blue-700 to-indigo-700 text-white shadow-lg">
    <nav class="navbar max-w-350 mx-auto px-4 sm:px-6 min-h-16">
        {{-- Brand + mobile menu --}}
        <div class="navbar-start w-auto lg:w-1/2 gap-1">
            <div class="dropdown lg:hidden">
                <button type="button" tabindex="0" class="btn btn-ghost btn-square" aria-label="Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <ul tabindex="0" class="menu dropdown-content bg-base-100 text-base-content rounded-box z-10 mt-3 w-52 p-2 shadow-lg">
                    @foreach ($links as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <a href="{{ route('home') }}" class="flex items-center gap-2 whitespace-nowrap text-lg sm:text-xl font-bold tracking-tight">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/15 ring-1 ring-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </span>
                Analisis Item
            </a>
        </div>

        {{-- Desktop links --}}
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal gap-1 px-1">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ $link['href'] }}" class="rounded-lg font-medium text-white/90 hover:bg-white/15 hover:text-white">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- User --}}
        <div class="navbar-end gap-2">
            @auth
                <div class="hidden sm:flex items-center gap-2 text-sm">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20 font-semibold uppercase">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </span>
                    <span class="opacity-90">{{ auth()->user()->name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline border-white/40 text-white hover:bg-white hover:text-blue-700">
                        Log Keluar
                    </button>
                </form>
            @endauth
        </div>
    </nav>
</header>
