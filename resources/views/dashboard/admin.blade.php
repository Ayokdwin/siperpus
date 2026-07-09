@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Page header --}}
            <div>
                <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Dashboard</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Ringkasan aktivitas perpustakaan hari ini</p>
            </div>

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Buku</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                            <i class="fa-solid fa-book text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $totalBuku }}</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $totalStok }} eksemplar total</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Anggota</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-50 text-sky-600 dark:bg-sky-500/10 dark:text-sky-400">
                            <i class="fa-solid fa-users text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $totalAnggota }}</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $totalKategori }} kategori buku</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Peminjaman Aktif</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                            <i class="fa-solid fa-arrow-right-arrow-left text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $peminjamanAktif }}</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $peminjamanBulanIni }} transaksi bulan ini</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Terlambat</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-rose-600 dark:text-rose-400">{{ $peminjamanTerlambat }}</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">perlu ditagih dendanya</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                {{-- Peminjaman terbaru --}}
                <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Peminjaman Terbaru</h2>
                        <a href="{{ route('pengembalian.index') }}" class="text-xs font-medium text-emerald-600 hover:underline dark:text-emerald-400">
                            Lihat semua
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                                <tr>
                                    <th class="px-4 py-3 font-medium">Anggota</th>
                                    <th class="px-4 py-3 font-medium">Buku</th>
                                    <th class="px-4 py-3 font-medium">Jatuh Tempo</th>
                                    <th class="px-4 py-3 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse ($peminjamanTerbaru as $p)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="px-4 py-3">
                                            <span class="font-medium text-slate-800 dark:text-slate-100">
                                                {{ $p->anggota->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                            @php $judulPertama = $p->detailPeminjaman->first()->buku->judul_buku ?? '-'; @endphp
                                            {{ $judulPertama }}
                                            @if ($p->detailPeminjaman->count() > 1)
                                                <span class="text-xs text-slate-400">+{{ $p->detailPeminjaman->count() - 1 }} lainnya</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                            {{ $p->tgl_jatuh_tempo->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                                                @if ($p->status === 'dipinjam' && $p->tgl_jatuh_tempo->lt(now()->startOfDay()))
                                                    bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400
                                                @elseif ($p->status === 'dipinjam')
                                                    bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                                                @else
                                                    bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400
                                                @endif
                                            ">
                                                @if ($p->status === 'dipinjam' && $p->tgl_jatuh_tempo->lt(now()->startOfDay()))
                                                    Terlambat
                                                @else
                                                    {{ ucfirst($p->status) }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-10 text-center text-slate-400 dark:text-slate-500">
                                            <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                                            Belum ada transaksi peminjaman.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Sidebar kanan: stok menipis + buku populer --}}
                <div class="space-y-6">

                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                            <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Stok Menipis</h2>
                            <a href="{{ route('buku.index') }}" class="text-xs font-medium text-emerald-600 hover:underline dark:text-emerald-400">
                                Kelola
                            </a>
                        </div>
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($stokMenipis as $buku)
                                <li class="flex items-center justify-between px-4 py-3">
                                    <span class="text-sm text-slate-700 dark:text-slate-200 truncate pr-2">{{ $buku->judul_buku }}</span>
                                    <span class="shrink-0 inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                                        @if ($buku->stok > 0)
                                            bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                                        @else
                                            bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400
                                        @endif
                                    ">
                                        {{ $buku->stok }}
                                    </span>
                                </li>
                            @empty
                                <li class="px-4 py-6 text-center text-sm text-slate-400 dark:text-slate-500">
                                    Stok semua buku aman.
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                            <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Buku Terpopuler</h2>
                        </div>
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($bukuPopuler as $i => $buku)
                                <li class="flex items-center gap-3 px-4 py-3">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-500
                                                 dark:bg-slate-800 dark:text-slate-400">
                                        {{ $i + 1 }}
                                    </span>
                                    <span class="text-sm text-slate-700 dark:text-slate-200 truncate">{{ $buku->judul_buku }}</span>
                                    <span class="ml-auto shrink-0 text-xs text-slate-400 dark:text-slate-500">
                                        {{ $buku->detail_peminjaman_count }}x
                                    </span>
                                </li>
                            @empty
                                <li class="px-4 py-6 text-center text-sm text-slate-400 dark:text-slate-500">
                                    Belum ada data peminjaman.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection