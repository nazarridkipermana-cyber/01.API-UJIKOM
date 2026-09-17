<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Petugas')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex">
            <div class="p-5 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div>
                    <div class="font-bold leading-tight">Panel Petugas</div>
                    <div class="text-xs text-gray-400 leading-tight">Sistem Peminjaman Alat</div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <div class="px-2 pb-2 text-xs uppercase tracking-wider text-gray-500">Menu utama</div>

                <a href="{{ route('petugas.peminjaman.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                    {{ request()->routeIs('petugas.peminjaman*') ? 'bg-white text-gray-900 font-semibold shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Persetujuan peminjaman
                </a>

                <a href="{{ route('petugas.pengembalian.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                    {{ request()->routeIs('petugas.pengembalian*') ? 'bg-white text-gray-900 font-semibold shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Pemantauan pengembalian
                </a>

                <a href="{{ route('petugas.laporan.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                    {{ request()->routeIs('petugas.laporan*') ? 'bg-white text-gray-900 font-semibold shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h4m0 0l-3-3m3 3l-3 3M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                    </svg>
                    Cetak laporan
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-full bg-amber-700 flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Masuk sebagai</div>
                        <div class="text-sm font-semibold">{{ auth()->user()->name ?? 'Petugas' }}</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-red-900/40 hover:bg-red-900/60 text-red-300 text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <main class="flex-1 p-8">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>