@extends('layouts.app')

@section('title', 'Proses Pengembalian - Panel Admin')
@section('header-title', 'Proses Pengembalian Alat')

@section('content')
<div class="max-w-xl bg-white rounded-lg shadow-sm border border-gray-200 p-6">

    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-4">
        <span class="block text-sm font-semibold text-gray-500">Peminjam</span>
        <span class="text-lg font-bold text-gray-800">{{ $peminjaman->user->name ?? '-' }}</span>
    </div>

    <div class="mb-4">
        <span class="block text-sm font-semibold text-gray-500 mb-1">Alat yang Dipinjam</span>
        <ul class="list-disc list-inside text-sm text-gray-700">
            @foreach($peminjaman->detailPinjam as $detail)
                <li>{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }} — {{ $detail->jumlah }} pcs</li>
            @endforeach
        </ul>
    </div>

    <form action="{{ route('admin.pengembalian.store', $peminjaman->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
            <input type="text" value="{{ now()->format('d/m/Y') }}" disabled
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-gray-100 text-gray-500">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Alat</label>
            <select name="kondisi_kembali" required
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
                <option value="Hilang">Hilang</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Denda (Rp)</label>
            <input type="number" name="denda" min="0" value="0" placeholder="Isi 0 jika tidak ada denda"
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.pengembalian.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm font-semibold transition">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Simpan Pengembalian</button>
        </div>
    </form>
</div>
@endsection