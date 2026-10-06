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
        :root {
            --de-black: #0b0b0d;
            --de-red: #d00000;
            --de-red-dark: #8f0000;
            --de-gold: #ffce00;
            --de-gold-soft: #fff6d1;
            --de-bg: #f5f3ee;
            --de-line: #e7e3d8;
        }
        body { font-family: 'IBM Plex Sans', sans-serif; background: var(--de-bg) !important; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }

        /* ================= SIDEBAR ================= */
        .de-sidebar {
            background:
                radial-gradient(120% 60% at 0% 0%, rgba(208, 0, 0, .28) 0%, transparent 60%),
                linear-gradient(180deg, #0d0d10 0%, #120000 100%);
            box-shadow: 4px 0 24px rgba(0, 0, 0, .18);
            position: relative;
        }
        .de-sidebar::after {
            content: ""; position: absolute; top: 0; right: 0; bottom: 0; width: 2px;
            background: linear-gradient(180deg, #000 0 33.3%, var(--de-red) 33.3% 66.6%, var(--de-gold) 66.6%);
        }
        .de-brand { padding: 26px 20px 20px; }
        .de-logo {
            width: 38px; height: 38px; border-radius: 10px; overflow: hidden;
            display: flex; flex-direction: column; flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .45), 0 0 0 1px rgba(255, 255, 255, .12);
        }
        .de-logo i { flex: 1; display: block; }
        .de-logo i:nth-child(1) { background: #000; }
        .de-logo i:nth-child(2) { background: var(--de-red); }
        .de-logo i:nth-child(3) { background: var(--de-gold); }
        .de-title { font-family: 'Space Grotesk', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: .14em; color: #fff; line-height: 1.1; white-space: nowrap; }
        .de-sub { margin-top: 5px; font-size: 8.5px; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: var(--de-gold); white-space: nowrap; }
        .de-divider { height: 1px; margin: 0 22px; background: linear-gradient(90deg, rgba(255, 206, 0, .55), rgba(255, 255, 255, .06) 70%, transparent); }
        .de-section { padding: 22px 26px 8px; font-size: 10px; font-weight: 600; letter-spacing: .25em; text-transform: uppercase; color: rgba(255, 255, 255, .32); }

        .de-link {
            position: relative; display: flex; align-items: center; gap: 12px;
            padding: 11px 16px; margin: 2px 0; border-radius: 10px;
            font-size: 14px; font-weight: 500; color: rgba(255, 255, 255, .62);
            transition: all .2s ease;
        }
        .de-link svg {
            width: 18px; height: 18px; flex-shrink: 0; fill: none; stroke: currentColor;
            stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; opacity: .85;
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

        .de-user {
            margin: 14px 14px 10px; padding: 12px 14px; border-radius: 12px;
            display: flex; align-items: center; gap: 12px;
            background: rgba(255, 255, 255, .04); border: 1px solid rgba(255, 255, 255, .08);
        }
        .de-avatar {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--de-gold), #e0a800);
            color: #1a1200; font-weight: 800; font-size: 14px;
            box-shadow: 0 0 0 2px rgba(255, 206, 0, .25);
        }
        .de-user-name { font-size: 13px; font-weight: 600; color: #fff; line-height: 1.2; }
        .de-user-role { font-size: 10px; letter-spacing: .18em; text-transform: uppercase; color: var(--de-gold); margin-top: 2px; }

        .de-logout-side {
            width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px;
            padding: 11px 16px; border-radius: 10px;
            font-size: 13px; font-weight: 600; letter-spacing: .08em; color: #fff;
            background: linear-gradient(135deg, var(--de-red), var(--de-red-dark));
            box-shadow: 0 6px 14px rgba(208, 0, 0, .3);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .de-logout-side svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .de-logout-side:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgba(208, 0, 0, .45); }

        /* ================= STRIP TRICOLOR ATAS ================= */
        .de-topstrip {
            position: sticky; top: 0; z-index: 20; height: 4px; flex-shrink: 0;
            background: linear-gradient(90deg, #000 0 33.3%, var(--de-red) 33.3% 66.6%, var(--de-gold) 66.6%);
        }

        /* ================= ALERT ================= */
        .de-alert { padding: 12px 16px; border-radius: 10px; font-size: 14px; margin-bottom: 24px; background: #fff; }
        .de-alert-success { background: var(--de-gold-soft); border: 1px solid #f0dc7a; border-left: 5px solid var(--de-gold); color: #4a3b00; }
        .de-alert-error   { background: #fdecec; border: 1px solid #f3c2c2; border-left: 5px solid var(--de-red); color: #6b0000; }

        /* ================= OVERRIDE KONTEN ================= */
        /* Tombol aksi teal/cokelat -> merah Jerman */
        main [class~="bg-[#3B6E71]"], main [class~="bg-[#C98A3B]"] {
            background: linear-gradient(135deg, var(--de-red), var(--de-red-dark)) !important;
            color: #fff !important;
            box-shadow: 0 6px 14px rgba(208, 0, 0, .25);
            transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
        }
        main button[class~="bg-[#3B6E71]"]:hover, main a[class~="bg-[#3B6E71]"]:hover,
        main button[class~="bg-[#C98A3B]"]:hover, main a[class~="bg-[#C98A3B]"]:hover {
            transform: translateY(-1px); filter: brightness(1.08); box-shadow: 0 10px 20px rgba(208, 0, 0, .35);
        }
        /* Tombol/avatar gelap -> hitam dengan teks emas */
        main [class~="bg-[#14181F]"], main [class~="bg-[#1B1F27]"] {
            background: var(--de-black) !important; color: var(--de-gold) !important;
        }
        /* Teks & border teal/cokelat */
        main [class~="text-[#3B6E71]"], main [class~="text-[#C98A3B]"] { color: var(--de-red-dark) !important; }
        main [class~="border-[#3B6E71]"], main [class~="border-[#C98A3B]"] { border-color: var(--de-red) !important; }
        main [class*="bg-[#3B6E71]/"], main [class*="bg-[#C98A3B]/"] { background: var(--de-gold-soft) !important; }

        /* Input fokus */
        main input:focus, main select:focus, main textarea:focus {
            outline: none !important; border-color: var(--de-red) !important;
            box-shadow: 0 0 0 3px rgba(208, 0, 0, .12) !important;
        }

        /* Panel besar: garis tricolor lurus di atas */
        main .bg-white:has(> [class*="border-b"]) {
            border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(11, 11, 13, .05);
        }
        main .bg-white:has(> [class*="border-b"])::before {
            content: ""; display: block; height: 3px;
            background: linear-gradient(90deg, #000 0 33.3%, var(--de-red) 33.3% 66.6%, var(--de-gold) 66.6%);
        }

        /* Baris/kartu data: hover emas */
        main .bg-white.rounded-lg:not(:has(> [class*="border-b"])) { transition: all .2s ease; }
        main .bg-white.rounded-lg:not(:has(> [class*="border-b"])):hover {
            border-color: var(--de-gold) !important; box-shadow: 0 10px 24px rgba(11, 11, 13, .08);
        }

        /* Tabel */
        main table thead, main table thead tr, main table thead th {
            background: var(--de-black) !important; color: var(--de-gold) !important; letter-spacing: 1.5px;
        }
        main table tbody tr:hover { background: var(--de-gold-soft) !important; }
    </style>
</head>
<body class="text-[#1B1F27] antialiased">

    @php
        $nama = auth()->user()->name ?? 'Petugas';

        $menus = [
            ['Persetujuan peminjaman',  'petugas.peminjaman.index',   'petugas.peminjaman*',
             '<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
            ['Pemantauan pengembalian', 'petugas.pengembalian.index', 'petugas.pengembalian*',
             '<polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/>'],
            ['Cetak laporan',           'petugas.laporan.index',      'petugas.laporan*',
             '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>'],
        ];
    @endphp

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="de-sidebar w-64 text-white flex-col hidden md:flex flex-shrink-0">

            <div class="de-brand flex items-center gap-3">
                <div class="de-logo"><i></i><i></i><i></i></div>
                <div>
                    <div class="de-title">PANEL PETUGAS</div>
                    <div class="de-sub">Sistem Peminjaman Alat</div>
                </div>
            </div>

            <div class="de-divider"></div>
            <div class="de-section">Menu Utama</div>

            <nav class="flex-1 px-4 overflow-y-auto">
                @foreach($menus as [$label, $routeName, $pattern, $icon])
                    <a href="{{ route($routeName) }}" class="de-link {{ request()->routeIs($pattern) ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">{!! $icon !!}</svg>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="de-divider"></div>

            <div class="de-user">
                <div class="de-avatar">{{ strtoupper(mb_substr($nama, 0, 1)) }}</div>
                <div class="min-w-0">
                    <div class="de-user-name truncate">{{ $nama }}</div>
                    <div class="de-user-role">Petugas</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="px-4 pb-5">
                @csrf
                <button type="submit" class="de-logout-side">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Keluar</span>
                </button>
            </form>
        </aside>

        <!-- KONTEN -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <div class="de-topstrip"></div>

            <main class="flex-1 p-8 max-w-6xl w-full mx-auto">
                @if(session('success'))
                    <div class="de-alert de-alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="de-alert de-alert-error">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>