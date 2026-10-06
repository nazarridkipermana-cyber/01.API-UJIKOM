@extends('layouts.peminjam')

@section('title', 'Katalog Alat - Peminjam')

@section('content')

    <!-- Judul halaman -->
    <div class="mb-8">
        <div class="font-mono text-xs tracking-[0.25em] uppercase text-[#8f0000] mb-1">Katalog</div>
        <h1 class="font-display text-3xl font-bold text-[#0b0b0d]">Katalog Alat Tersedia</h1>
        <div class="mt-3 flex h-1 w-16 overflow-hidden rounded-full">
            <span class="flex-1 bg-black"></span>
            <span class="flex-1 bg-[#d00000]"></span>
            <span class="flex-1 bg-[#ffce00]"></span>
        </div>
    </div>

    <!-- Alert Selamat Datang -->
    <div class="de-alert de-alert-success">
        Selamat datang, <strong class="font-semibold text-[#8f0000]">{{ auth()->user()->name }}</strong>. Anda login sebagai
        <span class="font-mono font-semibold uppercase text-[#8f0000]">{{ auth()->user()->role }}</span>.
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

        <!-- ============ DAFTAR ALAT ============ -->
        <div class="md:col-span-2 bg-white rounded-xl border border-[#e7e3d8] overflow-hidden" style="border-top:1px solid #e7e3d8 !important">
            <div class="h-[3px] flex"><span class="flex-1 bg-black"></span><span class="flex-1 bg-[#d00000]"></span><span class="flex-1 bg-[#ffce00]"></span></div>

            <div class="p-5 border-b border-[#e7e3d8] flex items-center justify-between">
                <h3 class="font-display text-lg font-semibold text-[#0b0b0d]">Daftar alat tersedia</h3>
                <span class="font-mono text-[11px] tracking-wider uppercase text-[#706B5C]">
                    {{ $alats->count() }} alat &middot; {{ $alats->sum('stok') }} unit
                </span>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5">
                @forelse($alats as $alat)
                    <div class="group bg-white rounded-xl overflow-hidden border border-[#ece8dc] shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">

                        <!-- Gambar -->
                        <div class="relative h-44 bg-white flex items-center justify-center overflow-hidden">
                            @if($alat->gambar)
                                <img src="{{ asset($alat->gambar) }}"
                                    alt="{{ $alat->nama_alat }}"
                                    class="w-full h-full object-contain p-4 group-hover:scale-105 transition duration-500 {{ $alat->stok <= 0 ? 'grayscale opacity-60' : '' }}">
                            @else
                                <svg class="w-10 h-10 text-[#d8d3c6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16v12H4V6z" />
                                </svg>
                            @endif

                            <!-- Badge status -->
                            <div class="absolute top-3 left-3">
                                @if($alat->stok <= 0)
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-mono font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full bg-[#d00000] text-white shadow">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span> Habis
                                    </span>
                                @elseif($alat->stok <= 3)
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-mono font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full bg-[#ffce00] text-[#1a1200] shadow">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span> Terbatas
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-mono font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full bg-[#0b0b0d]/85 text-[#ffce00] backdrop-blur shadow">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span> Tersedia
                                    </span>
                                @endif
                            </div>

                            <!-- Garis tricolor tipis di dasar gambar -->
                            <div class="absolute bottom-0 inset-x-0 h-[3px] flex">
                                <span class="flex-1 bg-black"></span>
                                <span class="flex-1 bg-[#d00000]"></span>
                                <span class="flex-1 bg-[#ffce00]"></span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-4">
                            <p class="text-[10px] font-mono uppercase tracking-[0.18em] text-[#8f0000] mb-1">
                                {{ $alat->kategori->nama_kategori ?? '-' }}
                            </p>
                            <h4 class="font-display font-semibold text-[#0b0b0d] text-base leading-snug">
                                {{ $alat->nama_alat }}
                            </h4>

                            <div class="mt-4 pt-3 border-t border-dashed border-[#e7e3d8] flex justify-between items-end">
                                <span class="text-xs text-[#706B5C]">Stok tersedia</span>
                                <span class="font-display font-bold text-xl text-[#0b0b0d] leading-none">
                                    {{ $alat->stok }}<span class="text-xs font-normal text-[#706B5C] ml-1">unit</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-10 text-[#706B5C] text-sm">
                        Belum ada alat yang tersedia.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ============ FORM PENGAJUAN ============ -->
        <div class="bg-white rounded-xl border border-[#e7e3d8] md:sticky md:top-6 overflow-hidden" style="border-top:1px solid #e7e3d8 !important">
            <div class="h-[3px] flex"><span class="flex-1 bg-black"></span><span class="flex-1 bg-[#d00000]"></span><span class="flex-1 bg-[#ffce00]"></span></div>

            <div class="p-5 border-b border-[#e7e3d8]">
                <h3 class="font-display text-lg font-semibold text-[#0b0b0d]">Form ajukan peminjaman</h3>
                <p class="text-xs text-[#706B5C] mt-1">Isi data di bawah, lalu kirim untuk diproses petugas.</p>
            </div>

            <div class="p-5">
                @if($errors->any())
                    <div class="de-alert de-alert-error">
                        <ul class="list-disc pl-5 mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('peminjam.peminjaman.ajukan') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-[0.15em] text-[#706B5C] mb-1.5">Tanggal pinjam</label>
                        <input type="date" name="tgl_pinjam" value="{{ old('tgl_pinjam', now()->toDateString()) }}"
                            class="w-full border border-[#e7e3d8] rounded-lg p-2.5 text-sm font-mono bg-[#faf8f3]"
                            required>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-[0.15em] text-[#706B5C] mb-1.5">Rencana tanggal kembali</label>
                        <input type="date" name="tgl_kembali_plan" value="{{ old('tgl_kembali_plan') }}"
                            class="w-full border border-[#e7e3d8] rounded-lg p-2.5 text-sm font-mono bg-[#faf8f3]"
                            required>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-[0.15em] text-[#706B5C] mb-1.5">Pilih alat</label>
                        <select name="alat_id[]"
                            class="w-full border border-[#e7e3d8] rounded-lg p-2.5 text-sm bg-[#faf8f3]"
                            required>
                            <option value="">-- Pilih alat --</option>
                            @foreach($alats as $alat)
                                <option value="{{ $alat->id }}">{{ $alat->nama_alat }} (Stok: {{ $alat->stok }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-[0.15em] text-[#706B5C] mb-1.5">Jumlah</label>
                        <input type="number" name="jumlah[]" min="1" value="1"
                            class="w-full border border-[#e7e3d8] rounded-lg p-2.5 text-sm font-mono bg-[#faf8f3]"
                            required>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-br from-[#d00000] to-[#8f0000] text-white font-semibold tracking-wide py-3 rounded-lg text-sm shadow-lg shadow-red-900/25 hover:brightness-110 hover:-translate-y-0.5 transition">
                        Kirim pengajuan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection