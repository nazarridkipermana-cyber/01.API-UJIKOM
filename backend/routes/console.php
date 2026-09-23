<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Peminjaman;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Cek tiap hari jam 00:05: peminjaman yang sudah lewat tgl_kembali_plan
// tapi belum dikembalikan, otomatis ditandai status jadi 'telat'.
Schedule::call(function () {
    $hariIni = Carbon::now()->startOfDay();

    Peminjaman::where('status', 'dipinjam')
        ->whereDate('tgl_kembali_plan', '<', $hariIni)
        ->update(['status' => 'telat']);
})->dailyAt('00:05');