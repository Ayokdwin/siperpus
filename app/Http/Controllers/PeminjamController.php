<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\DetailPeminjam;
use App\Models\Buku;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamController extends Controller
{
    public function riwayat()
    {
        $peminjams = Peminjam::where('user_id',Auth::id())->where('status','dikembalikan')->get();
        return view('peminjam.riwayat',compact('peminjams'));
    }

    public function detail($id)
    {
        $peminjaman = Peminjam::with(['anggota', 'petugas', 'detailPeminjaman.buku'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('peminjam.detail', compact('peminjaman'));
    }

    public function show()
{
    $peminjams = Peminjam::where('user_id', Auth::id())
        ->where('status', 'dipinjam')
        ->get();

    return view('peminjam.mypinjaman', compact('peminjams'));
}
    public function index(Request $request)
{
    $query = Buku::with('kategori');

    if ($request->filled('q')) {
        $search = $request->q;
        $query->where(function ($sub) use ($search) {
            $sub->where('judul_buku', 'like', "%{$search}%")
                ->orWhere('penulis', 'like', "%{$search}%")
                ->orWhere('kode_buku', 'like', "%{$search}%");
        });
    }

    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    if ($request->filled('penulis')) {
        $query->where('penulis', $request->penulis);
    }

    if ($request->tersedia === 'tersedia') {
        $query->where('stok', '>', 0);
    } elseif ($request->tersedia === 'habis') {
        $query->where('stok', '<=', 0);
    }

    switch ($request->get('sort', 'terbaru')) {
        case 'judul_asc':
            $query->orderBy('judul_buku', 'asc');
            break;
        case 'judul_desc':
            $query->orderBy('judul_buku', 'desc');
            break;
        case 'stok_desc':
            $query->orderBy('stok', 'desc');
            break;
        default:
            $query->orderBy('created_at', 'desc');
            break;
    }

    $bukus = $query->paginate(10);

    $kategoris = Kategori::orderBy('name_kategori')->get();
    $penulisList = Buku::select('penulis')->distinct()->orderBy('penulis')->pluck('penulis');

    return view('peminjam.index', compact('bukus', 'kategoris', 'penulisList'));
}
public function tambahKeranjang(Request $request, Buku $buku)
    {
        $jumlah = max(1, (int) $request->input('jumlah', 1));

        $keranjang = session('keranjang_pinjam', []);
        $keranjang[$buku->id] = ($keranjang[$buku->id] ?? 0) + $jumlah;
        session(['keranjang_pinjam' => $keranjang]);

        return back()->with('success', "\"{$buku->judul_buku}\" ditambahkan ke keranjang.");
    }
    public function hapusKeranjang(Buku $buku)
    {
        $keranjang = session('keranjang_pinjam', []);
        unset($keranjang[$buku->id]);
        session(['keranjang_pinjam' => $keranjang]);

        return back()->with('success', 'Buku dikeluarkan dari keranjang.');
    }
    public function checkout()
    {
        $keranjang = session('keranjang_pinjam', []);

        if (empty($keranjang)) {
            return redirect()->route('peminjaman-buku.index')->with('error', 'Keranjang masih kosong.');
        }

        $bukus = Buku::whereIn('id', array_keys($keranjang))->get();

        $anggotas = User::where('role', 'anggota')->orderBy('name')->get();

        return view('peminjam.checkout', compact('bukus', 'keranjang', 'anggotas'));
    }
    public function prosesPeminjaman(Request $request)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'tgl_jatuh_tempo'  => 'required|date|after:today',
        ]);

        $keranjang = session('keranjang_pinjam', []);

        if (empty($keranjang)) {
            return redirect()->route('peminjam.index')->with('error', 'Keranjang kosong, tidak ada yang diproses.');
        }

        try {
            DB::transaction(function () use ($request, $keranjang) {
                $peminjam = Peminjam::create([
                    'user_id'          => $request->user_id,
                    'petugas_id'       => Auth::id(),
                    'tgl_peminjaman'   => now(),
                    'tgl_jatuh_tempo'  => $request->tgl_jatuh_tempo,
                    'status'           => 'dipinjam',
                ]);

                foreach ($keranjang as $bukuId => $jumlah) {
                    $buku = Buku::lockForUpdate()->findOrFail($bukuId);

                    if ($buku->stok < $jumlah) {
                        throw new \RuntimeException("Stok \"{$buku->judul_buku}\" tidak mencukupi.");
                    }

                    DetailPeminjam::create([
                        'peminjaman_id' => $peminjam->id,
                        'buku_id'       => $bukuId,
                        'jumlah'        => $jumlah,
                    ]);

                    $buku->decrement('stok', $jumlah);
                }
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        session()->forget('keranjang_pinjam');

        return redirect()->route('pengembalian.index')->with('success', 'Peminjaman berhasil diproses.');
    }
}
