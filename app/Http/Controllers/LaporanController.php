<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tglMulai = $request->filled('tgl_mulai')
            ? Carbon::parse($request->tgl_mulai)->startOfDay()
            : Carbon::now()->startOfMonth();

        $tglSelesai = $request->filled('tgl_selesai')
            ? Carbon::parse($request->tgl_selesai)->endOfDay()
            : Carbon::now()->endOfDay();

        $status = $request->get('status', 'semua');

        $query = Peminjam::with(['anggota', 'petugas', 'detailPeminjaman.buku'])
            ->whereBetween('tgl_peminjaman', [$tglMulai, $tglSelesai]);

        if ($status === 'dipinjam') {
            $query->where('status', 'dipinjam');
        } elseif ($status === 'dikembalikan') {
            $query->where('status', 'dikembalikan');
        } elseif ($status === 'terlambat') {
            $query->where('status', 'dipinjam')
                  ->whereDate('tgl_jatuh_tempo', '<', now());
        }

        $peminjams = $query->orderByDesc('tgl_peminjaman')->get();

        $totalTransaksi = $peminjams->count();
        $totalDipinjam = $peminjams->where('status', 'dipinjam')->count();
        $totalDikembalikan = $peminjams->where('status', 'dikembalikan')->count();
        $totalTerlambat = $peminjams->filter(function ($p) {
            return $p->status === 'dipinjam' && $p->tgl_jatuh_tempo && $p->tgl_jatuh_tempo->lt(now());
        })->count();
        $totalDenda = $peminjams->sum('denda');
        $totalEksemplarDipinjam = $peminjams->sum(function ($p) {
            return $p->detailPeminjaman->sum('jumlah');
        });

        $bukuPopuler = Buku::with('kategori')
            ->withCount(['detailPeminjaman as total_dipinjam' => function ($q) use ($tglMulai, $tglSelesai) {
                $q->whereHas('peminjaman', function ($sub) use ($tglMulai, $tglSelesai) {
                    $sub->whereBetween('tgl_peminjaman', [$tglMulai, $tglSelesai]);
                });
            }])
            ->orderByDesc('total_dipinjam')
            ->take(5)
            ->get()
            ->filter(fn ($b) => $b->total_dipinjam > 0)
            ->values();

        $anggotaAktif = User::where('role', 'anggota')
            ->withCount(['peminjam as total_peminjaman' => function ($q) use ($tglMulai, $tglSelesai) {
                $q->whereBetween('tgl_peminjaman', [$tglMulai, $tglSelesai]);
            }])
            ->orderByDesc('total_peminjaman')
            ->take(5)
            ->get()
            ->filter(fn ($u) => $u->total_peminjaman > 0)
            ->values();

        $totalBuku = Buku::count();
        $totalStok = Buku::sum('stok');
        $totalKategori = Kategori::count();
        $stokMenipis = Buku::where('stok', '<=', 5)->orderBy('stok')->take(5)->get();

        return view('laporan.index', compact(
            'peminjams',
            'tglMulai',
            'tglSelesai',
            'status',
            'totalTransaksi',
            'totalDipinjam',
            'totalDikembalikan',
            'totalTerlambat',
            'totalDenda',
            'totalEksemplarDipinjam',
            'bukuPopuler',
            'anggotaAktif',
            'totalBuku',
            'totalStok',
            'totalKategori',
            'stokMenipis',
        ));
    }

    public function cetak(Request $request)
    {
        $tglMulai = $request->filled('tgl_mulai')
            ? Carbon::parse($request->tgl_mulai)->startOfDay()
            : Carbon::now()->startOfMonth();

        $tglSelesai = $request->filled('tgl_selesai')
            ? Carbon::parse($request->tgl_selesai)->endOfDay()
            : Carbon::now()->endOfDay();

        $status = $request->get('status', 'semua');

        $query = Peminjam::with(['anggota', 'petugas', 'detailPeminjaman.buku'])
            ->whereBetween('tgl_peminjaman', [$tglMulai, $tglSelesai]);

        if ($status === 'dipinjam') {
            $query->where('status', 'dipinjam');
        } elseif ($status === 'dikembalikan') {
            $query->where('status', 'dikembalikan');
        } elseif ($status === 'terlambat') {
            $query->where('status', 'dipinjam')
                  ->whereDate('tgl_jatuh_tempo', '<', now());
        }

        $peminjams = $query->orderByDesc('tgl_peminjaman')->get();

        $totalTransaksi = $peminjams->count();
        $totalDipinjam = $peminjams->where('status', 'dipinjam')->count();
        $totalDikembalikan = $peminjams->where('status', 'dikembalikan')->count();
        $totalDenda = $peminjams->sum('denda');

        return view('laporan.cetak', compact(
            'peminjams',
            'tglMulai',
            'tglSelesai',
            'status',
            'totalTransaksi',
            'totalDipinjam',
            'totalDikembalikan',
            'totalDenda',
        ));
    }
}
