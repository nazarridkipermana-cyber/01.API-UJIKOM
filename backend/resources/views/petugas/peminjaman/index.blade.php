@extends('layouts.petugas')

@section('title', 'Persetujuan Peminjaman - Dashboard Petugas')

@section('content')

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Daftar Pengajuan Peminjaman Alat</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Menunggu Verifikasi Persetujuan</h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $peminjamans->where('status', 'diajukan')->count() }} pengajuan menunggu persetujuan kamu
                </p>
            </div>

            <form action="{{ route('petugas.peminjaman.index') }}" method="GET" class="flex w-full md:w-96">
                <div class="relative flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam..."
                        class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-gray-900">
                </div>
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold px-5 rounded-r-lg transition">
                    Cari
                </button>
            </form>
        </div>

        <div class="p-6 space-y-4">
            @forelse($peminjamans as $item)
                <div class="border border-gray-200 rounded-xl p-5 hover:border-gray-300 transition">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-5">

                        {{-- Peminjam --}}
                        <div class="flex items-center gap-3 lg:w-56 shrink-0">
                            <div class="w-11 h-11 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">
                                {{ strtoupper(substr($item->user->name ?? '-', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $item->user->name ?? 'User Dihapus' }}</div>
                                <span class="inline-flex items-center gap-1 text-xs mt-0.5
                                    @if($item->status == 'diajukan') text-amber-600
                                    @elseif($item->status == 'dipinjam') text-blue-600
                                    @elseif($item->status == 'dikembalikan') text-emerald-600
                                    @else text-red-600 @endif">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                        </div>

                        {{-- Detail alat & tanggal --}}
                        <div class="flex-1 grid sm:grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Alat Diajukan</div>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($item->detailPinjam as $detail)
                                        <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-xs px-2.5 py-1 rounded-full">
                                            {{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                                            <span class="font-semibold">x{{ $detail->jumlah }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 space-y-1">
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
                        <div class="lg:w-48 shrink-0 flex lg:justify-end">
                            @if($item->status == 'diajukan')
                                <form action="{{ route('petugas.peminjaman.setujui', $item->id) }}" method="POST" class="w-full lg:w-auto"
                                    onsubmit="return confirm('Setujui peminjaman ini?')">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Setujui
                                    </button>
                                </form>

                            @elseif($item->status == 'dipinjam')
                                <button type="button"
                                    class="w-full lg:w-auto flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition"
                                    onclick="document.getElementById('modalKembali{{ $item->id }}').classList.remove('hidden')">
                                    Proses Pengembalian
                                </button>

                                {{-- Modal Pengembalian (Tailwind manual, tanpa Bootstrap) --}}
                                <div id="modalKembali{{ $item->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                                    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
                                        <form action="{{ route('petugas.pengembalian.proses', $item->id) }}" method="POST">
                                            @csrf
                                            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                                                <h5 class="font-bold text-gray-900">Proses Pengembalian — {{ $item->user->name ?? '-' }}</h5>
                                                <button type="button" onclick="document.getElementById('modalKembali{{ $item->id }}').classList.add('hidden')"
                                                    class="text-gray-400 hover:text-gray-600">&times;</button>
                                            </div>
                                            <div class="p-5 space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kondisi Alat Saat Kembali</label>
                                                    <select name="kondisi_kembali" required
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                                                        <option value="Baik">✅ Baik</option>
                                                        <option value="Rusak Ringan">⚠️ Rusak Ringan</option>
                                                        <option value="Rusak Berat">❌ Rusak Berat</option>
                                                        <option value="Hilang">🚫 Hilang</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Denda (Opsional)</label>
                                                    <input type="number" name="denda" min="0" placeholder="0"
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                                                </div>
                                            </div>
                                            <div class="p-5 border-t border-gray-100 flex justify-end gap-2">
                                                <button type="button" onclick="document.getElementById('modalKembali{{ $item->id }}').classList.add('hidden')"
                                                    class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition">Batal</button>
                                                <button type="submit"
                                                    class="px-4 py-2 text-sm font-semibold bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition">
                                                    Terima Pengembalian
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            @elseif($item->status == 'dikembalikan')
                                <span class="text-sm text-gray-400">Sudah Dikembalikan</span>
                            @else
                                <span class="text-sm text-red-500 font-medium">{{ ucfirst($item->status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div class="font-semibold text-gray-600">Tidak ada pengajuan peminjaman baru</div>
                    <div class="text-sm text-gray-400 mt-1">Semua pengajuan sudah diproses</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection