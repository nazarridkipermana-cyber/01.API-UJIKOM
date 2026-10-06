@extends('layouts.app')

@section('title', 'Kelola Peminjaman - Panel Admin')
@section('header-title', 'Manajemen Peminjaman')

@section('content')

    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">

        <div class="p-5 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Daftar Peminjaman Alat</h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $peminjamans->where('status', 'diajukan')->count() }} pengajuan menunggu persetujuan
                    &middot; {{ $totalSelesai }} selesai &middot; {{ $totalTelat }} telat
                    &middot; Total denda: Rp{{ number_format($totalDenda, 0, ',', '.') }}
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="flex w-full md:w-96">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam / status..."
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 text-sm font-semibold rounded-r-lg transition">
                        Cari
                    </button>
                </form>

                <a href="{{ route('admin.peminjaman.create') }}"
                    class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm font-semibold rounded-lg transition whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Peminjaman
                </a>
            </div>
        </div>

        <div class="p-6 space-y-3">
            @forelse($peminjamans as $item)
                @php
                    $statusColor = [
                        'diajukan'     => ['border' => 'border-amber-500', 'text' => 'text-amber-700'],
                        'dipinjam'     => ['border' => 'border-sky-600',   'text' => 'text-sky-700'],
                        'dikembalikan' => ['border' => 'border-emerald-600', 'text' => 'text-emerald-700'],
                    ][$item->status] ?? ['border' => 'border-red-500', 'text' => 'text-red-600'];
                @endphp
                <div class="border border-gray-200 border-l-4 {{ $statusColor['border'] }} rounded-lg p-5 hover:bg-gray-50 transition">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-5">

                        {{-- Peminjam --}}
                        <div class="flex items-center gap-3 lg:w-56 shrink-0">
                            <div class="w-10 h-10 rounded-full bg-gray-800 text-white flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                {{ strtoupper(substr($item->user->name ?? '-', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $item->user->name ?? 'User Dihapus' }}</div>
                                <span class="inline-flex items-center gap-1.5 text-xs mt-0.5 {{ $statusColor['text'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                        </div>

                        {{-- Detail alat & tanggal --}}
                        <div class="flex-1 grid sm:grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs text-gray-500 mb-1.5">Alat diajukan</div>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($item->detailPinjam as $detail)
                                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-800 text-xs pl-1 pr-2.5 py-1 rounded">
                                            <span class="w-5 h-5 rounded-sm bg-white border border-gray-200 overflow-hidden flex items-center justify-center flex-shrink-0">
                                                @if($detail->alat && $detail->alat->gambar)
                                                    <img src="{{ asset($detail->alat->gambar) }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16v12H4V6z" />
                                                    </svg>
                                                @endif
                                            </span>
                                            {{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                                            <span class="text-gray-500">×{{ $detail->jumlah }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 space-y-1">
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Pinjam: {{ $item->tgl_pinjam }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Kembali: {{ $item->tgl_kembali_plan }}
                                </div>
                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="lg:w-48 shrink-0 flex lg:justify-end gap-2">
                            @if($item->status == 'diajukan')
                                <form action="{{ route('admin.peminjaman.updateStatus', $item->id) }}" method="POST" class="w-full lg:w-auto"
                                    onsubmit="return confirm('Setujui peminjaman ini?')">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="dipinjam">
                                    <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Setujui
                                    </button>
                                </form>

                            @elseif($item->status == 'dipinjam' || $item->status == 'telat')
                                <a href="{{ route('admin.pengembalian.create', $item->id) }}"
                                    class="w-full lg:w-auto flex items-center justify-center gap-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                                    Proses pengembalian
                                </a>

                            @elseif($item->status == 'dikembalikan')
                                <span class="text-sm text-gray-500">Sudah dikembalikan</span>
                            @else
                                <span class="text-sm text-red-600 font-medium">{{ ucfirst($item->status) }}</span>
                            @endif

                            <form action="{{ route('admin.peminjaman.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-500 hover:text-red-700 px-2 py-2.5" title="Hapus">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div class="font-medium text-gray-900">Tidak ada data peminjaman</div>
                    <div class="text-sm text-gray-500 mt-1">Belum ada pengajuan peminjaman masuk</div>
                </div>
            @endforelse
        </div>

        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $peminjamans->links() }}
        </div>
    </div>
@endsection