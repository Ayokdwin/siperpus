<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjam;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        return match (Auth::user()->role) {
            'admin'   => $this->admin(),
            'petugas' => $this->petugas(),
            'anggota' => $this->anggota(),
            default   => abort(403),
        };
    }

     private function admin()
    {
        // Statistik utama
        $totalBuku = Buku::count();
        $totalStok = Buku::sum('stok');
        $totalKategori = Kategori::count();
        $totalAnggota = User::where('role', 'anggota')->count();

        $peminjamanAktif = Peminjam::where('status', 'dipinjam')->count();
        $peminjamanTerlambat = Peminjam::where('status', 'dipinjam')
            ->whereDate('tgl_jatuh_tempo', '<', now())
            ->count();

        $peminjamanBulanIni = Peminjam::whereMonth('tgl_peminjaman', now()->month)
            ->whereYear('tgl_peminjaman', now()->year)
            ->count();

        // Buku dengan stok menipis (<=5), habis duluan di atas
        $stokMenipis = Buku::where('stok', '<=', 5)
            ->orderBy('stok')
            ->take(5)
            ->get();

        // 5 peminjaman terbaru
        $peminjamanTerbaru = Peminjam::with(['anggota', 'detailPeminjaman.buku'])
            ->latest()
            ->take(5)
            ->get();

        // 5 buku paling sering dipinjam
        $bukuPopuler = Buku::withCount('detailPeminjaman')
            ->orderByDesc('detail_peminjaman_count')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalBuku',
            'totalStok',
            'totalKategori',
            'totalAnggota',
            'peminjamanAktif',
            'peminjamanTerlambat',
            'peminjamanBulanIni',
            'stokMenipis',
            'peminjamanTerbaru',
            'bukuPopuler',
        ));
    }

   private function petugas()
    {
        $hariIni = now()->startOfDay();

        // Transaksi yang diproses petugas ini hari ini
        $transaksiHariIni = Peminjam::where('petugas_id', Auth::id())
            ->whereDate('created_at', $hariIni)
            ->count();

        // Semua peminjaman aktif yang pernah dia proses (belum dikembalikan)
        $aktifDiproses = Peminjam::where('petugas_id', Auth::id())
            ->where('status', 'dipinjam')
            ->count();

        // Dari yang dia proses, berapa yang sudah lewat jatuh tempo
        $terlambatDiproses = Peminjam::where('petugas_id', Auth::id())
            ->where('status', 'dipinjam')
            ->whereDate('tgl_jatuh_tempo', '<', now())
            ->count();

        // Ada berapa item nyangkut di keranjang session dia sekarang
        $jumlahKeranjang = count(session('keranjang_pinjam', []));

        // Stok buku menipis, info umum yang berguna buat petugas juga
        $stokMenipis = Buku::where('stok', '<=', 5)
            ->orderBy('stok')
            ->take(5)
            ->get();

        // 5 transaksi terakhir yang dia proses
        $transaksiTerbaru = Peminjam::with(['anggota', 'detailPeminjaman.buku'])
            ->where('petugas_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.petugas', compact(
            'transaksiHariIni',
            'aktifDiproses',
            'terlambatDiproses',
            'jumlahKeranjang',
            'stokMenipis',
            'transaksiTerbaru',
        ));
    }

    private function anggota()
    {
        // Data buat dashboard anggota: riwayat peminjaman dia sendiri
        $peminjamanSaya = Peminjam::with('detailPeminjaman.buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $sedangDipinjam = Peminjam::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->count();

        $terlambat = Peminjam::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->whereDate('tgl_jatuh_tempo', '<', now())
            ->count();

        $totalDenda = Peminjam::where('user_id', Auth::id())
            ->where('denda', '>', 0)
            ->sum('denda');

        return view('dashboard.anggota', compact(
            'peminjamanSaya',
            'sedangDipinjam',
            'terlambat',
            'totalDenda',
        ));
    }

}
