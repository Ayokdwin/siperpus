@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Data Pengembalian</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Kelola Pengembalian buku perpustakaan</p>
                </div>
            </div>

            {{-- Alert sukses --}}
            @if (session('success'))
                <div class="flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700
                            dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Alert error (misal gagal hapus karena masih dipakai buku) --}}
            @if (session('error'))
                <div class="flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700
                            dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Card --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                {{-- Toolbar: search --}}
                <div class="flex items-center justify-between border-b border-slate-200 p-4 dark:border-slate-800">
                    <form method="GET" action="" class="relative w-full sm:w-72">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama kategori..."
                            class="w-full pl-9 pr-3 py-2 rounded-lg text-sm
                                   bg-slate-100 dark:bg-slate-800
                                   border border-transparent focus:border-emerald-400 dark:focus:border-emerald-500
                                   focus:bg-white dark:focus:bg-slate-900
                                   text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                   outline-none focus:ring-2 focus:ring-emerald-100 dark:focus:ring-emerald-500/20
                                   transition-colors"
                        />
                    </form>

                    <span class="hidden sm:inline-block text-sm text-slate-500 dark:text-slate-400">
                        Total: <span class="font-medium text-slate-700 dark:text-slate-200"></span> kategori
                    </span>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                
                                <th class="px-4 py-3 font-medium">Nama </th>
                                <th class="px-4 py-3 font-medium">Nama Petugas </th>
                                <th class="px-4 py-3 font-medium">Tanggal Peminjaman</th>
                                <th class="px-4 py-3 font-medium">Tanggal Jatuh Tempo</th>
                                <th class="px-4 py-3 font-medium">Tanggal Pengembalian</th>
                                <th class="px-4 py-3 font-medium">Denda</th>
                                <th class="px-4 py-3 font-medium">Status</th>
                                <th class="px-4 py-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                           @foreach($peminjams as $peminjam)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                           
                                            <span class="font-medium text-slate-800 dark:text-slate-100">
                                                {{$peminjam->anggota->name}}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                           
                                            <span class="font-medium text-slate-800 dark:text-slate-100">
                                                {{$peminjam->petugas->name}}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600
                                                     dark:bg-slate-800 dark:text-slate-300">
                                           {{$peminjam->tgl_peminjaman->translatedFormat('d M Y') ?? '-'}}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600
                                                     dark:bg-slate-800 dark:text-slate-300">
                                           {{$peminjam->tgl_jatuh_tempo->translatedFormat('d M Y') ?? '-'}}
                                        </span>
                                    </td>
                                    
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600
                                                     dark:bg-slate-800 dark:text-slate-300">
                                          {{ optional($peminjam->tgl_pengembalian)->translatedFormat('d M Y') ?? 'Belum Dikembalikan' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <span class="font-medium text-slate-800 dark:text-slate-100">
                                                {{ $peminjam->denda ? 'Rp ' . number_format($peminjam->denda, 0, ',', '.') : '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                   <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                                            {{ $peminjam->status == 'dikembalikan'
                                                ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                                : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                            {{ $peminjam->status }}
                                        </span>
                                    </td>
                                    

                                    <td class="px-4 py-3">
                                        @if($peminjam->status !== 'dikembalikan' )
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{route('pengembalian.konfirmasi',$peminjam->id)}}"
                                                title="Konfirmasi Pengembalian"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500
                                                       hover:bg-sky-50 hover:text-sky-600
                                                       dark:text-slate-400 dark:hover:bg-sky-500/10 dark:hover:text-sky-400
                                                       transition-colors">
                                                <i class="fa-solid fa-circle-check text-xs"></i>
                                            </a>
                                            @endif

                                            <a href=""
                                                title="Perpanjang peminjaman"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500
                                                       hover:bg-emerald-50 hover:text-emerald-600
                                                       dark:text-slate-400 dark:hover:bg-emerald-500/10 dark:hover:text-emerald-400
                                                       transition-colors">
                                                <i class="fa-solid fa-calendar-plus text-xs"></i>
                                            </a>
                                            @if(Auth::user()->role == 'admin')
                                            <form action="" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500
                                                           hover:bg-rose-50 hover:text-rose-600
                                                           dark:text-slate-400 dark:hover:bg-rose-500/10 dark:hover:text-rose-400
                                                           transition-colors">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @if($peminjam == null)
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fa-solid fa-tags text-2xl mb-2 block"></i>
                                        Belum ada data kategori.
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                
            </div>
        </div>
    </main>
@endsection
