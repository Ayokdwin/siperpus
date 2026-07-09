@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-5xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('kategori.index') }}"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500
                               hover:bg-slate-100 hover:text-slate-700
                               dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200
                               transition-colors">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Detail Kategori</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Informasi kategori dan daftar buku terkait</p>
                    </div>
                </div>

                <a href="{{ route('kategori.edit', $kategori->id) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                           hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-pen text-xs"></i>
                    Edit
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

            {{-- Info card --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex flex-col items-center gap-4 p-6 text-center sm:flex-row sm:text-left">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl
                                bg-gradient-to-br from-indigo-500 to-blue-500 text-2xl text-white">
                        <i class="fa-solid fa-tag"></i>
                    </div>

                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                            {{ $kategori->name_kategori }}
                        </h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Dibuat pada {{ $kategori->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}
                        </p>
                    </div>

                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600
                                 dark:bg-slate-800 dark:text-slate-300">
                        {{ $kategori->bukus_count ?? $kategori->bukus->count() }} buku
                    </span>
                </div>
            </div>

            {{-- Daftar buku dalam kategori --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Daftar Buku dalam Kategori Ini</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-6 py-3 font-medium w-16">#</th>
                                <th class="px-6 py-3 font-medium">Kode Buku</th>
                                <th class="px-6 py-3 font-medium">Judul</th>
                                <th class="px-6 py-3 font-medium">Penulis</th>
                                <th class="px-6 py-3 font-medium">Stok</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($kategori->bukus as $buku)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-3 text-slate-500 dark:text-slate-400">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-3 text-slate-600 dark:text-slate-300">{{ $buku->kode_buku }}</td>
                                    <td class="px-6 py-3 font-medium text-slate-800 dark:text-slate-100">{{ $buku->judul_buku }}</td>
                                    <td class="px-6 py-3 text-slate-600 dark:text-slate-300">{{ $buku->penulis }}</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                                            @if ($buku->stok > 0)
                                                bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400
                                            @else
                                                bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400
                                            @endif
                                        ">
                                            {{ $buku->stok }} tersedia
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fa-solid fa-book-open text-2xl mb-2 block"></i>
                                        Belum ada buku dalam kategori ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('kategori.index') }}"
                    class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-100
                           dark:text-slate-300 dark:hover:bg-slate-800
                           transition-colors">
                    &larr; Kembali ke Daftar
                </a>

                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus kategori {{ $kategori->name_kategori }}? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-medium text-rose-600
                               hover:bg-rose-100
                               dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20
                               transition-colors">
                        <i class="fa-solid fa-trash text-xs"></i>
                        Hapus Kategori
                    </button>
                </form>
            </div>
        </div>
    </main>
@endsection
