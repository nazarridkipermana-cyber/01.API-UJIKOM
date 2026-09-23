@extends('layouts.petugas')

@section('title', 'Pemantauan Pengembalian - Dashboard Petugas')

@section('content')

    <div class="mb-8">
        <div class="font-mono text-xs text-[#706B5C] mb-1">pemantauan</div>
        <h1 class="font-display text-2xl font-semibold text-[#1B1F27]">Pemantauan Pengembalian Alat</h1>
    </div>

    {{-- Ringkasan cepat --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-[#E5E1D6] p-5">
            <p class="font-display text-3xl font-semibold text-[#1B1F27]">{{ $totalAktif }}</p>
            <p class="text-sm text-[#706B5C] mt-1">Peminjaman aktif</p>
        </div>
        <div class="bg-white rounded-lg border border-[#E5E1D6] border-l-2 border-l-[#B23A2E] p-5">
            <p class="font-display text-3xl font-semibold text-[#B23A2E]">{{ $totalTerlambat }}</p>
            <p class="text-sm text-[#706B5C] mt-1">Terlambat</p>
        </div>
        <div class="bg-white rounded-lg border border-[#E5E1D6] p-5">
            <p class="font-display text-3xl font-semibold text-[#1B1F27]">{{ $totalUnit }}</p>
            <p class="text-sm text-[#706B5C] mt-1">Total unit dipinjam</p>
        </div>
    </div>

    {{-- Daftar peminjaman aktif --}}
    <div class="bg-white rounded-lg border border-[#E5E1D6] overflow-hidden">
        <div class="p-5 border-b border-[#E5E1D6]">
            <h3 class="font-display text-lg font-semibold text-[#1B1F27]">Daftar peminjaman aktif</h3>
            <p class="text-sm text-[#706B5C]">Alat yang masih dipinjam dan menunggu pengembalian</p>
        </div>

        <div class="divide-y divide-[#E5E1D6]">
            @forelse($peminjamans as $item)
                @php
                    $isTelat = $item->tgl_kembali_plan && now()->gt($item->tgl_kembali_plan);
                @endphp
                <div class="p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-4 {{ $isTelat ? 'border-l-2 border-l-[#B23A2E]' : '' }}">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#14181F] text-white flex items-center justify-center font-display font-semibold text-sm flex-shrink-0">
                            {{ strtoupper(substr($item->user->name ?? 'P', 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-[#1B1F27]">{{ $item->user->name ?? '-' }}</span>
                                @if($isTelat)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-mono bg-[#B23A2E]/10 text-[#B23A2E]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#B23A2E]"></span>
                                        Terlambat
                                    </span>
                                @endif
                            </div>
                            <div class="text-sm text-[#706B5C] mt-0.5 font-mono">
                                Pinjam: {{ optional($item->tgl_pinjam)->format('d-m-Y') ?? '-' }}
                                &middot;
                                Rencana kembali: {{ optional($item->tgl_kembali_plan)->format('d-m-Y') ?? '-' }}
                            </div>
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach($item->detailPinjam as $detail)
                                    <span class="text-xs bg-[#F3F1EC] text-[#1B1F27] rounded px-2 py-0.5 font-mono">
                                        {{ $detail->alat->nama_alat ?? '-' }} <span class="text-[#706B5C]">×{{ $detail->jumlah }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <button type="button"
                        onclick="document.getElementById('modal-pengembalian-{{ $item->id }}').classList.remove('hidden')"
                        class="bg-[#C98A3B] hover:bg-[#B67927] text-white px-4 py-2 text-sm font-medium rounded-md transition whitespace-nowrap">
                        Proses pengembalian
                    </button>
                </div>

                {{-- Modal form pengembalian --}}
                <div id="modal-pengembalian-{{ $item->id }}" class="hidden fixed inset-0 bg-[#14181F]/60 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-lg w-full max-w-md p-6">
                        <h3 class="font-display text-lg font-semibold text-[#1B1F27] mb-1">Proses pengembalian</h3>
                        <p class="text-sm text-[#706B5C] mb-4 font-mono">{{ $item->user->name ?? '-' }} &middot; {{ optional($item->tgl_pinjam)->format('d-m-Y') }}</p>

                        <form action="{{ route('petugas.pengembalian.proses', $item->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-[#1B1F27] mb-1">Kondisi alat saat kembali</label>
                                <select name="kondisi_kembali" required
                                    class="w-full text-sm border border-[#E5E1D6] rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#C98A3B]">
                                    <option value="baik">Baik</option>
                                    <option value="rusak ringan">Rusak ringan</option>
                                    <option value="rusak berat">Rusak berat</option>
                                    <option value="hilang">Hilang</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-[#1B1F27] mb-1">Denda (Rp)</label>
                                <input type="number" name="denda" min="0" value="0"
                                    class="w-full text-sm font-mono border border-[#E5E1D6] rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#C98A3B]">
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button"
                                    onclick="document.getElementById('modal-pengembalian-{{ $item->id }}').classList.add('hidden')"
                                    class="bg-[#F3F1EC] hover:bg-[#E5E1D6] text-[#706B5C] px-4 py-2 text-sm rounded-md transition">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-[#C98A3B] hover:bg-[#B67927] text-white px-4 py-2 text-sm font-medium rounded-md transition">
                                    Simpan pengembalian
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-[#706B5C] text-sm">
                    Tidak ada peminjaman aktif saat ini.
                </div>
            @endforelse
        </div>
    </div>

@endsection