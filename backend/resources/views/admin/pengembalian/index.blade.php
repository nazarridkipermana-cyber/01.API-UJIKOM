@extends('layouts.app')

@section('title', 'Kelola Pengembalian - Panel Admin')
@section('header-title', 'Manajemen Pengembalian')

@section('content')

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @php
        $jumlahAktif = $peminjamanAktif->count();
        $jumlahTelat = $peminjamanAktif->filter(function ($p) {
            return $p->status === 'telat'
                || ($p->tgl_kembali_plan && now()->startOfDay()->gt(\Carbon\Carbon::parse($p->tgl_kembali_plan)->startOfDay()));
        })->count();
    @endphp

    {{-- Ringkasan cepat --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <p class="text-3xl font-bold text-gray-900">{{ $jumlahAktif }}</p>
            <p class="text-sm text-gray-500 mt-1">Peminjaman aktif</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 border-l-4 border-l-red-500 p-5">
            <p class="text-3xl font-bold text-red-600">{{ $jumlahTelat }}</p>
            <p class="text-sm text-gray-500 mt-1">Terlambat</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <p class="text-3xl font-bold text-gray-900">{{ $pengembalians->total() }}</p>
            <p class="text-sm text-gray-500 mt-1">Total riwayat pengembalian</p>
        </div>
    </div>

    {{-- Peminjaman aktif (menunggu dikembalikan) --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm mb-6">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Peminjaman aktif</h3>
            <p class="text-sm text-gray-500">Alat yang masih dipinjam dan menunggu pengembalian</p>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($peminjamanAktif as $p)
                @php
                    $isTelat = $p->status === 'telat'
                        || ($p->tgl_kembali_plan && now()->startOfDay()->gt(\Carbon\Carbon::parse($p->tgl_kembali_plan)->startOfDay()));
                @endphp
                <div class="p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-4 {{ $isTelat ? 'border-l-4 border-red-500' : '' }}">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $p->user->name ?? '-' }}</p>
                        <p class="text-sm text-gray-500">
                            Rencana kembali:
                            {{ $p->tgl_kembali_plan ? \Carbon\Carbon::parse($p->tgl_kembali_plan)->format('d M Y') : '-' }}
                            @if($isTelat)
                                <span class="ml-2 inline-block rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">Terlambat</span>
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('admin.pengembalian.create', $p->id) }}"
                       class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
                        Proses pengembalian
                    </a>
                </div>
            @empty
                <div class="p-8 text-center text-sm text-gray-500">Tidak ada peminjaman aktif saat ini.</div>
            @endforelse
        </div>
    </div>

    {{-- Riwayat pengembalian --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Riwayat pengembalian</h3>

            <form method="GET" action="{{ route('admin.pengembalian.index') }}" class="mt-3 flex flex-col sm:flex-row gap-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari peminjam, petugas, atau kondisi..."
                       class="w-full sm:w-72 rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">

                <select name="bulan" class="rounded-md border border-gray-300 px-3 py-2 text-sm">
                    <option value="">Semua bulan</option>
                    @foreach($bulanList as $b)
                        <option value="{{ $b }}" {{ $bulan === $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $b)->translatedFormat('F Y') }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">Cari</button>

                @if($search || $bulan)
                    <a href="{{ route('admin.pengembalian.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-center text-sm text-gray-700 hover:bg-gray-100">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase text-gray-500">
                    <tr>
                        <th class="px-5 py-3">Peminjam</th>
                        <th class="px-5 py-3">Alat</th>
                        <th class="px-5 py-3">Tgl kembali</th>
                        <th class="px-5 py-3">Kondisi</th>
                        <th class="px-5 py-3">Denda</th>
                        <th class="px-5 py-3">Petugas</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pengembalians as $item)
                        <tr>
                            <td class="px-5 py-3 font-medium text-gray-900">
                                {{ $item->peminjaman->user->name ?? '-' }}
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                @forelse(($item->peminjaman->detailPinjam ?? []) as $detail)
                                    <div>{{ $detail->alat->nama_alat ?? '-' }} <span class="text-gray-400">x{{ $detail->jumlah }}</span></div>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $item->kondisi_kembali }}</td>
                            <td class="px-5 py-3 {{ $item->denda > 0 ? 'text-red-600 font-medium' : 'text-gray-600' }}">
                                Rp{{ number_format($item->denda, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $item->petugas->name ?? '-' }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.pengembalian.edit', $item->id) }}"
                                       class="rounded-md border border-gray-300 px-3 py-1 text-xs text-gray-700 hover:bg-gray-100">Edit</a>

                                    <form method="POST" action="{{ route('admin.pengembalian.destroy', $item->id) }}"
                                          onsubmit="return confirm('Hapus data pengembalian ini? Stok dan status peminjaman akan dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-md border border-red-200 px-3 py-1 text-xs text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-gray-500">Belum ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengembalians->hasPages())
            <div class="px-5 py-4 border-t border-gray-200">
                {{ $pengembalians->links() }}
            </div>
        @endif
    </div>

@endsection