<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    // Pilih layout sesuai role supaya tampilan tetap sama dengan panelnya
    private function layoutUntuk($user): string
    {
        return match ($user->role) {
            'petugas'  => 'layouts.petugas',
            'peminjam' => 'layouts.peminjam',
            default    => 'layouts.app', // admin
        };
    }

    public function edit()
    {
        $user = auth()->user();

        return view('profil.edit', [
            'user'   => $user,
            'layout' => $this->layoutUntuk($user),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Email dan role sengaja TIDAK bisa diubah dari sini
        $request->validate([
            'name'         => 'required|string|max:255',
            'no_hp'        => 'nullable|string|max:20',
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'     => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'no_hp' => $request->no_hp,
        ];

        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama kalau ada
            if ($user->foto_profile && file_exists(public_path($user->foto_profile))) {
                unlink(public_path($user->foto_profile));
            }

            $file = $request->file('foto_profile');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/profil'), $filename);
            $data['foto_profile'] = 'storage/profil/' . $filename;
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        LogAktivitas::create([
            'user_id'   => $user->id,
            'aktivitas' => 'Memperbarui profil sendiri: ' . $user->name,
        ]);

        return redirect()->route('profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}