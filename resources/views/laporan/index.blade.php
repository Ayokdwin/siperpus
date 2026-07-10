@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Laporan Perpustakaan</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Ringkasan peminjaman, pengembalian, dan aktivitas koleksi buku
                    </p>
                </div>

                <a href="{{ route('laporan.cetak', request()->query()) }}" target="_blank"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm
                           hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-print text-xs"></i>
                    Cetak / Export PDF
                </a>
            </div>

            {{-- FILTER --}}
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <form method="GET" action="{{ route('laporan.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-slate-500 dark:text-slate-400">Dari Tanggal</label>
                        <input type="date" name="tgl_mulai" value="{{ $tglMulai->format('Y-m-d') }}"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700
                                   focus:border-emerald-400 focus:bg-white focus:ring-2 focus:ring-emerald-100 outline-none transition-colors
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-900" />
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-medium text-slate-500 dark:text-slate-400">Sampai Tanggal</label>
                        <input type="date" name="tgl_selesai" value="{{ $tglSelesai->format('Y-m-d') }}"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700
                                   focus:border-emerald-400 focus:bg-white focus:ring-2 focus:ring-emerald-100 outline-none transition-colors
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-900" />
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-medium text-slate-500 dark:text-slate-400">Status</label>
                        <select name="status"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700
                                   focus:border-emerald-400 focus:bg-white focus:ring-2 focus:ring-emerald-100 outline-none transition-colors
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-900">
                            <option value="semua" {{ $status === 'semua' ? 'selected' : '' }}>Semua Status</option>
                            <option value="dipinjam" {{ $status === 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                            <option value="dikembalikan" {{ $status === 'dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                            <option value="terlambat" {{ $status === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white
                                   hover:bg-emerald-700 transition-colors dark:bg-emerald-600 dark:hover:bg-emerald-700">
                            <i class="fa-solid fa-filter text-xs"></i>
                            Terapkan
                        </button>
                        <a href="{{ route('laporan.index') }}"
                            title="Reset filter"
                            class="flex h-[38px] w-[38px] items-center justify-center rounded-lg border border-slate-200 text-slate-500
                                   hover:bg-slate-50 transition-colors dark:border-slate-700 dark:text-slate-400 dark:hover:bg-slate-800">
                            <i class="fa-solid fa-rotate-right text-xs"></i>
                        </a>
                    </div>
                </form>

                <p class="mt-3 text-xs text-slate-400 dark:text-slate-500">
                    Menampilkan data periode
                    <span class="font-medium text-slate-600 dark:text-slate-300">{{ $tglMulai->translatedFormat('d M Y') }}</span>
                    &ndash;
                    <span class="font-medium text-slate-600 dark:text-slate-300">{{ $tglSelesai->translatedFormat('d M Y') }}</span>
                </p>
            </div>

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Transaksi</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                            <i class="fa-solid fa-book-open-reader text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $totalTransaksi }}</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $totalEksemplarDipinjam }} eksemplar dipinjam</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Sudah Dikembalikan</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                            <i class="fa-solid fa-circle-check text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $totalDikembalikan }}</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $totalDipinjam }} masih dipinjam</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Terlambat</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-rose-600 dark:text-rose-400">{{ $totalTerlambat }}</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">belum dikembalikan &amp; lewat tempo</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Denda</p>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                            <i class="fa-solid fa-coins text-sm"></i>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-semibold text-slate-800 dark:text-slate-100">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">terkumpul pada periode ini</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


                {{-- BUKU TERPOPULER --}}

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Buku Terpopuler</h2>
                        <p class="text-xs text-slate-400 dark:text-slate-500">Paling sering dipinjam pada periode ini</p>
                    </div>

                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($bukuPopuler as $i => $buku)
                            <div class="flex items-center gap-3 px-4 py-3">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-500
                                             dark:bg-slate-800 dark:text-slate-400">
                                    {{ $i + 1 }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-100">{{ $buku->judul_buku }}</p>
                                    <p class="truncate text-xs text-slate-400 dark:text-slate-500">{{ $buku->kategori->name_kategori ?? '-' }}</p>
                                </div>
                                <span class="shrink-0 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700
                                             dark:bg-emerald-500/10 dark:text-emerald-400">
                                    {{ $buku->total_dipinjam }}x
                                </span>
                            </div>
                        @empty
                            <div class="px-4 py-8 text-center text-sm text-slate-400 dark:text-slate-500">
                                <i class="fa-solid fa-book mb-2 block text-2xl"></i>
                                Belum ada peminjaman pada periode ini.
                            </div>
                        @endforelse
                    </div>
                </div>


                {{-- ANGGOTA TERAKTIF --}}

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Anggota Paling Aktif</h2>
                        <p class="text-xs text-slate-400 dark:text-slate-500">Berdasarkan jumlah transaksi peminjaman</p>
                    </div>

                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($anggotaAktif as $i => $anggota)
                            <div class="flex items-center gap-3 px-4 py-3">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-500
                                             dark:bg-slate-800 dark:text-slate-400">
                                    {{ $i + 1 }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-100">{{ $anggota->name }}</p>
                                    <p class="truncate text-xs text-slate-400 dark:text-slate-500">{{ $anggota->kode_anggota ?? $anggota->email }}</p>
                                </div>
                                <span class="shrink-0 rounded-full bg-sky-50 px-2.5 py-1 text-xs font-medium text-sky-700
                                             dark:bg-sky-500/10 dark:text-sky-400">
                                    {{ $anggota->total_peminjaman }}x
                                </span>
                            </div>
                        @empty
                            <div class="px-4 py-8 text-center text-sm text-slate-400 dark:text-slate-500">
                                <i class="fa-solid fa-users mb-2 block text-2xl"></i>
                                Belum ada peminjaman pada periode ini.
                            </div>
                        @endforelse
                    </div>
                </div>


                {{-- KOLEKSI & STOK --}}

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                        <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Ringkasan Koleksi</h2>
                        <p class="text-xs text-slate-400 dark:text-slate-500">Kondisi stok buku saat ini</p>
                    </div>

                    <div class="grid grid-cols-3 gap-2 px-4 py-3">
                        <div class="rounded-lg bg-slate-50 p-3 text-center dark:bg-slate-800/60">
                            <p class="text-lg font-semibold text-slate-800 dark:text-slate-100">{{ $totalBuku }}</p>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500">Judul Buku</p>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-3 text-center dark:bg-slate-800/60">
                            <p class="text-lg font-semibold text-slate-800 dark:text-slate-100">{{ $totalStok }}</p>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500">Total Eksemplar</p>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-3 text-center dark:bg-slate-800/60">
                            <p class="text-lg font-semibold text-slate-800 dark:text-slate-100">{{ $totalKategori }}</p>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500">Kategori</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 px-4 py-3 dark:border-slate-800">
                        <p class="mb-2 text-xs font-medium text-slate-500 dark:text-slate-400">Stok Menipis (≤ 5)</p>
                        <div class="space-y-2">
                            @forelse ($stokMenipis as $buku)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="truncate text-slate-700 dark:text-slate-200">{{ $buku->judul_buku }}</span>
                                    <span class="shrink-0 rounded-full bg-rose-50 px-2 py-0.5 text-xs font-medium text-rose-600
                                                 dark:bg-rose-500/10 dark:text-rose-400">
                                        {{ $buku->stok }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 dark:text-slate-500">Semua stok buku aman.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABEL DETAIL TRANSAKSI --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                    <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Detail Transaksi</h2>
                    <span class="text-xs text-slate-500 dark:text-slate-400">
                        Total: <span class="font-medium text-slate-700 dark:text-slate-200">{{ $totalTransaksi }}</span> transaksi
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-4 py-3 font-medium">Anggota</th>
                                <th class="px-4 py-3 font-medium">Petugas</th>
                                <th class="px-4 py-3 font-medium">Buku</th>
                                <th class="px-4 py-3 font-medium">Tgl Pinjam</th>
                                <th class="px-4 py-3 font-medium">Jatuh Tempo</th>
                                <th class="px-4 py-3 font-medium">Tgl Kembali</th>
                                <th class="px-4 py-3 font-medium">Denda</th>
                                <th class="px-4 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($peminjams as $p)
                                @php
                                    $telat = $p->status === 'dipinjam' && $p->tgl_jatuh_tempo && $p->tgl_jatuh_tempo->lt(now());
                                @endphp
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                        {{ $p->anggota->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        {{ $p->petugas->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        @php $judulPertama = $p->detailPeminjaman->first()->buku->judul_buku ?? '-'; @endphp
                                        {{ $judulPertama }}
                                        @if ($p->detailPeminjaman->count() > 1)
                                            <span class="text-xs text-slate-400">+{{ $p->detailPeminjaman->count() - 1 }} lainnya</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        {{ $p->tgl_peminjaman->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        {{ $p->tgl_jatuh_tempo->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        {{ optional($p->tgl_pengembalian)->translatedFormat('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        {{ $p->denda ? 'Rp ' . number_format($p->denda, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($p->status === 'dikembalikan')
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700
                                                         dark:bg-emerald-900 dark:text-emerald-300">
                                                Dikembalikan
                                            </span>
                                        @elseif ($telat)
                                            <span class="inline-flex items-center rounded-full bg-rose-100 px-2.5 py-1 text-xs font-medium text-rose-700
                                                         dark:bg-rose-900 dark:text-rose-300">
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700
                                                         dark:bg-amber-900 dark:text-amber-300">
                                                Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-10 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fa-solid fa-chart-column mb-2 block text-2xl"></i>
                                        Tidak ada transaksi pada periode dan filter yang dipilih.
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
