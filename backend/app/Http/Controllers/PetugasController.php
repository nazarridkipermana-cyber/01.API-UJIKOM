<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PetugasController extends Controller
{
    // Menampilkan daftar pengajuan peminjaman dari siswa/peminjam
    public function indexPeminjaman()
    {
        $peminjamans = Peminjaman::with(['user', 'detailPinjam.alat'])->latest()->get();
        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    // Menyetujui peminjaman & mengurangi stok alat
    public function setujuiPeminjaman($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detailPinjam')->findOrFail($id);

            // Validasi stok sebelum disetujui
            foreach ($peminjaman->detailPinjam as $detail) {
                $alat = Alat::findOrFail($detail->alat_id);
                if ($alat->stok < $detail->jumlah) {
                    throw new \Exception("Stok alat '{$alat->nama_alat}' tidak mencukupi.");
                }
            }

            $peminjaman->update(['status' => 'dipinjam']);

            // Kurangi stok alat secara otomatis
            foreach ($peminjaman->detailPinjam as $detail) {
                $alat = Alat::findOrFail($detail->alat_id);
                $alat->stok -= $detail->jumlah;
                $alat->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Peminjaman disetujui dan stok alat dikurangi.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Memproses pengembalian alat, hitung denda otomatis, kembalikan stok
    public function prosesPengembalian(Request $request, $peminjamanId)
    {
        $request->validate([
            'kondisi_kembali' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detailPinjam')->findOrFail($peminjamanId);

            // Denda otomatis: flat Rp10.000 jika sudah lewat tgl_kembali_plan
            $telat = now()->startOfDay()->greaterThan(
                Carbon::parse($peminjaman->tgl_kembali_plan)->startOfDay()
            );
            $denda = $telat ? 10000 : 0;

            // Simpan data pengembalian
            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tgl_kembali' => now(),
                'kondisi_kembali' => $request->kondisi_kembali,
                'denda' => $denda,
                'petugas_id' => auth()->id(),
            ]);

            // Update status peminjaman jadi dikembalikan
            $peminjaman->update(['status' => 'dikembalikan']);

            // Kembalikan stok alat ke inventaris
            foreach ($peminjaman->detailPinjam as $detail) {
                $alat = Alat::findOrFail($detail->alat_id);
                $alat->stok += $detail->jumlah;
                $alat->save();
            }

            DB::commit();

            $pesanDenda = $telat ? ' Terlambat, denda Rp10.000 otomatis diterapkan.' : '';
            return redirect()->back()->with('success', 'Pengembalian berhasil dicatat dan stok dipulihkan.' . $pesanDenda);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menampilkan daftar peminjaman yang masih aktif (status = dipinjam / telat)
    public function indexPengembalian()
    {
        $peminjamans = Peminjaman::with(['user', 'detailPinjam.alat'])
            ->whereIn('status', ['dipinjam', 'telat'])
            ->latest()
            ->get();

        $totalAktif = $peminjamans->count();

        $totalTerlambat = $peminjamans->filter(function ($p) {
            return $p->tgl_kembali_plan && now()->gt($p->tgl_kembali_plan);
        })->count();

        $totalUnit = $peminjamans->sum(function ($p) {
            return $p->detailPinjam->sum('jumlah');
        });

        return view('petugas.pengembalian.index', compact(
            'peminjamans', 'totalAktif', 'totalTerlambat', 'totalUnit'
        ));
    }

    // Menampilkan laporan peminjaman & pengembalian dengan filter
    public function indexLaporan(Request $request)
    {
        $query = Peminjaman::with(['user', 'detailPinjam.alat', 'pengembalian']);

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tgl_pinjam', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tgl_pinjam', '<=', $request->sampai_tanggal);
        }

        $peminjamans = $query->latest()->get();

        $totalSelesai = $peminjamans->where('status', 'dikembalikan')->count();

        $totalTelat = $peminjamans->filter(function ($p) {
            return $p->tgl_kembali_plan && $p->status === 'dipinjam' && now()->gt($p->tgl_kembali_plan);
        })->count();

        $totalDenda = $peminjamans->sum(function ($p) {
            return optional($p->pengembalian)->denda ?? 0;
        });

        return view('petugas.laporan.index', compact(
            'peminjamans', 'totalSelesai', 'totalTelat', 'totalDenda'
        ));
    }

    // Menampilkan versi cetak/print dari laporan (dengan filter yang sama seperti indexLaporan)
    public function cetakLaporan(Request $request)
    {
        $query = Peminjaman::with(['user', 'detailPinjam.alat', 'pengembalian']);

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tgl_pinjam', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tgl_pinjam', '<=', $request->sampai_tanggal);
        }

        $peminjamans = $query->latest()->get();

        $totalDenda = $peminjamans->sum(function ($p) {
            return optional($p->pengembalian)->denda ?? 0;
        });

        return view('petugas.laporan.cetak', compact('peminjamans', 'totalDenda'));
    }
}