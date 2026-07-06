@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-6xl mx-auto space-y-6">

            {{-- Page header --}}
            <div>
                <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Peminjaman Saya</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Daftar buku yang sedang Anda pinjam</p>
            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700
                            dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700
                            dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Daftar peminjaman --}}
            @if ($peminjams->count())
                <div class="space-y-4">
                    @foreach ($peminjams as $peminjaman)
                        <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                            {{-- Header --}}
                            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                        Tanggal Pinjam
                                    </p>
                                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200">
                                        {{ $peminjaman->tanggal_pinjam?->translatedFormat('d M Y') ?? '-' }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium capitalize
                                        @if ($peminjaman->status === 'dipinjam')
                                            bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                                        @elseif ($peminjaman->status === 'terlambat')
                                            bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400
                                        @else
                                            bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300
                                        @endif
                                    ">
                                        {{ $peminjaman->status }}
                                    </span>

                                    @if ($peminjaman->status === 'dipinjam')
                                        <form action="" method="POST"
                                            onsubmit="return confirm('Batalkan pengajuan peminjaman ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-medium text-rose-600
                                                       hover:bg-rose-100 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400
                                                       dark:hover:bg-rose-500/20 transition-colors">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            {{-- Buku yang dipinjam --}}
                            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($peminjaman->detailPeminjaman as $detail)
                                    <div class="flex items-center gap-4 px-6 py-3">
                                        @if ($detail->buku?->cover)
                                            <img src="{{ asset('storage/' . $detail->buku->cover) }}" alt="{{ $detail->buku->judul_buku }}"
                                                class="h-14 w-10 rounded-md object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                                        @else
                                            <div class="flex h-14 w-10 items-center justify-center rounded-md bg-slate-100 text-slate-300
                                                        dark:bg-slate-800 dark:text-slate-600">
                                                <i class="fa-solid fa-book text-sm"></i>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                                {{ $detail->buku->judul_buku ?? '-' }}
                                            </p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                Jumlah: {{ $detail->jumlah }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Batas kembali --}}
                            <div class="border-t border-slate-100 px-6 py-3 dark:border-slate-800">
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Batas pengembalian:
                                    <span class="font-medium text-slate-700 dark:text-slate-200">
                                        {{ $peminjaman->tanggal_kembali_rencana?->translatedFormat('d M Y') ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-2">
               
                </div>
            @else
                {{-- Empty state --}}
                <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-slate-200 bg-white py-16
                            dark:border-slate-800 dark:bg-slate-900">
                    <i class="fa-solid fa-bookmark text-4xl text-slate-300 dark:text-slate-600"></i>
                    <p class="mt-3 text-sm font-medium text-slate-600 dark:text-slate-300">Belum ada peminjaman aktif</p>
                    <p class="text-sm text-slate-400 dark:text-slate-500">Jelajahi katalog buku dan mulai pinjam koleksi favoritmu</p>
                    <a href="{{ route('katalog-buku.index') }}"
                        class="mt-4 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 transition-colors">
                        Lihat Katalog Buku
                    </a>
                </div>
            @endif
        </div>
    </main>
@endsection