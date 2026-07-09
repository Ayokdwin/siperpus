@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-5xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('buku.index') }}"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500
                               hover:bg-slate-100 hover:text-slate-700
                               dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200
                               transition-colors">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Detail Buku</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Informasi lengkap koleksi buku</p>
                    </div>
                </div>

                <a href="{{ route('buku.edit', $buku->id) }}"
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

            {{-- Main card --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-[160px_1fr]">

                    {{-- Cover --}}
                    <div class="mx-auto sm:mx-0">
                        @if ($buku->cover)
                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul_buku }}"
                                class="h-56 w-40 rounded-lg object-cover shadow-sm ring-1 ring-slate-200 dark:ring-slate-700">
                        @else
                            <div class="flex h-56 w-40 items-center justify-center rounded-lg bg-slate-100 text-slate-300
                                        dark:bg-slate-800 dark:text-slate-600">
                                <i class="fa-solid fa-book text-4xl"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700
                                         dark:bg-indigo-500/10 dark:text-indigo-400">
                                {{ $buku->kategori->name_kategori ?? '-' }}
                            </span>
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                                @if ($buku->stok > 5)
                                    bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400
                                @elseif ($buku->stok > 0)
                                    bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                                @else
                                    bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400
                                @endif
                            ">
                                Stok: {{ $buku->stok }}
                            </span>
                        </div>

                        <h2 class="mt-3 text-lg font-semibold text-slate-900 dark:text-slate-100">
                            {{ $buku->judul_buku }}
                        </h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">oleh {{ $buku->penulis }}</p>

                        <div class="mt-5 grid grid-cols-2 gap-x-6 gap-y-4">
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Kode Buku</p>
                                <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">{{ $buku->kode_buku }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Penerbit</p>
                                <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">{{ $buku->penerbit }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Tahun Terbit</p>
                                <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">{{ $buku->tahun_terbit }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Ditambahkan</p>
                                <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">
                                    {{ $buku->created_at?->translatedFormat('d M Y') ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                @if ($buku->deskripsi)
                    <div class="border-t border-slate-100 p-6 dark:border-slate-800">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2">Deskripsi</p>
                        <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-300">{{ $buku->deskripsi }}</p>
                    </div>
                @endif
            </div>

            {{-- Riwayat peminjaman buku ini --}}
           @if ($buku->detailPeminjaman->isNotEmpty())
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Riwayat Peminjaman</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Peminjam</th>
                                    <th class="px-6 py-3 font-medium">Jumlah</th>
                                    <th class="px-6 py-3 font-medium">Tanggal Pinjam</th>
                                    <th class="px-6 py-3 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($buku->detailPeminjaman as $detail)
                                    <tr>
                                        <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                            {{ $detail->peminjaman?->anggota?->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-3 text-slate-600 dark:text-slate-300">{{ $detail->jumlah }}</td>
                                        <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                            {{ $detail->peminjaman?->tgl_peminjaman ? \Carbon\Carbon::parse($detail->peminjaman->tgl_peminjaman)->translatedFormat('d M Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-3">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium capitalize
                                                @if ($detail->peminjaman?->status === 'dikembalikan')
                                                    bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400
                                                @else
                                                    bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                                                @endif
                                            ">
                                                {{ $detail->peminjaman?->status ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Action buttons --}}
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('buku.index') }}"
                    class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-100
                           dark:text-slate-300 dark:hover:bg-slate-800
                           transition-colors">
                    &larr; Kembali ke Daftar
                </a>
                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus buku {{ $buku->judul_buku }}? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-medium text-rose-600
                               hover:bg-rose-100
                               dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20
                               transition-colors">
                        <i class="fa-solid fa-trash text-xs"></i>
                        Hapus Buku
                    </button>
                </form>
            </div>
        </div>
    </main>
@endsection
