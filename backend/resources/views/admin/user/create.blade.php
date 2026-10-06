@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-200">
    <!-- Header Halaman & Tombol Kembali -->
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Tambah Data Pengguna</h3>
            <p class="text-sm text-gray-500">Tambahkan pengguna baru ke dalam sistem.</p>
        </div>
        <a href="{{ route('admin.user.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold">
            &larr; Kembali
        </a>
    </div>

    <!-- Alert Error Validasi -->
    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Create User -->
    <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Minimal 8 karakter" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role / Hak Akses</label>
            <select name="role" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="" disabled selected>-- Pilih Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP (Opsional)</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="pt-4 flex justify-end space-x-2 border-t">
            <a href="{{ route('admin.user.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold px-4 py-2 rounded-lg transition">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                Simpan Data User
            </button>
        </div>
    </form>
</div>
@endsection