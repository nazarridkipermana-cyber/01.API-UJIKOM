@extends('layouts.app')

@section('title', 'Edit Pengembalian - Panel Admin')
@section('header-title', 'Edit Data Pengembalian')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-5 pb-4 border-b border-gray-200">
        <p class="text-sm text-gray-500">Peminjaman #{{ $pengembalian->peminjaman_id }}</p>
        <p class="font-semibold text-gray-900">{{ $pengembalian->peminjaman->user->name ?? 'User Dihapus' }}</p>
        <div class="flex flex-wrap gap-1.5 mt-2">
            @foreach($pengembalian->peminjaman->detailPinjam ?? [] as $detail)
                <span class="inline-flex items-center text-xs bg-gray-100 text-gray-800 rounded px-2 py-0.5">
                    {{ $detail->alat->nama_alat ?? 'Alat Dihapus' }} (x{{ $detail->jumlah }})
                </span>
            @endforeach
        </div>
    </div>

    <form action="{{ route('admin.pengembalian.update', $pengembalian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Kembali</label>
            <input type="date" name="tgl_kembali" value="{{ old('tgl_kembali', $pengembalian->tgl_kembali->format('Y-m-d')) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Kondisi Alat Saat Kembali</label>
            <select name="kondisi_kembali" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(['baik' => 'Baik', 'rusak ringan' => 'Rusak Ringan', 'rusak berat' => 'Rusak Berat', 'hilang' => 'Hilang'] as $value => $label)
                    <option value="{{ $value }}" {{ strtolower($pengembalian->kondisi_kembali) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Denda (Rp)</label>
            <input type="number" name="denda" min="0" value="{{ old('denda', $pengembalian->denda) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.pengembalian.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm font-semibold transition">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection