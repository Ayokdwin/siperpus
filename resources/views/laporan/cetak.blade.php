<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Perpustakaan - {{ $tglMulai->format('d-m-Y') }} s.d {{ $tglSelesai->format('d-m-Y') }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1e293b;
            padding: 32px;
            font-size: 13px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #10b981;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0 0 4px 0;
            font-size: 20px;
            color: #0f172a;
        }
        .header p {
            margin: 0;
            color: #64748b;
            font-size: 12px;
        }
        .header .meta {
            text-align: right;
            font-size: 12px;
            color: #64748b;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        .summary .box {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 12px;
        }
        .summary .box .label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        .summary .box .value {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        thead th {
            background: #f1f5f9;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #64748b;
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 12px;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
        }
        .badge-green { background: #d1fae5; color: #047857; }
        .badge-amber { background: #fef3c7; color: #b45309; }
        .badge-red   { background: #fee2e2; color: #b91c1c; }

        .footer {
            margin-top: 32px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #94a3b8;
        }

        .print-btn {
            position: fixed;
            top: 16px;
            right: 16px;
            background: #10b981;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
        }

        @media print {
            .print-btn { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">Cetak / Simpan sebagai PDF</button>

    <div class="header">
        <div>
            <h1>Laporan Perpustakaan</h1>
            <p>{{ config('app.name', 'SiPerpus') }} &mdash; Sistem Informasi Perpustakaan</p>
        </div>
        <div class="meta">
            <div>Periode: {{ $tglMulai->translatedFormat('d M Y') }} &ndash; {{ $tglSelesai->translatedFormat('d M Y') }}</div>
            <div>Status: {{ ucfirst($status) }}</div>
            <div>Dicetak: {{ now()->translatedFormat('d M Y, H:i') }} WIB</div>
        </div>
    </div>

    <div class="summary">
        <div class="box">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $totalTransaksi }}</div>
        </div>
        <div class="box">
            <div class="label">Dikembalikan</div>
            <div class="value">{{ $totalDikembalikan }}</div>
        </div>
        <div class="box">
            <div class="label">Sedang Dipinjam</div>
            <div class="value">{{ $totalDipinjam }}</div>
        </div>
        <div class="box">
            <div class="label">Total Denda</div>
            <div class="value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Anggota</th>
                <th>Petugas</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjams as $i => $p)
                @php
                    $telat = $p->status === 'dipinjam' && $p->tgl_jatuh_tempo && $p->tgl_jatuh_tempo->lt(now());
                    $judulBuku = $p->detailPeminjaman->pluck('buku.judul_buku')->filter()->implode(', ');
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->anggota->name ?? '-' }}</td>
                    <td>{{ $p->petugas->name ?? '-' }}</td>
                    <td>{{ $judulBuku ?: '-' }}</td>
                    <td>{{ $p->tgl_peminjaman->translatedFormat('d M Y') }}</td>
                    <td>{{ $p->tgl_jatuh_tempo->translatedFormat('d M Y') }}</td>
                    <td>{{ optional($p->tgl_pengembalian)->translatedFormat('d M Y') ?? '-' }}</td>
                    <td>{{ $p->denda ? 'Rp ' . number_format($p->denda, 0, ',', '.') : '-' }}</td>
                    <td>
                        @if ($p->status === 'dikembalikan')
                            <span class="badge badge-green">Dikembalikan</span>
                        @elseif ($telat)
                            <span class="badge badge-red">Terlambat</span>
                        @else
                            <span class="badge badge-amber">Dipinjam</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding: 24px; color:#94a3b8;">
                        Tidak ada transaksi pada periode dan filter yang dipilih.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <span>Laporan ini dibuat otomatis oleh sistem.</span>
        <span>Halaman 1</span>
    </div>

</body>
</html>
