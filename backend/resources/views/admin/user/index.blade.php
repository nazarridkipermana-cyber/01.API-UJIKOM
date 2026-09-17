@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
    <!-- Header Halaman & Tombol Tambah User -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Manajemen Pengguna Sistem</h3>
            <p class="text-sm text-gray-500">Daftar pengguna yang terdaftar di dalam sistem.</p>
        </div>
        <a href="{{ route('admin.user.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition shadow-sm">
            + Tambah User
        </a>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 p-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Search -->
    <form action="{{ route('admin.user.index') }}" method="GET" class="mb-4 flex items-center gap-2">
        <div class="relative w-full max-w-xs">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Cari nama, email, role..." 
                class="w-full border border-gray-300 rounded-lg pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            @if(request('search'))
                <a href="{{ route('admin.user.index') }}" class="absolute right-2.5 top-2.5 text-gray-400 hover:text-gray-600 text-xs" title="Reset Pencarian">
                    ✕
                </a>
            @endif
        </div>
        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            Cari
        </button>
    </form>

    <!-- Tabel Daftar User -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                    <th class="py-3 px-4 border-b">Nama</th>
                    <th class="py-3 px-4 border-b">Email</th>
                    <th class="py-3 px-4 border-b">Role / Hak Akses</th>
                    <th class="py-3 px-4 border-b">No. HP</th>
                    <th class="py-3 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 border-b font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="py-3 px-4 border-b">{{ $user->email }}</td>
                        <td class="py-3 px-4 border-b">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                                {{ $user->role == 'admin' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $user->role == 'petugas' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $user->role == 'peminjam' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 border-b">{{ $user->no_hp ?? '-' }}</td>
                        <td class="py-3 px-4 border-b text-center space-x-2">
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="text-blue-600 hover:underline text-xs font-semibold">Edit</a>
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">
                            {{ request('search') ? 'Data pengguna tidak ditemukan.' : 'Belum ada data pengguna.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 pt-4 border-t border-gray-100">
        {{ $users->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection