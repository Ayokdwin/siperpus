@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">
                        Halo, {{ Auth::user()->name }} 👋
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Ringkasan peminjaman buku kamu</p>
                </div>

                <a href="{{ route('peminjaman-buku.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                           hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-book text-xs"></i>
                    Jelajahi Katalog
                </a>
            </div>

            {{-- Alert kalau ada denda tertunggak --}}
            @if ($totalDenda > 0)
                <div class="flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700
                            dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>Kamu punya tunggakan denda sebesar <strong>Rp{{ number_format($totalDenda, 0, ',', '.') }}</strong>. Segera selesaikan di perpustakaan.</span>
                </div>
            @endif

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Sedang Dipinjam</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-50 text-sky-600 dark:bg-sky-500/10 dark:text-sky-400">
                            <i class="fa-solid fa-book-open text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $sedangDipinjam }}</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">buku belum dikembalikan</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Terlambat</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-rose-600 dark:text-rose-400">{{ $terlambat }}</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">segera dikembalikan</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Denda</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                            <i class="fa-solid fa-coins text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">
                        Rp{{ number_format($totalDenda, 0, ',', '.') }}
                    </p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">akumulasi belum dibayar</p>
                </div>
            </div>

            {{-- Riwayat peminjaman --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                    <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Peminjaman Terakhir</h2>
                    <a href="{{ route('riwayat-peminjaman.show') }}" class="text-xs font-medium text-emerald-600 hover:underline dark:text-emerald-400">
                        Lihat semua
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-4 py-3 font-medium">Buku</th>
                                <th class="px-4 py-3 font-medium">Tgl Pinjam</th>
                                <th class="px-4 py-3 font-medium">Jatuh Tempo</th>
                                <th class="px-4 py-3 font-medium">Status</th>
                                <th class="px-4 py-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($peminjamanSaya as $p)
                                @php $telat = $p->status === 'dipinjam' && $p->tgl_jatuh_tempo->lt(now()->startOfDay()); @endphp
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-4 py-3">
                                        @php $judulPertama = $p->detailPeminjaman->first()->buku->judul_buku ?? '-'; @endphp
                                        <span class="font-medium text-slate-800 dark:text-slate-100">{{ $judulPertama }}</span>
                                        @if ($p->detailPeminjaman->count() > 1)
                                            <span class="block text-xs text-slate-400">+{{ $p->detailPeminjaman->count() - 1 }} buku lainnya</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        {{ $p->tgl_peminjaman->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        {{ $p->tgl_jatuh_tempo->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                                            @if ($telat)
                                                bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400
                                            @elseif ($p->status === 'dipinjam')
                                                bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                                            @else
                                                bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400
                                            @endif
                                        ">
                                            {{ $telat ? 'Terlambat' : ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        @if ($p->status === 'dipinjam' && !$telat && !$p->diperpanjang)
                                            <a href=""
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700
                                                       hover:bg-amber-100 transition-colors
                                                       dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-400">
                                                <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                                                Perpanjang
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fa-solid fa-book-open text-2xl mb-2 block"></i>
                                        Kamu belum pernah meminjam buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection