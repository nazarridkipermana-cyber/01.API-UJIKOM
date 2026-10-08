<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --de-black: #0b0b0d;
            --de-red: #d00000;
            --de-red-dark: #8f0000;
            --de-gold: #ffce00;
            --de-gold-soft: #fff6d1;
            --de-bg: #f5f3ee;
            --de-line: #e7e3d8;
        }
        body { background: var(--de-bg) !important; }

        /* ================= SIDEBAR / PANEL ================= */
        .de-sidebar {
            background:
                radial-gradient(120% 60% at 0% 0%, rgba(208, 0, 0, .28) 0%, transparent 60%),
                linear-gradient(180deg, #0d0d10 0%, #120000 100%);
            box-shadow: 4px 0 24px rgba(0, 0, 0, .18);
            position: relative;
        }
        .de-sidebar::after {
            content: "";
            position: absolute; top: 0; right: 0; bottom: 0; width: 2px;
            background: linear-gradient(180deg, #000 0 33.3%, var(--de-red) 33.3% 66.6%, var(--de-gold) 66.6%);
            opacity: .9;
        }

        /* Brand */
        .de-brand { padding: 26px 22px 20px; }
        .de-logo {
            width: 38px; height: 38px; border-radius: 10px; overflow: hidden;
            display: flex; flex-direction: column; flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .45), 0 0 0 1px rgba(255, 255, 255, .12);
        }
        .de-logo i { flex: 1; display: block; }
        .de-logo i:nth-child(1) { background: #000; }
        .de-logo i:nth-child(2) { background: var(--de-red); }
        .de-logo i:nth-child(3) { background: var(--de-gold); }
        .de-title { font-size: 15px; font-weight: 700; letter-spacing: .28em; color: #fff; line-height: 1.1; }
        .de-sub {
            margin-top: 5px; font-size: 9.5px; font-weight: 600;
            letter-spacing: .22em; text-transform: uppercase; color: var(--de-gold);
        }
        .de-divider {
            height: 1px; margin: 0 22px;
            background: linear-gradient(90deg, rgba(255, 206, 0, .55), rgba(255, 255, 255, .06) 70%, transparent);
        }
        .de-section {
            padding: 22px 26px 8px; font-size: 10px; font-weight: 600;
            letter-spacing: .25em; text-transform: uppercase; color: rgba(255, 255, 255, .32);
        }

        /* Menu */
        .de-link {
            position: relative;
            display: flex; align-items: center; gap: 12px;
            padding: 11px 16px; margin: 2px 0;
            border-radius: 10px;
            font-size: 14px; font-weight: 500; letter-spacing: .01em;
            color: rgba(255, 255, 255, .62);
            transition: all .2s ease;
        }
        .de-link svg {
            width: 18px; height: 18px; flex-shrink: 0;
            fill: none; stroke: currentColor; stroke-width: 1.7;
            stroke-linecap: round; stroke-linejoin: round;
            opacity: .85; transition: all .2s ease;
        }
        .de-link:hover { color: #fff; background: rgba(255, 255, 255, .05); transform: translateX(3px); }
        .de-link.active {
            color: var(--de-gold); font-weight: 600;
            background: linear-gradient(90deg, rgba(255, 206, 0, .13), rgba(255, 206, 0, .02));
            box-shadow: inset 0 0 0 1px rgba(255, 206, 0, .14);
        }
        .de-link.active::before {
            content: ""; position: absolute; left: -16px; top: 20%; bottom: 20%;
            width: 4px; border-radius: 0 4px 4px 0;
            background: linear-gradient(180deg, var(--de-red), var(--de-gold));
            box-shadow: 0 0 12px rgba(255, 206, 0, .55);
        }
        .de-link.active svg { opacity: 1; }

        /* User card */
        .de-user {
            margin: 14px 14px 10px; padding: 12px 14px; border-radius: 12px;
            display: flex; align-items: center; gap: 12px;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .08);
        }
        .de-avatar {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--de-gold), #e0a800);
            color: #1a1200; font-weight: 800; font-size: 14px;
            box-shadow: 0 0 0 2px rgba(255, 206, 0, .25);
        }
        .de-user-name { font-size: 13px; font-weight: 600; color: #fff; line-height: 1.2; }
        .de-user-role {
            font-size: 10px; letter-spacing: .18em; text-transform: uppercase;
            color: var(--de-gold); margin-top: 2px;
        }

        /* Foto profil di kartu user + efek klik */
        .de-avatar-img {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0; object-fit: cover;
            box-shadow: 0 0 0 2px rgba(255, 206, 0, .25);
        }
        a.de-user { transition: background .2s ease, border-color .2s ease; }
        a.de-user:hover { background: rgba(255, 255, 255, .08); border-color: rgba(255, 206, 0, .35); }

        /* Logout di sidebar */
        .de-logout-side {
            width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            padding: 11px 16px;
            border-radius: 10px;
            font-size: 13px; font-weight: 600; letter-spacing: .08em;
            color: #fff;
            background: linear-gradient(135deg, var(--de-red), var(--de-red-dark));
            box-shadow: 0 6px 14px rgba(208, 0, 0, .3);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .de-logout-side svg {
            width: 16px; height: 16px;
            fill: none; stroke: currentColor; stroke-width: 2;
            stroke-linecap: round; stroke-linejoin: round;
        }
        .de-logout-side:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgba(208, 0, 0, .45); }

        /* ================= HEADER ================= */
        .de-header { position: relative; border-bottom: 1px solid var(--de-line); }
        .de-header::after {
            content: ""; position: absolute; left: 0; right: 0; bottom: -1px; height: 3px;
            background: linear-gradient(90deg, #000 0 33.3%, var(--de-red) 33.3% 66.6%, var(--de-gold) 66.6%);
        }

        /* ================= OVERRIDE KONTEN HALAMAN ================= */
        main .bg-emerald-50, main .bg-green-50 {
            background: var(--de-gold-soft) !important;
            border-color: #f0dc7a !important;
            border-left: 5px solid var(--de-gold) !important;
            color: #4a3b00 !important;
        }
        main .bg-emerald-50 [class*="text-emerald"], main .bg-green-50 [class*="text-green"],
        main .bg-emerald-50 strong, main .bg-green-50 strong {
            color: var(--de-red-dark) !important;
        }
        main [class*="text-emerald-8"], main [class*="text-green-8"] { color: #4a3b00 !important; }

        main .bg-white.shadow, main .bg-white.shadow-sm, main .bg-white.shadow-md {
            border-top: 3px solid var(--de-red); border-radius: .75rem;
        }
        main table thead, main table thead tr, main table thead th {
            background: var(--de-black) !important; color: var(--de-gold) !important; letter-spacing: 1.5px;
        }
        main table tbody tr:hover { background: var(--de-gold-soft) !important; }

        main .bg-blue-600, main .bg-blue-500, main .bg-indigo-600, main .bg-indigo-500 {
            background: linear-gradient(135deg, var(--de-red), var(--de-red-dark)) !important; color: #fff !important;
        }
        main .hover\:bg-blue-700:hover, main .hover\:bg-indigo-700:hover { filter: brightness(1.1); }
        main .text-blue-600, main .text-indigo-600 { color: var(--de-red) !important; }
    </style>
</head>
<body class="font-sans antialiased">

    @php
        $user = auth()->user();
        $role = $user->role ?? null;
        $nama = $user->name ?? '-';

        // ikon (feather-style)
        $icons = [
            'home'   => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
            'users'  => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>',
            'tag'    => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
            'tool'   => '<path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>',
            'clip'   => '<path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/>',
            'undo'   => '<polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/>',
            'pulse'  => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
            'file'   => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>',
            'check'  => '<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
            'eye'    => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
            'grid'   => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>',
            'clock'  => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        ];

        // [label, route, pattern aktif, ikon]
        $menus = [
            'admin' => [
                ['Dashboard',           'admin.dashboard',          'admin.dashboard',     'home'],
                ['Kelola User',         'admin.user.index',         'admin.user*',         'users'],
                ['Kelola Kategori',     'admin.kategori.index',     'admin.kategori*',     'tag'],
                ['Kelola Alat',         'admin.alat.index',         'admin.alat*',         'tool'],
                ['Kelola Peminjaman',   'admin.peminjaman.index',   'admin.peminjaman*',   'clip'],
                ['Kelola Pengembalian', 'admin.pengembalian.index', 'admin.pengembalian*', 'undo'],
                ['Log Aktivitas',       'admin.log.index',          'admin.log*',          'pulse'],
            ],
            'petugas' => [
                ['Persetujuan Peminjaman',  'petugas.peminjaman.index',   'petugas.peminjaman*',   'check'],
                ['Pemantauan Pengembalian', 'petugas.pengembalian.index', 'petugas.pengembalian*', 'eye'],
                ['Cetak Laporan',           'petugas.laporan.index',      'petugas.laporan*',      'file'],
            ],
            'peminjam' => [
                ['Katalog Alat',       'peminjam.katalog', 'peminjam.katalog', 'grid'],
                ['Riwayat Peminjaman', 'peminjam.riwayat', 'peminjam.riwayat', 'clock'],
            ],
        ];

        $judulPanel = ['admin' => 'PANEL ADMIN', 'petugas' => 'PANEL PETUGAS', 'peminjam' => 'PANEL PEMINJAM'];
    @endphp

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="de-sidebar w-64 text-white flex-col hidden md:flex">

            <div class="de-brand flex items-center gap-3">
                <div class="de-logo"><i></i><i></i><i></i></div>
                <div>
                    <div class="de-title">{{ $judulPanel[$role] ?? 'PANEL' }}</div>
                    <div class="de-sub">Sistem Peminjaman Alat</div>
                </div>
            </div>

            <div class="de-divider"></div>
            <div class="de-section">Menu Utama</div>

            <nav class="flex-1 px-4 overflow-y-auto">
                @foreach($menus[$role] ?? [] as [$label, $routeName, $pattern, $icon])
                    <a href="{{ route($routeName) }}"
                       class="de-link {{ request()->routeIs($pattern) ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">{!! $icons[$icon] !!}</svg>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="de-divider"></div>

            <!-- Kartu user (klik untuk membuka halaman profil) -->
            <a href="{{ route('profil.edit') }}" class="de-user" title="Ubah profil">
                @if(auth()->user()->foto_profile)
                    <img src="{{ asset(auth()->user()->foto_profile) }}" alt="Foto {{ $nama }}" class="de-avatar-img">
                @else
                    <div class="de-avatar">{{ strtoupper(mb_substr($nama, 0, 1)) }}</div>
                @endif
                <div class="min-w-0">
                    <div class="de-user-name truncate">{{ $nama }}</div>
                    <div class="de-user-role">{{ $role ?? '-' }}</div>
                </div>
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="px-4 pb-5">
                @csrf
                <button type="submit" class="de-logout-side">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Logout</span>
                </button>
            </form>
        </aside>

        <!-- MAIN CONTENT CONTAINER -->
        <div class="flex-1 flex flex-col overflow-y-auto">

            <header class="de-header bg-white shadow-sm h-16 flex items-center px-6 z-10">
                <div class="text-lg font-semibold text-gray-800">
                    @yield('header-title', 'Dashboard')
                </div>
            </header>

            <main class="flex-1 p-6">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>