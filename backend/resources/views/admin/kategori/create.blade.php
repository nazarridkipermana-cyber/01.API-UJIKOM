@extends('layouts.app')

@section('title', 'Tambah Kategori - Panel Admin')
@section('header-title', 'Manajemen Kategori Alat')

@section('content')
    <!-- Notifikasi Error Jika Ada Validation Error -->
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg shadow-sm text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 max-w-2xl mx-auto">
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Tambah Kategori Alat</h3>
            <a href="{{ route('admin.kategori.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold">
                &larr; Kembali
            </a>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nama_kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nama_kategori" 
                        name="nama_kategori" 
                        value="{{ old('nama_kategori') }}" 
                        placeholder="Masukkan nama kategori..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm @error('nama_kategori') border-red-500 @enderror"
                        required
                    >
                    @error('nama_kategori')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.kategori.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 text-sm font-semibold rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm font-semibold rounded-lg transition shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection