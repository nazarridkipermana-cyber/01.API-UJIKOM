@extends('layouts.app')

@section('title', 'Kelola Peminjaman - Dashboard Admin')

@section('content')

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Laporan Peminjaman & Pengembalian Alat</h1>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $totalSelesai }}</div>
                <div class="text-sm text-gray-500">Selesai</div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $totalTelat }}</div>
                <div class="text-sm text-gray-500">Telat</div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 10v2" />
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                <div class="text-sm text-gray-500">Total Denda</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center gap-2 mb-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <h2 class="text-lg font-bold text-gray-900">Filter Laporan</h2>
        </div>
        <p class="text-sm text-gray-500 mb-4">Saring data berdasarkan status dan rentang tanggal pinjam</p>

        <form method="GET" class="grid sm:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Peminjaman</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                    <option value="semua" {{ request('status', 'semua') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Dari Tanggal (Pinjam)</label>
                <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Sampai Tanggal (Pinjam)</label>
                <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                    🔍 Filter
                </button>
                <a href="{{ route('petugas.laporan.index') }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200" id="area-print">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Hasil Rekap Laporan</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $peminjamans->count() }} data ditemukan</p>
            </div>
            <button onclick="window.print()" type="button"
                class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition no-print">
                🖨️ Cetak / Print Laporan
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="py-3 px-6 border-b border-gray-100">No</th>
                        <th class="py-3 px-6 border-b border-gray-100">Peminjam</th>
                        <th class="py-3 px-6 border-b border-gray-100">Tgl Pinjam</th>
                        <th class="py-3 px-6 border-b border-gray-100">Rencana Kembali</th>
                        <th class="py-3 px-6 border-b border-gray-100">Status</th>
                        <th class="py-3 px-6 border-b border-gray-100">Detail Alat</th>
                        <th class="py-3 px-6 border-b border-gray-100 text-right">Denda</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse($peminjamans as $i => $item)
                        <tr class="hover:bg-gray-50 transition align-top">
                            <td class="py-4 px-6 border-b border-gray-100">{{ $i + 1 }}</td>
                            <td class="py-4 px-6 border-b border-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gray-800 text-white flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($item->user->name ?? '-', 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $item->user->name ?? 'User Dihapus' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 border-b border-gray-100">{{ $item->tgl_pinjam }}</td>
                            <td class="py-4 px-6 border-b border-gray-100">{{ $item->tgl_kembali_plan }}</td>
                            <td class="py-4 px-6 border-b border-gray-100">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    @if($item->status == 'diajukan') bg-amber-100 text-amber-700
                                    @elseif($item->status == 'dipinjam') bg-blue-100 text-blue-700
                                    @elseif($item->status == 'dikembalikan') bg-emerald-100 text-emerald-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ $item->status == 'dikembalikan' ? 'Selesai' : ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 border-b border-gray-100">
                                @foreach($item->detailPinjam as $detail)
                                    <div>{{ $detail->alat->nama_alat ?? 'Alat' }} x{{ $detail->jumlah }}</div>
                                @endforeach
                            </td>
                            <td class="py-4 px-6 border-b border-gray-100 text-right font-semibold {{ optional($item->pengembalian)->denda > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                Rp {{ number_format(optional($item->pengembalian)->denda ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-400">
                                Tidak ada data pada periode ini. Coba ubah status atau rentang tanggal pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        @media print {
            aside, .no-print, form { display: none !important; }
            #area-print { border: none !important; box-shadow: none !important; }
            body { background: white !important; }
        }
    </style>
@endsection