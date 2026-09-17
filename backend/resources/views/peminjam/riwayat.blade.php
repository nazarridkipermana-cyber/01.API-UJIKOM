@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman - Peminjam')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat & Pengembalian Alat</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $peminjamans->count() }} total peminjaman</p>
        </div>
    </div>

    <div class="space-y-5">
        @forelse($peminjamans as $peminjaman)
            @php
                $badgeMap = [
                    'diajukan'     => ['Diajukan', 'bg-amber-100 text-amber-700', 'bg-amber-400', 'border-l-amber-400'],
                    'dipinjam'     => ['Sedang Dipinjam', 'bg-blue-100 text-blue-700', 'bg-blue-500', 'border-l-blue-500'],
                    'dikembalikan' => ['Dikembalikan', 'bg-emerald-100 text-emerald-700', 'bg-emerald-500', 'border-l-emerald-500'],
                ];
                [$label, $badgeClass, $dotClass, $borderClass] = $badgeMap[$peminjaman->status] ?? [ucfirst($peminjaman->status), 'bg-gray-100 text-gray-700', 'bg-gray-400', 'border-l-gray-300'];
                $denda = optional($peminjaman->pengembalian)->denda;
            @endphp

            <div class="bg-white rounded-2xl border border-gray-200 border-l-4 {{ $borderClass }} shadow-sm p-6 hover:shadow-md transition">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-gray-100 text-gray-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Peminjaman #{{ $peminjaman->id }}</p>
                            <p class="text-lg font-bold text-gray-900">
                                {{ optional($peminjaman->tgl_pinjam)->format('d M Y') ?? '-' }}
                                <span class="text-gray-400 font-normal mx-1">&rarr;</span>
                                {{ optional($peminjaman->tgl_kembali_plan)->format('d M Y') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $badgeClass }} flex-shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                        {{ $label }}
                    </span>
                </div>

                <div class="pl-0 sm:pl-14">
                    <p class="text-xs uppercase tracking-wider text-gray-400 mb-2 font-semibold">Alat Dipinjam</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @forelse($peminjaman->detailPinjam as $detail)
                            <span class="inline-flex items-center gap-1.5 text-sm bg-blue-50 text-blue-700 rounded-full px-3 py-1.5 border border-blue-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                {{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                                <span class="text-blue-400 font-semibold">×{{ $detail->jumlah }}</span>
                            </span>
                        @empty
                            <span class="text-sm text-gray-400">-</span>
                        @endforelse
                    </div>

                    @if($peminjaman->status === 'dikembalikan')
                        <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                            <span class="text-sm text-gray-500 font-medium">Denda</span>
                            <span class="text-sm font-bold {{ $denda > 0 ? 'text-red-600' : 'text-gray-700' }}">
                                Rp {{ number_format($denda ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-12 text-center">
                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">Belum ada riwayat peminjaman</p>
                <p class="text-sm text-gray-400 mt-1">Ajukan peminjaman alat dari halaman Katalog.</p>
            </div>
        @endforelse
    </div>

@endsection