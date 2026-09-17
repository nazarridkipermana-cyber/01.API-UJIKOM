@extends('layouts.peminjam')

@section('title', 'Katalog Alat - Peminjam')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Katalog Alat Tersedia</h1>

<!-- Alert Selamat Datang -->
<div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg shadow-sm">
    Selamat datang, <strong class="font-semibold">{{ auth()->user()->name }}</strong>. Anda login sebagai
    <span class="uppercase font-bold text-blue-900">{{ auth()->user()->role }}</span>.
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Daftar Alat Tersedia -->
    <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Alat Tersedia</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($alats as $alat)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <h4 class="font-bold text-gray-800 text-base">{{ $alat->nama_alat }}</h4>
                    <p class="text-sm text-gray-500 mb-2">Kategori: {{ $alat->kategori->nama_kategori ?? '-' }}</p>
                    <div class="flex justify-between items-center mt-3">
                        @if($alat->stok > 0)
                            <span class="text-xs bg-green-100 text-green-800 font-medium px-2.5 py-0.5 rounded">Tersedia</span>
                        @else
                            <span class="text-xs bg-red-100 text-red-800 font-medium px-2.5 py-0.5 rounded">Habis</span>
                        @endif
                        <span class="text-sm font-semibold text-gray-700">Stok: {{ $alat->stok }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-6 text-gray-500">
                    Belum ada alat yang tersedia.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Form Pengajuan Peminjaman -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Form Ajukan Peminjaman</h3>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-3 rounded-lg text-sm">
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Rencana Tanggal Kembali</label>
                <input type="date" name="tgl_kembali_plan"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Alat</label>
                <select name="alat_id[]"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="">-- Pilih Alat --</option>
                    @foreach($alats as $alat)
                        <option value="{{ $alat->id }}">{{ $alat->nama_alat }} (Stok: {{ $alat->stok }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" name="jumlah[]" min="1" value="1"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg text-sm transition">
                Kirim Pengajuan
            </button>
        </form>
    </div>
</div>
@endsection