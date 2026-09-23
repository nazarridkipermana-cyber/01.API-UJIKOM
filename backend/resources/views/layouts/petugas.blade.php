<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Petugas')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'IBM Plex Sans', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }
    </style>
</head>
<body class="bg-[#F3F1EC] text-[#1B1F27] antialiased">

    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-[#14181F] text-white flex-col hidden md:flex flex-shrink-0">
            <div class="p-5 flex items-center gap-3 border-b border-white/10">
                <div class="w-9 h-9 rounded-md bg-[#C98A3B]/15 border border-[#C98A3B]/40 flex items-center justify-center flex-shrink-0">
                    <span class="font-mono text-[#C98A3B] text-sm font-semibold">[A]</span>
                </div>
                <div>
                    <div class="font-display font-semibold leading-tight">Panel Petugas</div>
                    <div class="text-xs text-white/40 leading-tight font-mono">peminjaman&nbsp;alat</div>
                </div>
            </div>

            <nav class="flex-1 py-5 space-y-0.5">
                @php
                    $navItem = function($routePattern) {
                        return request()->routeIs($routePattern)
                            ? 'border-[#C98A3B] text-white bg-white/[0.04]'
                            : 'border-transparent text-white/45 hover:text-white/80 hover:bg-white/[0.03]';
                    };
                @endphp

                <a href="{{ route('petugas.peminjaman.index') }}"
                    class="flex items-center gap-3 px-5 py-3 border-l-2 transition {{ $navItem('petugas.peminjaman*') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm">Persetujuan peminjaman</span>
                </a>

                <a href="{{ route('petugas.pengembalian.index') }}"
                    class="flex items-center gap-3 px-5 py-3 border-l-2 transition {{ $navItem('petugas.pengembalian*') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span class="text-sm">Pemantauan pengembalian</span>
                </a>

                <a href="{{ route('petugas.laporan.index') }}"
                    class="flex items-center gap-3 px-5 py-3 border-l-2 transition {{ $navItem('petugas.laporan*') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h4m0 0l-3-3m3 3l-3 3M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                    </svg>
                    <span class="text-sm">Cetak laporan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-full bg-[#C98A3B] text-[#14181F] flex items-center justify-center font-display font-semibold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs text-white/40">Masuk sebagai</div>
                        <div class="text-sm font-medium truncate">{{ auth()->user()->name ?? 'Petugas' }}</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 border border-[#B23A2E]/40 text-[#E8998F] hover:bg-[#B23A2E]/10 text-sm font-medium px-4 py-2.5 rounded-md transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <main class="flex-1 p-8 max-w-6xl w-full mx-auto">
                @if(session('success'))
                    <div class="mb-6 bg-white border-l-2 border-[#3F7D58] text-[#1B1F27] pl-4 pr-4 py-3 rounded-r-md text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-white border-l-2 border-[#B23A2E] text-[#1B1F27] pl-4 pr-4 py-3 rounded-r-md text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>