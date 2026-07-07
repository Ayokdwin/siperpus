<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\DetailPeminjam;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $bukus = Buku::query()
            ->with('kategori')
            ->when($request->search, function ($q) use ($request) {
                $q->where('judul_buku', 'like', "%{$request->search}%")
                ->orWhere('penulis', 'like', "%{$request->search}%")
                ->orWhere('kode_buku', 'like', "%{$request->search}%");
            })
            ->when($request->kategori_id, fn($q) => $q->where('kategori_id', $request->kategori_id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::orderBy('name_kategori')->get();

        $totalStok = Buku::sum('stok');
        $stokHabis = Buku::where('stok', 0)->count();

        return view('buku.index', compact('bukus', 'kategoris', 'totalStok', 'stokHabis'));
    }

    private function generateKodeBuku()
    {
        $lastBuku = Buku::whereNotNull('kode_buku')
            ->orderBy('kode_buku', 'desc')
            ->first();

        if (!$lastBuku) {
            return 'BK-0001';
        }

        $lastNumber = (int) substr($lastBuku->kode_buku, 3);

        return 'BK-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('name_kategori')->get();
        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'judul_buku' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'stok' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['kode_buku'] = $this->generateKodeBuku();

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('cover-buku', 'public');
        }

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        $kategoris = Kategori::orderBy('name_kategori')->get();

        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'kategori_id'   => ['required', 'exists:kategoris,id'],
            'judul_buku'    => ['required', 'string', 'max:255'],
            'penulis'       => ['required', 'string', 'max:255'],
            'penerbit'      => ['required', 'string', 'max:255'],
            'tahun_terbit'  => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'stok'          => ['required', 'integer', 'min:0'],
            'deskripsi'     => ['nullable', 'string'],
            'cover'         => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {

            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }

            $validated['cover'] = $request->file('cover')->store('cover-buku', 'public');
        }

        $validated['kode_buku'] = $buku->kode_buku;

        $buku->update($validated);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function show(Buku $buku)
    {
        $buku->load([
            'kategori',
            'detailPeminjaman' => fn ($q) => $q->latest()->limit(5),
            'detailPeminjaman.peminjaman.anggota',
        ]);

        return view('buku.show', compact('buku'));
    }

    public function destroy(Buku $buku)
    {
        if ($buku->detailPeminjaman()->exists()) {
            return redirect()
                ->route('buku.index')
                ->with('error', 'Buku tidak dapat dihapus karena sudah memiliki data peminjaman.');
        }

        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus.');
    }
   public function userIndex(Request $request)
{
    $query = Buku::with('kategori');

    // Search judul, penulis, atau ISBN/kode buku
    if ($request->filled('q')) {
        $search = $request->q;
        $query->where(function ($sub) use ($search) {
            $sub->where('judul_buku', 'like', "%{$search}%")
                ->orWhere('penulis', 'like', "%{$search}%")
                ->orWhere('kode_buku', 'like', "%{$search}%");
        });
    }

    // Filter kategori
    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    // Filter penulis
    if ($request->filled('penulis')) {
        $query->where('penulis', $request->penulis);
    }

    // Filter ketersediaan
    if ($request->tersedia === 'tersedia') {
        $query->where('stok', '>', 0);
    } elseif ($request->tersedia === 'habis') {
        $query->where('stok', '<=', 0);
    }

    // Sorting
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
        default: // terbaru
            $query->orderBy('created_at', 'desc');
            break;
    }

    $bukus = $query->paginate(10);

    // Data untuk dropdown filter
    $kategoris = Kategori::orderBy('name_kategori')->get();
    $penulisList = Buku::select('penulis')->distinct()->orderBy('penulis')->pluck('penulis');

    return view('buku.user.index', compact('bukus', 'kategoris', 'penulisList'));
}
public function userShow($id)
{
    $buku = Buku::with('kategori')->findOrFail($id);
 
    $bukuTerkait = Buku::where('kategori_id', $buku->kategori_id)
        ->where('id', '!=', $buku->id)
        ->take(5)
        ->get();
 
    return view('buku.user.show', compact('buku', 'bukuTerkait'));
}


}
