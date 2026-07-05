@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Data Buku</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Kelola koleksi buku perpustakaan</p>
                </div>

                <a href="{{ route('buku.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                           hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-plus text-xs"></i>
                    Tambah Buku
                </a>
            </div>

            {{-- Alert sukses --}}
            @if (session('success'))
                <div class="flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700
                            dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Alert error --}}
            @if (session('error'))
                <div class="flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700
                            dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Ringkasan cepat --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Judul</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $bukus->total() }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Stok</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $totalStok ?? $bukus->sum('stok') }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Stok Habis</p>
                    <p class="mt-1 text-2xl font-semibold text-rose-600 dark:text-rose-400">
                        {{ $stokHabis ?? $bukus->where('stok', 0)->count() }}
                    </p>
                </div>
            </div>

            {{-- Card --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                {{-- Toolbar: search + filter kategori --}}
                <div class="flex flex-col gap-3 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-800">
                    <form method="GET" action="{{ route('buku.index') }}" class="relative w-full sm:w-72">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari judul, penulis, atau kode buku..."
                            class="w-full pl-9 pr-3 py-2 rounded-lg text-sm
                                   bg-slate-100 dark:bg-slate-800
                                   border border-transparent focus:border-emerald-400 dark:focus:border-emerald-500
                                   focus:bg-white dark:focus:bg-slate-900
                                   text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                   outline-none focus:ring-2 focus:ring-emerald-100 dark:focus:ring-emerald-500/20
                                   transition-colors"
                        />
                    </form>

                    <div class="flex items-center gap-2">
                        <label for="kategori_id" class="text-sm text-slate-500 dark:text-slate-400 shrink-0">Kategori:</label>
                        <select
                            id="kategori_id"
                            onchange="window.location.href = this.value"
                            class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20">
                            <option value="{{ route('buku.index', array_filter(['search' => request('search')])) }}"
                                {{ request('kategori_id') ? '' : 'selected' }}>Semua Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ route('buku.index', array_filter(['search' => request('search'), 'kategori_id' => $kategori->id])) }}"
                                    {{ (string) request('kategori_id') === (string) $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->name_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-4 py-3 font-medium">#</th>
                                <th class="px-4 py-3 font-medium">Cover</th>
                                <th class="px-4 py-3 font-medium">Kode</th>
                                <th class="px-4 py-3 font-medium">Judul</th>
                                <th class="px-4 py-3 font-medium">Penulis</th>
                                <th class="px-4 py-3 font-medium">Kategori</th>
                                <th class="px-4 py-3 font-medium">Tahun</th>
                                <th class="px-4 py-3 font-medium">Stok</th>
                                <th class="px-4 py-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($bukus as $buku)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-4 py-3 text-slate-500 dark:text-slate-400">
                                        {{ $loop->iteration + ($bukus->currentPage() - 1) * $bukus->perPage() }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($buku->cover)
                                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul_buku }}"
                                                class="h-12 w-9 rounded object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                                        @else
                                            <div class="flex h-12 w-9 items-center justify-center rounded bg-slate-100 text-slate-400
                                                        dark:bg-slate-800 dark:text-slate-600">
                                                <i class="fa-solid fa-book text-xs"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $buku->kode_buku }}</td>

                                    <td class="px-4 py-3">
                                        <span class="font-medium text-slate-800 dark:text-slate-100">{{ $buku->judul_buku }}</span>
                                    </td>

                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $buku->penulis }}</td>

                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700
                                                     dark:bg-indigo-500/10 dark:text-indigo-400">
                                            {{ $buku->kategori->name_kategori ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $buku->tahun_terbit }}</td>

                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                                            @if ($buku->stok > 5)
                                                bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400
                                            @elseif ($buku->stok > 0)
                                                bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                                            @else
                                                bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400
                                            @endif
                                        ">
                                            {{ $buku->stok }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('buku.show', $buku->id) }}"
                                                title="Lihat Detail"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500
                                                       hover:bg-sky-50 hover:text-sky-600
                                                       dark:text-slate-400 dark:hover:bg-sky-500/10 dark:hover:text-sky-400
                                                       transition-colors">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </a>

                                            <a href="{{ route('buku.edit', $buku->id) }}"
                                                title="Edit"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500
                                                       hover:bg-emerald-50 hover:text-emerald-600
                                                       dark:text-slate-400 dark:hover:bg-emerald-500/10 dark:hover:text-emerald-400
                                                       transition-colors">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </a>

                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus buku {{ $buku->judul_buku }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500
                                                           hover:bg-rose-50 hover:text-rose-600
                                                           dark:text-slate-400 dark:hover:bg-rose-500/10 dark:hover:text-rose-400
                                                           transition-colors">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-10 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fa-solid fa-book-open text-2xl mb-2 block"></i>
                                        Belum ada data buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($bukus->hasPages())
                    <div class="border-t border-slate-200 px-4 py-3 dark:border-slate-800">
                        {{ $bukus->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
