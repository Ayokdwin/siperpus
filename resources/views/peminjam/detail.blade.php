@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-5xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex items-center gap-3">
                <a href="{{ url()->previous() }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500
                           hover:bg-slate-100 transition-colors dark:border-slate-700 dark:text-slate-400 dark:hover:bg-slate-800">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Detail Peminjaman</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Transaksi #{{ $peminjaman->id }}</p>
                </div>
            </div>

            {{-- Status & ringkasan --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Status</p>
                        @php
                            $telat = $peminjaman->status === 'dipinjam'
                                && $peminjaman->tgl_jatuh_tempo
                                && $peminjaman->tgl_jatuh_tempo->lt(now());
                        @endphp
                        <span class="mt-1 inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium capitalize
                            @if ($peminjaman->status === 'dikembalikan')
                                bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400
                            @elseif ($telat)
                                bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400
                            @else
                                bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                            @endif
                        ">
                            {{ $telat ? 'Terlambat' : $peminjaman->status }}
                        </span>
                    </div>

                    <div class="text-right">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Petugas</p>
                        <p class="mt-1 text-sm font-medium text-slate-700 dark:text-slate-200">
                            {{ $peminjaman->petugas->name ?? '-' }}
                        </p>
                    </div>
                </div>

                {{-- Tanggal-tanggal --}}
                <div class="grid grid-cols-1 gap-4 px-6 py-4 sm:grid-cols-3">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Tanggal Pinjam</p>
                        <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-100">
                            {{ $peminjaman->tgl_peminjaman?->translatedFormat('d M Y') ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Jatuh Tempo</p>
                        <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-100">
                            {{ $peminjaman->tgl_jatuh_tempo?->translatedFormat('d M Y') ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Tanggal Kembali</p>
                        <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-100">
                            {{ optional($peminjaman->tgl_pengembalian)->translatedFormat('d M Y') ?? 'Belum dikembalikan' }}
                        </p>
                    </div>
                </div>

                {{-- Denda --}}
                <div class="border-t border-slate-100 px-6 py-4 dark:border-slate-800">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Denda</p>
                    <p class="mt-1 text-lg font-semibold {{ $peminjaman->denda ? 'text-rose-600 dark:text-rose-400' : 'text-slate-800 dark:text-slate-100' }}">
                        {{ $peminjaman->denda ? 'Rp ' . number_format($peminjaman->denda, 0, ',', '.') : 'Rp 0' }}
                    </p>
                </div>
            </div>

            {{-- Daftar buku --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-200 px-6 py-3 dark:border-slate-800">
                    <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Buku yang Dipinjam</h2>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($peminjaman->detailPeminjaman as $detail)
                        <div class="flex items-center gap-4 px-6 py-3">
                            @if ($detail->buku?->cover)
                                <img src="{{ asset('storage/' . $detail->buku->cover) }}" alt="{{ $detail->buku->judul_buku }}"
                                    class="h-16 w-12 rounded-md object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                            @else
                                <div class="flex h-16 w-12 items-center justify-center rounded-md bg-slate-100 text-slate-300
                                            dark:bg-slate-800 dark:text-slate-600">
                                    <i class="fa-solid fa-book text-sm"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-100">
                                    {{ $detail->buku->judul_buku ?? '-' }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $detail->buku->penulis ?? '-' }}
                                </p>
                            </div>
                            <span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600
                                         dark:bg-slate-800 dark:text-slate-300">
                                {{ $detail->jumlah }} eksemplar
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </main>
@endsection
