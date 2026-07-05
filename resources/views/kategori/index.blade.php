@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-6xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Data Kategori</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Kelola kategori buku perpustakaan</p>
                </div>

                <a href="{{ route('kategori.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                           hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-plus text-xs"></i>
                    Tambah Kategori
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

            {{-- Alert error (misal gagal hapus karena masih dipakai buku) --}}
            @if (session('error'))
                <div class="flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700
                            dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Card --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                {{-- Toolbar: search --}}
                <div class="flex items-center justify-between border-b border-slate-200 p-4 dark:border-slate-800">
                    <form method="GET" action="{{ route('kategori.index') }}" class="relative w-full sm:w-72">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama kategori..."
                            class="w-full pl-9 pr-3 py-2 rounded-lg text-sm
                                   bg-slate-100 dark:bg-slate-800
                                   border border-transparent focus:border-emerald-400 dark:focus:border-emerald-500
                                   focus:bg-white dark:focus:bg-slate-900
                                   text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                   outline-none focus:ring-2 focus:ring-emerald-100 dark:focus:ring-emerald-500/20
                                   transition-colors"
                        />
                    </form>

                    <span class="hidden sm:inline-block text-sm text-slate-500 dark:text-slate-400">
                        Total: <span class="font-medium text-slate-700 dark:text-slate-200">{{ $kategoris->total() }}</span> kategori
                    </span>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-4 py-3 font-medium w-16">#</th>
                                <th class="px-4 py-3 font-medium">Nama Kategori</th>
                                <th class="px-4 py-3 font-medium">Jumlah Buku</th>
                                <th class="px-4 py-3 font-medium">Dibuat</th>
                                <th class="px-4 py-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($kategoris as $kategori)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-4 py-3 text-slate-500 dark:text-slate-400">
                                        {{ $loop->iteration + ($kategoris->currentPage() - 1) * $kategoris->perPage() }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                                                        bg-gradient-to-br from-indigo-500 to-blue-500 text-xs font-semibold text-white">
                                                <i class="fa-solid fa-tag text-[11px]"></i>
                                            </div>
                                            <span class="font-medium text-slate-800 dark:text-slate-100">
                                                {{ $kategori->name_kategori }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600
                                                     dark:bg-slate-800 dark:text-slate-300">
                                            {{ $kategori->bukus_count ?? $kategori->bukus->count() }} buku
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-slate-500 dark:text-slate-400">
                                        {{ $kategori->created_at?->translatedFormat('d M Y') ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('kategori.show', $kategori->id) }}"
                                                title="Lihat Detail"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500
                                                       hover:bg-sky-50 hover:text-sky-600
                                                       dark:text-slate-400 dark:hover:bg-sky-500/10 dark:hover:text-sky-400
                                                       transition-colors">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </a>

                                            <a href="{{ route('kategori.edit', $kategori->id) }}"
                                                title="Edit"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500
                                                       hover:bg-emerald-50 hover:text-emerald-600
                                                       dark:text-slate-400 dark:hover:bg-emerald-500/10 dark:hover:text-emerald-400
                                                       transition-colors">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </a>

                                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori {{ $kategori->name_kategori }}?')">
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
                                    <td colspan="5" class="px-4 py-10 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fa-solid fa-tags text-2xl mb-2 block"></i>
                                        Belum ada data kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($kategoris->hasPages())
                    <div class="border-t border-slate-200 px-4 py-3 dark:border-slate-800">
                        {{ $kategoris->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
