@extends('layouts.petugas')

@section('title', 'Pemantauan Pengembalian - Dashboard Petugas')

@section('content')

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pemantauan Pengembalian Alat</h1>

    {{-- Ringkasan cepat --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $totalAktif }}</p>
                <p class="text-sm text-gray-500">Peminjaman Aktif</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $totalTerlambat }}</p>
                <p class="text-sm text-gray-500">Terlambat</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $totalUnit }}</p>
                <p class="text-sm text-gray-500">Total Unit Dipinjam</p>
            </div>
        </div>
    </div>

    {{-- Daftar peminjaman aktif --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Daftar Peminjaman Aktif</h3>
            <p class="text-sm text-gray-500">Alat yang masih dipinjam dan menunggu pengembalian</p>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($peminjamans as $item)
                @php
                    $isTelat = $item->tgl_kembali_plan && now()->gt($item->tgl_kembali_plan);
                @endphp
                <div class="p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-600 to-gray-800 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
                            {{ strtoupper(substr($item->user->name ?? 'P', 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-900">{{ $item->user->name ?? '-' }}</span>
                                @if($isTelat)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                        Terlambat
                                    </span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 mt-0.5">
                                Pinjam: {{ optional($item->tgl_pinjam)->format('d-m-Y') ?? '-' }}
                                &middot;
                                Rencana kembali: {{ optional($item->tgl_kembali_plan)->format('d-m-Y') ?? '-' }}
                            </div>
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach($item->detailPinjam as $detail)
                                    <span class="text-xs bg-gray-100 text-gray-600 rounded-full px-2 py-0.5">
                                        {{ $detail->alat->nama_alat ?? '-' }} <span class="text-gray-400">×{{ $detail->jumlah }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <button type="button"
                        onclick="document.getElementById('modal-pengembalian-{{ $item->id }}').classList.remove('hidden')"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-semibold rounded-lg transition shadow-sm whitespace-nowrap">
                        Proses Pengembalian
                    </button>
                </div>

                {{-- Modal form pengembalian --}}
                <div id="modal-pengembalian-{{ $item->id }}" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Proses Pengembalian</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $item->user->name ?? '-' }} &middot; {{ optional($item->tgl_pinjam)->format('d-m-Y') }}</p>

                        <form action="{{ route('petugas.pengembalian.proses', $item->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kondisi Alat Saat Kembali</label>
                                <select name="kondisi_kembali" required
                                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="baik">Baik</option>
                                    <option value="rusak ringan">Rusak Ringan</option>
                                    <option value="rusak berat">Rusak Berat</option>
                                    <option value="hilang">Hilang</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Denda (Rp)</label>
                                <input type="number" name="denda" min="0" value="0"
                                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button"
                                    onclick="document.getElementById('modal-pengembalian-{{ $item->id }}').classList.add('hidden')"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 text-sm rounded-lg transition">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-semibold rounded-lg transition">
                                    Simpan Pengembalian
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-gray-500">
                    Tidak ada peminjaman aktif saat ini.
                </div>
            @endforelse
        </div>
    </div>

@endsection