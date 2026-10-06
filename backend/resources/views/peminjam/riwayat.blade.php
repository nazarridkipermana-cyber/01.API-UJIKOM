@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman - Peminjam')

@section('content')

    <div class="mb-8">
        <div class="font-mono text-xs text-[#706B5C] mb-1">riwayat</div>
        <h1 class="font-display text-2xl font-semibold text-[#1B1F27]">Riwayat & Pengembalian Alat</h1>
        <p class="text-sm text-[#706B5C] mt-1 font-mono">{{ $peminjamans->count() }} total peminjaman</p>
    </div>

    <div class="space-y-3">
        @forelse($peminjamans as $peminjaman)
            @php
                $badgeMap = [
                    'diajukan'     => ['Diajukan', 'text-[#A9792F]', 'border-l-[#A9792F]'],
                    'dipinjam'     => ['Sedang Dipinjam', 'text-[#3B6E71]', 'border-l-[#3B6E71]'],
                    'dikembalikan' => ['Dikembalikan', 'text-[#3F7D58]', 'border-l-[#3F7D58]'],
                ];
                [$label, $textClass, $borderClass] = $badgeMap[$peminjaman->status] ?? [ucfirst($peminjaman->status), 'text-[#706B5C]', 'border-l-[#E5E1D6]'];
                $denda = optional($peminjaman->pengembalian)->denda;
            @endphp

            <div class="bg-white rounded-md border border-[#E5E1D6] border-l-2 {{ $borderClass }} p-6 hover:bg-[#FAF9F6] transition">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-md bg-[#14181F] text-white flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-[#706B5C] font-mono">Peminjaman #{{ $peminjaman->id }}</p>
                            <p class="font-display text-lg font-semibold text-[#1B1F27] font-mono">
                                {{ optional($peminjaman->tgl_pinjam)->format('d M Y') ?? '-' }}
                                <span class="text-[#706B5C] font-normal mx-1">&rarr;</span>
                                {{ optional($peminjaman->tgl_kembali_plan)->format('d M Y') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <span class="inline-flex items-center gap-1.5 text-xs font-mono {{ $textClass }} flex-shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        {{ $label }}
                    </span>
                </div>

                <div class="pl-0 sm:pl-13">
                    <p class="text-xs text-[#706B5C] mb-2">Alat dipinjam</p>
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @forelse($peminjaman->detailPinjam as $detail)
                            <span class="inline-flex items-center gap-1.5 text-xs bg-[#F3F1EC] text-[#1B1F27] rounded px-2.5 py-1 font-mono">
                                {{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                                <span class="text-[#706B5C]">×{{ $detail->jumlah }}</span>
                            </span>
                        @empty
                            <span class="text-sm text-[#706B5C]">-</span>
                        @endforelse
                    </div>

                    @if($peminjaman->status === 'dikembalikan')
                        <div class="flex items-center justify-between bg-[#F9F8F5] rounded-md px-4 py-3 border border-[#E5E1D6]">
                            <span class="text-sm text-[#706B5C]">Denda</span>
                            <span class="text-sm font-mono font-medium {{ $denda > 0 ? 'text-[#B23A2E]' : 'text-[#1B1F27]' }}">
                                Rp {{ number_format($denda ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-md border border-[#E5E1D6] p-12 text-center">
                <svg class="w-10 h-10 text-[#E5E1D6] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                </svg>
                <p class="text-[#1B1F27] font-medium">Belum ada riwayat peminjaman</p>
                <p class="text-sm text-[#706B5C] mt-1">Ajukan peminjaman alat dari halaman katalog.</p>
            </div>
        @endforelse
    </div>

@endsection