<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::query()
            ->withCount('bukus')
            ->when($request->search, fn($q) => $q->where('name_kategori', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_kategori' => ['required', 'string', 'max:255', 'unique:kategoris,name_kategori'],
        ]);

        Kategori::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'name_kategori' => ['required', 'string', 'max:255', 'unique:kategoris,name_kategori,' . $kategori->id],
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function show(Kategori $kategori)
    {
            $kategori->loadCount('bukus');
            $kategori->load('bukus');

            return view('kategori.show', compact('kategori'));
        }

        public function destroy(Kategori $kategori)
    {
        if ($kategori->bukus()->exists()) {
            return redirect()
                ->route('kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki buku terkait.');
        }

        try {
            $kategori->delete();

            return redirect()
                ->route('kategori.index')
                ->with('success', 'Kategori berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()
                ->route('kategori.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
}
