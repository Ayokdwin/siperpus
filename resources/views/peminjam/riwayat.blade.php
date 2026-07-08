@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-6xl mx-auto space-y-6">

            {{-- Page header --}}
            <div>
                <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Riwayat Peminjaman</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Seluruh riwayat peminjaman buku Anda</p>
            </div>

            {{-- Riwayat table --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-6 py-3 font-medium">Buku</th>
                                <th class="px-6 py-3 font-medium">Jumlah</th>
                                <th class="px-6 py-3 font-medium">Tanggal Pinjam</th>
                                <th class="px-6 py-3 font-medium">Batas Kembali</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($peminjams as $peminjaman)
                                @foreach ($peminjaman->detailPeminjaman as $detail)
                                    <tr>
                                        <td class="px-6 py-3 text-slate-700 dark:text-slate-200">
                                            {{ $detail->buku->judul_buku ?? '-' }}
                                        </td>
                                        <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                            {{ $detail->jumlah }}
                                        </td>
                                        <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                            {{ $peminjaman->tgl_peminjaman?->translatedFormat('d M Y') ?? '-' }}
                                        </td>
                                        <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                            {{ $peminjaman->tgl_jatuh_tempo?->translatedFormat('d M Y') ?? '-' }}
                                        </td>
                                        <td class="px-6 py-3">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium capitalize
                                                @if ($peminjaman->status === 'dikembalikan')
                                                    bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400
                                                @elseif ($peminjaman->status === 'terlambat')
                                                    bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400
                                                @elseif ($peminjaman->status === 'dibatalkan')
                                                    bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400
                                                @else
                                                    bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                                                @endif
                                            ">
                                                {{ $peminjaman->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-400 dark:text-slate-500">
                                        Belum ada riwayat peminjaman
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