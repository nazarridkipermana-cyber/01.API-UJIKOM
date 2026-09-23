@extends('layouts.petugas')

@section('title', 'Laporan Peminjaman - Dashboard Petugas')
@section('header-title', 'Laporan Peminjaman & Pengembalian Alat')

@section('content')

    <div class="mb-8">
        <div class="font-mono text-xs text-[#706B5C] mb-1">rekap</div>
        <h1 class="font-display text-2xl font-semibold text-[#1B1F27]">Laporan Peminjaman & Pengembalian Alat</h1>
    </div>

    {{-- Ringkasan cepat --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-[#E5E1D6] p-5">
            <p class="font-display text-2xl font-semibold text-[#1B1F27]">{{ $peminjamans->count() }}</p>
            <p class="text-sm text-[#706B5C] mt-1">Total peminjaman</p>
        </div>
        <div class="bg-white rounded-lg border border-[#E5E1D6] p-5">
            <p class="font-display text-2xl font-semibold text-[#3F7D58]">{{ $totalSelesai }}</p>
            <p class="text-sm text-[#706B5C] mt-1">Selesai</p>
        </div>
        <div class="bg-white rounded-lg border border-[#E5E1D6] p-5">
            <p class="font-display text-2xl font-semibold text-[#B23A2E]">{{ $totalTelat }}</p>
            <p class="text-sm text-[#706B5C] mt-1">Telat</p>
        </div>
        <div class="bg-white rounded-lg border border-[#E5E1D6] p-5">
            <p class="font-display text-2xl font-semibold text-[#1B1F27] font-mono">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
            <p class="text-sm text-[#706B5C] mt-1">Total denda</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-lg border border-[#E5E1D6] mb-6">
        <div class="p-5 border-b border-[#E5E1D6]">
            <h3 class="font-display text-lg font-semibold text-[#1B1F27]">Filter laporan</h3>
            <p class="text-sm text-[#706B5C]">Saring data berdasarkan status dan rentang tanggal pinjam</p>
        </div>
        <form action="{{ route('petugas.laporan.index') }}" method="GET" class="p-5 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-[#706B5C] mb-1">Status peminjaman</label>
                <select name="status" class="w-full text-sm border border-[#E5E1D6] rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-[#C98A3B]">
                    <option value="semua">Semua status</option>
                    <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-[#706B5C] mb-1">Dari tanggal (pinjam)</label>
                <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}"
                    class="w-full text-sm font-mono border border-[#E5E1D6] rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#C98A3B]">
            </div>
            <div>
                <label class="block text-xs font-medium text-[#706B5C] mb-1">Sampai tanggal (pinjam)</label>
                <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}"
                    class="w-full text-sm font-mono border border-[#E5E1D6] rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#C98A3B]">
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-[#14181F] hover:bg-[#232A38] text-white px-4 py-2 text-sm font-medium rounded-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('petugas.laporan.index') }}"
                    class="bg-[#F3F1EC] hover:bg-[#E5E1D6] text-[#706B5C] px-3 py-2 text-sm rounded-md transition flex items-center justify-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel Hasil & Tombol Cetak --}}
    <div class="bg-white rounded-lg border border-[#E5E1D6] overflow-hidden">
        <div class="p-5 border-b border-[#E5E1D6] flex flex-col sm:flex-row justify-between sm:items-center gap-3">
            <div>
                <h3 class="font-display text-lg font-semibold text-[#1B1F27]">Hasil rekap laporan</h3>
                <p class="text-sm text-[#706B5C] font-mono">{{ $peminjamans->count() }} data ditemukan</p>
            </div>
            <a href="{{ route('petugas.laporan.cetak', request()->all()) }}" target="_blank"
                class="bg-[#C98A3B] hover:bg-[#B67927] text-white px-4 py-2.5 text-sm font-medium rounded-md transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a1 1 0 001-1v-4H8v4a1 1 0 001 1zm8-10V5a1 1 0 00-1-1H8a1 1 0 00-1 1v4h10z"/>
                </svg>
                Cetak / print laporan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F9F8F5] text-[#706B5C] text-xs">
                        <th class="py-3 px-4 border-b border-[#E5E1D6] font-medium">No</th>
                        <th class="py-3 px-4 border-b border-[#E5E1D6] font-medium">Peminjam</th>
                        <th class="py-3 px-4 border-b border-[#E5E1D6] font-medium">Tgl pinjam</th>
                        <th class="py-3 px-4 border-b border-[#E5E1D6] font-medium">Rencana kembali</th>
                        <th class="py-3 px-4 border-b border-[#E5E1D6] font-medium">Status</th>
                        <th class="py-3 px-4 border-b border-[#E5E1D6] font-medium">Detail alat</th>
                        <th class="py-3 px-4 border-b border-[#E5E1D6] font-medium text-right">Denda</th>
                    </tr>
                </thead>
                <tbody class="text-[#1B1F27] text-sm">
                    @forelse($peminjamans as $index => $item)
                        @php
                            $isTelat = $item->status === 'dipinjam' && $item->tgl_kembali_plan && now()->gt($item->tgl_kembali_plan);

                            $badgeMap = [
                                'dikembalikan' => 'text-[#3F7D58]',
                                'dipinjam'     => 'text-[#3B6E71]',
                                'diajukan'     => 'text-[#A9792F]',
                            ];
                            $badgeClass = $badgeMap[$item->status] ?? 'text-[#706B5C]';

                            if ($isTelat) {
                                $badgeClass = 'text-[#B23A2E]';
                            }

                            $denda = optional($item->pengembalian)->denda ?? 0;
                        @endphp
                        <tr class="hover:bg-[#FAF9F6] transition align-top">
                            <td class="py-3 px-4 border-b border-[#E5E1D6] text-[#706B5C] font-mono">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 border-b border-[#E5E1D6]">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-[#14181F] text-white flex items-center justify-center text-xs font-display font-semibold flex-shrink-0">
                                        {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="font-medium">{{ $item->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 border-b border-[#E5E1D6] font-mono">{{ optional($item->tgl_pinjam)->format('d-m-Y') ?? '-' }}</td>
                            <td class="py-3 px-4 border-b border-[#E5E1D6] font-mono">{{ optional($item->tgl_kembali_plan)->format('d-m-Y') ?? '-' }}</td>
                            <td class="py-3 px-4 border-b border-[#E5E1D6]">
                                <span class="inline-flex items-center gap-1.5 text-xs font-mono {{ $badgeClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ $isTelat ? 'Telat' : ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 border-b border-[#E5E1D6]">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($item->detailPinjam as $detail)
                                        <span class="text-xs bg-[#F3F1EC] text-[#1B1F27] rounded px-2 py-0.5 font-mono">
                                            {{ $detail->alat->nama_alat ?? '-' }} <span class="text-[#706B5C]">×{{ $detail->jumlah }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3 px-4 border-b border-[#E5E1D6] text-right font-mono font-medium {{ $denda > 0 ? 'text-[#B23A2E]' : 'text-[#706B5C]' }}">
                                Rp {{ number_format($denda, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <svg class="w-10 h-10 text-[#E5E1D6] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                                    </svg>
                                    <p class="text-[#1B1F27] font-medium">Tidak ada data laporan yang sesuai filter</p>
                                    <p class="text-sm text-[#706B5C] mt-1">Coba ubah status atau rentang tanggal pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection