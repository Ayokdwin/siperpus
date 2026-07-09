@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-5xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('pengembalian.index') }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500
                           hover:bg-slate-100 hover:text-slate-700
                           dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200
                           transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Konfirmasi Pengembalian</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Periksa detail sebelum mengonfirmasi pengembalian buku</p>
                </div>
            </div>

            @php
                $jatuhTempo = \Carbon\Carbon::parse($peminjam->tgl_jatuh_tempo)->startOfDay();
                $hariIni    = now()->startOfDay();
                $terlambatHari = $hariIni->greaterThan($jatuhTempo)
                    ? $jatuhTempo->diffInDays($hariIni)
                    : 0;
                $dendaPerHari  = 2000;
                $estimasiDenda = $terlambatHari * $dendaPerHari;
            @endphp

            {{-- Info peminjaman --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Detail Peminjaman</h3>
                </div>

                <div class="grid grid-cols-2 gap-x-6 gap-y-4 p-6">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Peminjam</p>
                        <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">{{ $peminjam->anggota->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Tanggal Pinjam</p>
                        <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">
                            {{ \Carbon\Carbon::parse($peminjam->tgl_peminjaman)->translatedFormat('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Jatuh Tempo</p>
                        <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">
                            {{ $jatuhTempo->translatedFormat('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Status</p>
                        <p class="mt-1">
                            @if ($terlambatHari > 0)
                                <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700
                                             dark:bg-rose-500/10 dark:text-rose-400">
                                    Terlambat {{ $terlambatHari }} hari
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700
                                             dark:bg-emerald-500/10 dark:text-emerald-400">
                                    Tepat Waktu
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Daftar buku --}}
                <div class="border-t border-slate-100 px-6 py-4 dark:border-slate-800">
                    <p class="mb-3 text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Buku Dipinjam</p>
                    <div class="space-y-3">
                        @foreach ($peminjam->detailPeminjaman as $detail)
                            <div class="flex items-center gap-3">
                                @if ($detail->buku?->cover)
                                    <img src="{{ asset('storage/' . $detail->buku->cover) }}" alt="{{ $detail->buku->judul_buku }}"
                                        class="h-14 w-10 rounded-md object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                                @else
                                    <div class="flex h-14 w-10 items-center justify-center rounded-md bg-slate-100 text-slate-300
                                                dark:bg-slate-800 dark:text-slate-600">
                                        <i class="fa-solid fa-book text-sm"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                        {{ $detail->buku->judul_buku ?? '-' }}
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Jumlah: {{ $detail->jumlah }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Form konfirmasi --}}
            <form action="{{ route('pengembalian.proses', $peminjam->id) }}" method="POST"
                class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                @csrf

                <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Konfirmasi Denda</h3>
                </div>

                <div class="space-y-4 p-6">
                    <div>
                        <label class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Tanggal Pengembalian
                        </label>
                        <input type="date" name="tgl_pengembalian" value="{{ now()->toDateString() }}" required
                            class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700
                                   focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                    </div>

                    <div>
                        <label class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Denda (Rp)
                        </label>
                        <input type="number" name="denda" value="{{ $estimasiDenda }}" min="0" required
                            class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700
                                   focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                            Estimasi otomatis: {{ $terlambatHari }} hari &times; Rp{{ number_format($dendaPerHari, 0, ',', '.') }}
                            = Rp{{ number_format($estimasiDenda, 0, ',', '.') }}. Bisa diubah manual jika perlu.
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-100 px-6 py-4 dark:border-slate-800">
                    <a href="{{ route('pengembalian.index') }}"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600
                               hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                               hover:bg-emerald-700 transition-colors">
                        <i class="fa-solid fa-circle-check text-xs"></i>
                        Konfirmasi Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
