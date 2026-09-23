<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Peminjaman Alat</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=IBM+Plex+Sans:wght@400;500&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'IBM Plex Sans', sans-serif; font-size: 12px; color: #1B1F27; margin: 28px; }
        .header { text-align: center; margin-bottom: 22px; border-bottom: 2px solid #1B1F27; padding-bottom: 12px; }
        .header h2 { font-family: 'Space Grotesk', sans-serif; font-size: 17px; letter-spacing: 0.02em; margin: 0 0 4px; }
        .header p { margin: 2px 0; color: #706B5C; }
        table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        th, td { border: 1px solid #E5E1D6; padding: 7px 9px; text-align: left; vertical-align: top; }
        th { background-color: #F9F8F5; font-weight: 500; color: #706B5C; text-transform: none; }
        td { font-family: 'IBM Plex Mono', monospace; font-size: 11.5px; }
        td:nth-child(2) { font-family: 'IBM Plex Sans', sans-serif; }
        .text-center { text-align: center; }
        .footer { margin-top: 34px; float: right; text-align: center; }
        .footer p { margin: 2px 0; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px; background: #F3F1EC; padding: 10px; border-radius: 6px; text-align: right;">
        <button onclick="window.print()" style="background: #C98A3B; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">Cetak sekarang</button>
        <button onclick="window.close()" style="background: #14181F; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500; margin-left: 6px;">Tutup</button>
    </div>

    <div class="header">
        <h2>LAPORAN PEMINJAMAN DAN PENGEMBALIAN ALAT</h2>
        <p>Sistem Informasi Manajemen Peminjaman Alat</p>
        @if($status = request('status'))
            <p style="font-size: 11px;">Status: {{ ucfirst($status) }}</p>
        @endif
        @if(request('dari_tanggal') && request('sampai_tanggal'))
            <p style="font-size: 11px;">
                Periode: {{ \Carbon\Carbon::parse(request('dari_tanggal'))->format('d-m-Y') }}
                s/d {{ \Carbon\Carbon::parse(request('sampai_tanggal'))->format('d-m-Y') }}
            </p>
        @else
            <p style="font-size: 11px;">Periode: Semua data</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Peminjam</th>
                <th width="15%">Tgl pinjam</th>
                <th width="15%">Rencana kembali</th>
                <th width="15%">Status</th>
                <th width="20%">Detail alat</th>
                <th width="10%">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ optional($item->tgl_pinjam)->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ optional($item->tgl_kembali_plan)->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($item->detailPinjam as $detail)
                                <li>{{ $detail->alat->nama_alat ?? '-' }} ({{ $detail->jumlah }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>Rp {{ number_format(optional($item->pengembalian)->denda ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Baleendah, {{ date('d F Y') }}</p>
        <p>Petugas Pengelola,</p>
        <br><br><br>
        <p><b>{{ auth()->user()->name }}</b></p>
    </div>

</body>
</html>