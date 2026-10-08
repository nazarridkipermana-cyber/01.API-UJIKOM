@extends($layout)

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-200">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Profil Saya</h3>
            <p class="text-sm text-gray-500">Ubah foto, nama, nomor HP, atau password akunmu.</p>
        </div>
        <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold">
            &larr; Kembali
        </a>
    </div>

    {{-- Layout petugas & peminjam sudah menampilkan notifikasi sendiri, hanya admin yang belum --}}
    @if(session('success') && $user->role === 'admin')
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 p-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil <span class="text-xs text-gray-500 font-normal">(Kosongkan jika tidak diubah)</span></label>
            <div class="flex items-center gap-4">
                @if($user->foto_profile)
                    <img id="previewFoto" src="{{ asset($user->foto_profile) }}" alt="Foto {{ $user->name }}"
                        class="w-16 h-16 rounded-full object-cover border border-gray-200">
                @else
                    <img id="previewFoto" src="" alt="Preview foto"
                        class="hidden w-16 h-16 rounded-full object-cover border border-gray-200">
                    <div id="inisialFoto" class="w-16 h-16 rounded-full bg-gray-800 text-yellow-400 flex items-center justify-center font-bold text-xl flex-shrink-0">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <input type="file" name="foto_profile" id="inputFoto" accept="image/png,image/jpeg"
                    class="w-full border border-gray-300 rounded-lg p-2 text-sm">
            </div>
            <p class="text-xs text-gray-500 mt-1">Format JPG atau PNG, maksimal 2 MB.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" value="{{ $user->email }}" class="w-full border border-gray-200 bg-gray-50 text-gray-500 rounded-lg p-2.5 text-sm" disabled>
            <p class="text-xs text-gray-500 mt-1">Email dan role hanya bisa diubah oleh admin.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm">
        </div>

        <div class="pt-2 border-t">
            <p class="text-sm font-semibold text-gray-700 mt-3 mb-2">Ganti Password <span class="text-xs text-gray-500 font-normal">(Kosongkan jika tidak diubah)</span></p>
            <div class="space-y-3">
                <input type="password" name="password" placeholder="Password baru (minimal 8 karakter)"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm">
            </div>
        </div>

        <div class="pt-4 flex justify-end space-x-2 border-t">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                Simpan Profil
            </button>
        </div>
    </form>
</div>

<script>
    // Preview foto sebelum disimpan
    document.getElementById('inputFoto').addEventListener('change', function () {
        const preview = document.getElementById('previewFoto');
        const inisial = document.getElementById('inisialFoto');
        const file = this.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            if (inisial) inisial.classList.add('hidden');
        }
    });
</script>
@endsection