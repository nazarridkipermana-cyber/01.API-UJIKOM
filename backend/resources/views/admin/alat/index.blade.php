@extends('layouts.app')
@section('title', 'Kelola Alat - Panel Admin')
@section('header-title', 'Manajemen Data Alat')

@section('content')
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="text-lg font-bold text-gray-800">Daftar Alat Laboratorium</h3>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <form action="{{ route('admin.alat.index') }}" method="GET" class="flex w-full md:w-80">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama alat, kategori..."
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 text-sm font-semibold rounded-r-lg transition">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.alat.index') }}"
                            class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-700 px-3 py-2 text-sm rounded-lg flex items-center transition">
                            Reset
                        </a>
                    @endif
                </form>

                <a href="{{ route('admin.alat.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition whitespace-nowrap">
                    + Tambah Alat
                </a>
            </div>
        </div>

        <div class="p-5">
            @if($alats->isEmpty())
                <p class="text-center text-gray-500 py-8">Belum ada data alat.</p>
            @endif

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                @foreach($alats as $alat)
                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition bg-white flex flex-col">
                        <div class="w-full aspect-square bg-gray-50">
                            @if($alat->gambar)
                                <img src="{{ asset($alat->gambar) }}" alt="{{ $alat->nama_alat }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-3 flex flex-col flex-1">
                            <h4 class="font-semibold text-gray-900 text-sm leading-snug line-clamp-2 mb-1">{{ $alat->nama_alat }}</h4>
                            <p class="text-xs text-gray-500 mb-2">{{ $alat->kategori->nama_kategori ?? '-' }}</p>

                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs text-gray-600">Stok: <span class="font-semibold text-gray-900">{{ $alat->stok }}</span></span>
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                                    @if(strtolower($alat->status_kondisi) == 'baik') bg-emerald-100 text-emerald-800
                                    @else bg-amber-100 text-amber-800 @endif">
                                    {{ $alat->status_kondisi }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2 mt-auto">
                                <a href="{{ route('admin.alat.edit', $alat->id) }}"
                                    class="flex-1 text-center bg-amber-500 hover:bg-amber-600 text-white px-2 py-1.5 rounded text-xs font-semibold transition">
                                    Edit
                                </a>

                                <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alat ini?')" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-2 py-1.5 rounded text-xs font-semibold transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $alats->links() }}
        </div>
    </div>
@endsection