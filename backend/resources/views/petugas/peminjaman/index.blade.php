@extends('layouts.petugas')

@section('title', 'Persetujuan Peminjaman - Dashboard Petugas')

@section('content')

    <div class="mb-8">
        <div class="font-mono text-xs text-[#706B5C] mb-1">persetujuan</div>
        <h1 class="font-display text-2xl font-semibold text-[#1B1F27]">Daftar Pengajuan Peminjaman Alat</h1>
    </div>

    <div class="bg-white rounded-lg border border-[#E5E1D6]">

        <div class="p-6 border-b border-[#E5E1D6] flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display text-lg font-semibold text-[#1B1F27]">Menunggu verifikasi persetujuan</h2>
                <p class="text-sm text-[#706B5C] mt-1 font-mono">
                    {{ $peminjamans->where('status', 'diajukan')->count() }} pengajuan menunggu persetujuan kamu
                </p>
            </div>

            <form action="{{ route('petugas.peminjaman.index') }}" method="GET" class="flex w-full md:w-96">
                <div class="relative flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#706B5C] absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam..."
                        class="w-full pl-9 pr-3 py-2.5 text-sm border border-[#E5E1D6] rounded-l-md focus:outline-none focus:ring-1 focus:ring-[#C98A3B] focus:border-[#C98A3B] bg-[#F9F8F5]">
                </div>
                <button type="submit" class="bg-[#14181F] hover:bg-[#232A38] text-white text-sm font-medium px-5 rounded-r-md transition">
                    Cari
                </button>
            </form>
        </div>

        <div class="p-6 space-y-3">
            @forelse($peminjamans as $item)
                @php
                    $statusColor = [
                        'diajukan'     => ['border' => 'border-[#A9792F]', 'text' => 'text-[#A9792F]'],
                        'dipinjam'     => ['border' => 'border-[#3B6E71]', 'text' => 'text-[#3B6E71]'],
                        'dikembalikan' => ['border' => 'border-[#3F7D58]', 'text' => 'text-[#3F7D58]'],
                    ][$item->status] ?? ['border' => 'border-[#B23A2E]', 'text' => 'text-[#B23A2E]'];
                @endphp
                <div class="border border-[#E5E1D6] border-l-2 {{ $statusColor['border'] }} rounded-md p-5 hover:bg-[#FAF9F6] transition">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-5">

                        {{-- Peminjam --}}
                        <div class="flex items-center gap-3 lg:w-56 shrink-0">
                            <div class="w-10 h-10 rounded-full bg-[#14181F] text-white flex items-center justify-center font-display font-semibold text-sm flex-shrink-0">
                                {{ strtoupper(substr($item->user->name ?? '-', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-medium text-[#1B1F27]">{{ $item->user->name ?? 'User Dihapus' }}</div>
                                <span class="inline-flex items-center gap-1.5 text-xs mt-0.5 font-mono {{ $statusColor['text'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                        </div>

                        {{-- Detail alat & tanggal --}}
                        <div class="flex-1 grid sm:grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs text-[#706B5C] mb-1.5">Alat diajukan</div>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($item->detailPinjam as $detail)
                                        <span class="inline-flex items-center gap-1 bg-[#F3F1EC] text-[#1B1F27] text-xs px-2.5 py-1 rounded font-mono">
                                            {{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                                            <span class="text-[#706B5C]">×{{ $detail->jumlah }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-sm text-[#706B5C] space-y-1 font-mono">
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
                                        class="w-full flex items-center justify-center gap-2 bg-[#C98A3B] hover:bg-[#B67927] text-white text-sm font-medium px-4 py-2.5 rounded-md transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Setujui
                                    </button>
                                </form>

                            @elseif($item->status == 'dipinjam')
                                <button type="button"
                                    class="w-full lg:w-auto flex items-center justify-center gap-2 bg-[#3B6E71] hover:bg-[#2E5658] text-white text-sm font-medium px-4 py-2.5 rounded-md transition"
                                    onclick="document.getElementById('modalKembali{{ $item->id }}').classList.remove('hidden')">
                                    Proses pengembalian
                                </button>

                                {{-- Modal Pengembalian --}}
                                <div id="modalKembali{{ $item->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-[#14181F]/60 p-4">
                                    <div class="bg-white rounded-lg w-full max-w-md">
                                        <form action="{{ route('petugas.pengembalian.proses', $item->id) }}" method="POST">
                                            @csrf
                                            <div class="p-5 border-b border-[#E5E1D6] flex items-center justify-between">
                                                <h5 class="font-display font-semibold text-[#1B1F27]">Proses pengembalian — {{ $item->user->name ?? '-' }}</h5>
                                                <button type="button" onclick="document.getElementById('modalKembali{{ $item->id }}').classList.add('hidden')"
                                                    class="text-[#706B5C] hover:text-[#1B1F27]">&times;</button>
                                            </div>
                                            <div class="p-5 space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-[#1B1F27] mb-1.5">Kondisi alat saat kembali</label>
                                                    <select name="kondisi_kembali" required
                                                        class="w-full border border-[#E5E1D6] rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#C98A3B]">
                                                        <option value="Baik">Baik</option>
                                                        <option value="Rusak Ringan">Rusak ringan</option>
                                                        <option value="Rusak Berat">Rusak berat</option>
                                                        <option value="Hilang">Hilang</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-[#1B1F27] mb-1.5">Denda (opsional)</label>
                                                    <input type="number" name="denda" min="0" placeholder="0"
                                                        class="w-full border border-[#E5E1D6] rounded-md px-3 py-2 text-sm font-mono focus:outline-none focus:ring-1 focus:ring-[#C98A3B]">
                                                </div>
                                            </div>
                                            <div class="p-5 border-t border-[#E5E1D6] flex justify-end gap-2">
                                                <button type="button" onclick="document.getElementById('modalKembali{{ $item->id }}').classList.add('hidden')"
                                                    class="px-4 py-2 text-sm font-medium text-[#706B5C] hover:bg-[#F3F1EC] rounded-md transition">Batal</button>
                                                <button type="submit"
                                                    class="px-4 py-2 text-sm font-medium bg-[#C98A3B] hover:bg-[#B67927] text-white rounded-md transition">
                                                    Terima pengembalian
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            @elseif($item->status == 'dikembalikan')
                                <span class="text-sm text-[#706B5C] font-mono">Sudah dikembalikan</span>
                            @else
                                <span class="text-sm text-[#B23A2E] font-medium">{{ ucfirst($item->status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-[#E5E1D6] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div class="font-medium text-[#1B1F27]">Tidak ada pengajuan peminjaman baru</div>
                    <div class="text-sm text-[#706B5C] mt-1">Semua pengajuan sudah diproses</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection