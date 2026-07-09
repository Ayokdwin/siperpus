@extends('layouts.master')

@section('content')
<main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('pengembalian.index') }}"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200 transition-colors">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">
                    Perpanjang Peminjaman
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Perbarui tanggal jatuh tempo peminjaman buku
                </p>
            </div>
        </div>

        {{-- Detail --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                    Detail Peminjaman
                </h3>
            </div>

            <div class="grid grid-cols-2 gap-x-6 gap-y-5 p-6">
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400">Anggota</p>
                    <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">
                        {{ $peminjam->anggota->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400">Petugas</p>
                    <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">
                        {{ $peminjam->petugas->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400">Tanggal Pinjam</p>
                    <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">
                        {{ $peminjam->tgl_peminjaman->translatedFormat('d M Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400">Jatuh Tempo Lama</p>
                    <p class="mt-1">
                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                            {{ $peminjam->tgl_jatuh_tempo->translatedFormat('d M Y') }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Buku --}}
            <div class="border-t border-slate-100 px-6 py-5 dark:border-slate-800">
                <p class="mb-4 text-xs uppercase tracking-wider text-slate-400">
                    Buku Dipinjam
                </p>

                <div class="space-y-3">
                    @foreach($peminjam->detailPeminjaman as $detail)
                        <div class="flex items-center gap-3">
                            @if($detail->buku?->cover)
                                <img src="{{ asset('storage/'.$detail->buku->cover) }}"
                                    class="h-16 w-12 rounded-md object-cover">
                            @else
                                <div class="flex h-16 w-12 items-center justify-center rounded-md bg-slate-100 dark:bg-slate-800">
                                    <i class="fa-solid fa-book text-slate-400"></i>
                                </div>
                            @endif

                            <div>
                                <p class="font-medium text-slate-800 dark:text-slate-100">
                                    {{ $detail->buku->judul_buku }}
                                </p>
                                <p class="text-sm text-slate-500">
                                    Jumlah : {{ $detail->jumlah }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('pengembalian.perpanjang.update', $peminjam->id) }}" method="POST"
            class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @csrf
            @method('PUT')

            <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                    Perpanjang Masa Peminjaman
                </h3>
            </div>

            <div class="space-y-5 p-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Tanggal Jatuh Tempo Baru
                    </label>
                    <input type="date"
                        name="tgl_jatuh_tempo"
                        value="{{ old('tgl_jatuh_tempo', $peminjam->tgl_jatuh_tempo->addDays(7)->toDateString()) }}"
                        required
                        class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                </div>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-100 px-6 py-4 dark:border-slate-800">
                <a href="{{ route('pengembalian.index') }}"
                    class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-calendar-plus text-xs"></i>
                    Perpanjang
                </button>
            </div>
        </form>

    </div>
</main>
@endsection
