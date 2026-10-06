@extends('layouts.petugas')

@section('title', 'Kelola Pengembalian - Panel Petugas')

@section('content')

    {{-- Judul halaman (notifikasi success/error sudah ditampilkan oleh layout) --}}
    <div class="mb-8">
        <div class="font-mono text-xs tracking-[0.25em] uppercase text-[#8f0000] mb-1">Pemantauan</div>
        <h1 class="font-display text-3xl font-bold text-[#0b0b0d]">Pemantauan Pengembalian Alat</h1>
        <div class="mt-3 flex h-1 w-16 overflow-hidden rounded-full">
            <span class="flex-1 bg-black"></span>
            <span class="flex-1 bg-[#d00000]"></span>
            <span class="flex-1 bg-[#ffce00]"></span>
        </div>
    </div>

    {{-- Ringkasan cepat --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">

        {{-- Peminjaman aktif --}}
        <div class="relative overflow-hidden bg-white rounded-xl border border-[#e7e3d8] p-5 shadow-sm hover:shadow-lg transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="font-display text-4xl font-bold text-[#0b0b0d] leading-none">{{ $totalAktif }}</p>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-[#706B5C] mt-3">Peminjaman aktif</p>
                </div>
                <span class="w-11 h-11 rounded-xl bg-[#0b0b0d] text-[#ffce00] flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2M9 2h6v4H9z" />
                    </svg>
                </span>
            </div>
            <span class="absolute bottom-0 inset-x-0 h-1 bg-[#0b0b0d]"></span>
        </div>

        {{-- Terlambat (menyala merah jika > 0) --}}
        @if($totalTerlambat > 0)
            <div class="relative overflow-hidden rounded-xl p-5 shadow-lg shadow-red-900/25 bg-gradient-to-br from-[#d00000] to-[#8f0000] text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-display text-4xl font-bold leading-none">{{ $totalTerlambat }}</p>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-white/80 mt-3">Terlambat</p>
                    </div>
                    <span class="w-11 h-11 rounded-xl bg-white/15 text-[#ffce00] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                    </span>
                </div>
                <span class="absolute bottom-0 inset-x-0 h-1 bg-[#ffce00]"></span>
            </div>
        @else
            <div class="relative overflow-hidden bg-white rounded-xl border border-[#e7e3d8] p-5 shadow-sm hover:shadow-lg transition">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-display text-4xl font-bold text-[#d00000] leading-none">{{ $totalTerlambat }}</p>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-[#706B5C] mt-3">Terlambat</p>
                    </div>
                    <span class="w-11 h-11 rounded-xl bg-[#fdecec] text-[#d00000] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <span class="absolute bottom-0 inset-x-0 h-1 bg-[#d00000]"></span>
            </div>
        @endif

        {{-- Total unit --}}
        <div class="relative overflow-hidden bg-white rounded-xl border border-[#e7e3d8] p-5 shadow-sm hover:shadow-lg transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="font-display text-4xl font-bold text-[#0b0b0d] leading-none">{{ $totalUnit }}</p>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-[#706B5C] mt-3">Total unit dipinjam</p>
                </div>
                <span class="w-11 h-11 rounded-xl bg-[#fff6d1] text-[#7a5c00] flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </span>
            </div>
            <span class="absolute bottom-0 inset-x-0 h-1 bg-[#ffce00]"></span>
        </div>
    </div>

    {{-- Daftar peminjaman aktif --}}
    <div class="bg-white rounded-xl border border-[#e7e3d8]">

        {{-- Header panel + pencarian --}}
        <div class="p-6 border-b border-[#e7e3d8] flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="font-display text-lg font-semibold text-[#0b0b0d]">Daftar peminjaman aktif</h3>
                <p class="text-sm text-[#706B5C] mt-1">Alat yang masih dipinjam dan menunggu pengembalian</p>
            </div>

            <form action="{{ route('petugas.pengembalian.index') }}" method="GET" class="flex w-full md:w-96">
                <div class="relative flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#706B5C] absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam..."
                        class="w-full pl-9 pr-3 py-2.5 text-sm border border-[#e7e3d8] rounded-l-lg bg-[#faf8f3] focus:outline-none focus:border-[#d00000] focus:ring-2 focus:ring-[#d00000]/15">
                </div>
                <button type="submit" class="bg-[#0b0b0d] hover:bg-[#1c1c22] text-[#ffce00] text-sm font-semibold tracking-wide px-5 rounded-r-lg transition">
                    Cari
                </button>
            </form>
        </div>

        <div class="p-6 space-y-3">
            @forelse($peminjamans as $item)
                @php
                    $isTelat = $item->tgl_kembali_plan && now()->gt($item->tgl_kembali_plan);
                    $hariTelat = $isTelat
                        ? abs((int) \Carbon\Carbon::parse($item->tgl_kembali_plan)->diffInDays(now()))
                        : 0;
                @endphp

                <div class="border border-[#e7e3d8] border-l-4 {{ $isTelat ? 'border-l-[#d00000] bg-[#fffafa]' : 'border-l-[#ffce00] bg-white' }} rounded-xl p-5 hover:border-[#ffce00] hover:shadow-lg transition">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">

                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-full bg-[#0b0b0d] text-[#ffce00] ring-2 ring-[#ffce00]/30 flex items-center justify-center font-display font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr($item->user->name ?? 'P', 0, 1)) }}
                            </div>
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-semibold text-[#0b0b0d]">{{ $item->user->name ?? '-' }}</span>
                                    @if($isTelat)
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-mono font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full bg-[#d00000] text-white">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            Terlambat{{ $hariTelat >= 1 ? ' ' . $hariTelat . ' hari' : '' }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-2 flex flex-wrap items-center gap-x-5 gap-y-1 text-sm font-mono">
                                    <span class="inline-flex items-center gap-1.5 text-[#706B5C]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#8f0000]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Pinjam: <span class="text-[#0b0b0d]">{{ optional($item->tgl_pinjam)->format('d M Y') ?? '-' }}</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-[#706B5C]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#8f0000]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Rencana kembali: <span class="{{ $isTelat ? 'text-[#d00000] font-semibold' : 'text-[#0b0b0d]' }}">{{ optional($item->tgl_kembali_plan)->format('d M Y') ?? '-' }}</span>
                                    </span>
                                </div>

                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    @foreach($item->detailPinjam as $detail)
                                        <span class="inline-flex items-center gap-2 bg-[#f5f3ee] border border-[#ece8dc] text-[#0b0b0d] text-xs pl-2.5 pr-1.5 py-1 rounded-full font-mono">
                                            {{ $detail->alat->nama_alat ?? '-' }}
                                            <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-[#0b0b0d] text-[#ffce00] text-[10px] font-semibold">×{{ $detail->jumlah }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <button type="button"
                            onclick="document.getElementById('modal-pengembalian-{{ $item->id }}').classList.remove('hidden')"
                            class="bg-[#0b0b0d] hover:bg-[#1c1c22] text-[#ffce00] px-5 py-2.5 text-sm font-semibold rounded-lg shadow-md shadow-black/20 transition whitespace-nowrap">
                            Proses pengembalian
                        </button>
                    </div>
                </div>

                {{-- Modal form pengembalian --}}
                <div id="modal-pengembalian-{{ $item->id }}" class="hidden fixed inset-0 bg-[#0b0b0d]/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-xl w-full max-w-md overflow-hidden shadow-2xl">
                        <div class="h-1 flex">
                            <span class="flex-1 bg-black"></span>
                            <span class="flex-1 bg-[#d00000]"></span>
                            <span class="flex-1 bg-[#ffce00]"></span>
                        </div>

                        <div class="p-6">
                            <h3 class="font-display text-lg font-bold text-[#0b0b0d] mb-1">Proses pengembalian</h3>
                            <p class="text-sm text-[#706B5C] mb-5">{{ $item->user->name ?? '-' }} &middot; {{ optional($item->tgl_pinjam)->format('d M Y') }}</p>

                            <form action="{{ route('petugas.pengembalian.proses', $item->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-[11px] font-semibold uppercase tracking-[0.15em] text-[#706B5C] mb-1.5">Kondisi alat saat kembali</label>
                                    <select name="kondisi_kembali" required onchange="toggleDenda(this)"
                                        class="w-full text-sm border border-[#e7e3d8] rounded-lg px-3 py-2.5 bg-[#faf8f3] focus:outline-none focus:border-[#d00000] focus:ring-2 focus:ring-[#d00000]/15">
                                        <option value="baik">Baik</option>
                                        <option value="rusak ringan">Rusak ringan</option>
                                        <option value="rusak berat">Rusak berat</option>
                                        <option value="hilang">Hilang</option>
                                    </select>
                                </div>

                                {{-- Rusak ringan: denda otomatis Rp200.000 --}}
                                <div data-info-ringan class="hidden mb-6 text-sm rounded-lg bg-[#fff6d1] text-[#7a5c00] border border-[#ffce00]/50 px-3 py-2.5">
                                    Denda rusak ringan <span class="font-mono font-semibold">Rp200.000</span> diterapkan otomatis.
                                </div>

                                {{-- Rusak berat / hilang: nominal diisi petugas --}}
                                <div data-wrap-manual class="hidden mb-6">
                                    <label class="block text-[11px] font-semibold uppercase tracking-[0.15em] text-[#706B5C] mb-1.5">Denda kerusakan (Rp)</label>
                                    <input type="number" name="denda_manual" min="0" value="0"
                                        class="w-full text-sm font-mono border border-[#e7e3d8] rounded-lg px-3 py-2.5 bg-[#faf8f3] focus:outline-none focus:border-[#d00000] focus:ring-2 focus:ring-[#d00000]/15">
                                    <p class="text-xs text-[#706B5C] mt-1.5">Isi sesuai tingkat kerusakan atau nilai alat yang hilang.</p>
                                </div>

                                @if($isTelat)
                                    <p class="text-xs text-[#d00000] mb-6">Peminjaman ini terlambat, denda telat Rp10.000 akan ditambahkan otomatis.</p>
                                @endif

                                <div class="flex justify-end gap-2">
                                    <button type="button"
                                        onclick="document.getElementById('modal-pengembalian-{{ $item->id }}').classList.add('hidden')"
                                        class="px-4 py-2.5 text-sm font-medium text-[#706B5C] hover:bg-[#f0ede4] rounded-lg transition">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-5 py-2.5 text-sm font-semibold bg-gradient-to-br from-[#d00000] to-[#8f0000] text-white rounded-lg shadow-md shadow-red-900/25 hover:brightness-110 transition">
                                        Simpan pengembalian
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-[#e7e3d8] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <div class="font-semibold text-[#0b0b0d]">Tidak ada peminjaman aktif saat ini</div>
                    <div class="text-sm text-[#706B5C] mt-1">Semua alat sudah dikembalikan</div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        // Tampilkan info/input denda sesuai kondisi alat yang dipilih
        function toggleDenda(select) {
            const form   = select.closest('form');
            const kondisi = select.value.toLowerCase().replace('_', ' ');
            const info   = form.querySelector('[data-info-ringan]');
            const wrap   = form.querySelector('[data-wrap-manual]');
            const input  = form.querySelector('input[name="denda_manual"]');

            const ringan = kondisi === 'rusak ringan';
            const manual = kondisi === 'rusak berat' || kondisi === 'hilang';

            info.classList.toggle('hidden', !ringan);
            wrap.classList.toggle('hidden', !manual);

            input.required = manual;
            if (!manual) input.value = 0;
        }
    </script>

@endsection