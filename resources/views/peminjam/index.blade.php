@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Katalog Buku</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Temukan koleksi buku yang tersedia di perpustakaan</p>
                </div>
               
                <a href="{{ route('peminjam.checkout') }}"
                    class="group relative flex items-center gap-2 rounded-lg bg-emerald-500 px-4 py-2 text-white
                            shadow-sm hover:bg-emerald-600 hover:shadow-md
                            dark:bg-emerald-600 dark:hover:bg-emerald-500
                            transition-all duration-200">
                        <i class="fa-solid fa-right-to-bracket transition-transform group-hover:translate-x-0.5"></i>
                        <span class="font-medium">Pinjam</span>
                        @php
                            $jumlahKeranjang = count(session('keranjang_pinjam', []));
                        @endphp
                        @if ($jumlahKeranjang > 0)
                            <span class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-rose-600 px-1 text-xs font-bold text-white ring-2 ring-white dark:ring-gray-900">
                                {{ $jumlahKeranjang }}
                            </span>
                        @endif
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

            {{-- Filter bar --}}
            <form action="{{route('peminjaman-buku.index')}}" method="GET"
                class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex flex-1 flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                    {{-- Search --}}
                    <div class="relative flex-1 min-w-[220px]">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari judul, penulis, atau ISBN..."
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 pl-9 pr-3 text-sm text-slate-700
                                   placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:placeholder:text-slate-500">
                    </div>

                    {{-- Kategori --}}
                    <select name="kategori"
                        class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700
                               focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500
                               dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected(request('kategori') == $kategori->id)>
                                {{ $kategori->name_kategori }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Penulis --}}
                    <select name="penulis"
                        class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700
                               focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500
                               dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        <option value="">Semua Penulis</option>
                        @foreach ($penulisList as $penulis)
                            <option value="{{ $penulis }}" @selected(request('penulis') == $penulis)>
                                {{ $penulis }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Ketersediaan --}}
                    <select name="tersedia"
                        class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700
                               focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500
                               dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        <option value="">Semua Tersedia</option>
                        <option value="tersedia" @selected(request('tersedia') === 'tersedia')>Tersedia</option>
                        <option value="habis" @selected(request('tersedia') === 'habis')>Habis</option>
                    </select>

                    <button type="submit"
                        class="rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 transition-colors">
                        Terapkan
                    </button>
                    <a href="{{ route('peminjaman-buku.index') }}"
                        class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600
                               hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 transition-colors">
                        Reset
                    </a>
                </div>

                {{-- Sort --}}
                <select name="sort" onchange="this.form.submit()"
                    class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700
                           focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500
                           dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                    <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Terbaru</option>
                    <option value="judul_asc" @selected(request('sort') === 'judul_asc')>Judul A-Z</option>
                    <option value="judul_desc" @selected(request('sort') === 'judul_desc')>Judul Z-A</option>
                    <option value="stok_desc" @selected(request('sort') === 'stok_desc')>Stok Terbanyak</option>
                </select>
            </form>

            {{-- Grid buku --}}
            @if ($bukus->count())
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach ($bukus as $buku)
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden
                                    dark:border-slate-800 dark:bg-slate-900">
                            {{-- Cover --}}
                            <div class="p-4 pb-0">
                                
                                @if ($buku->cover)
                                    <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul_buku }}"
                                        class="h-56 w-full rounded-lg object-cover shadow-sm ring-1 ring-slate-200 dark:ring-slate-700">
                                @else
                                    <div class="flex h-56 w-full items-center justify-center rounded-lg bg-slate-100 text-slate-300
                                                dark:bg-slate-800 dark:text-slate-600">
                                        <i class="fa-solid fa-book text-4xl"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                           <div class="flex flex-1 flex-col p-4">
    <h3 class="line-clamp-2 text-sm font-semibold text-slate-900 dark:text-slate-100">
        {{ $buku->judul_buku }}
    </h3>
    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
        {{ $buku->penulis }}
    </p>

    <div class="mt-2">
        <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700
                     dark:bg-indigo-500/10 dark:text-indigo-400">
            {{ $buku->kategori->name_kategori ?? '-' }}
        </span>
    </div>

    <div class="mt-2 flex items-center gap-1.5 text-xs">
        <span class="h-2 w-2 rounded-full
            @if ($buku->stok > 5) bg-emerald-500
            @elseif ($buku->stok > 0) bg-amber-500
            @else bg-rose-500
            @endif">
        </span>
        <span class="text-slate-500 dark:text-slate-400">
            {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
        </span>
    </div>

    <div class="mt-auto flex items-center gap-2 pt-4">
        <a href="{{ route('katalog-buku.show', $buku->id) }}"
            class="inline-flex flex-1 items-center justify-center rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700
                   hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800 transition-colors">
            Lihat Detail
        </a>

        <form action="{{ route('peminjam.keranjang.tambah', $buku->id) }}" method="POST">
            @csrf
            <input type="hidden" name="buku_id" value="{{ $buku->id }}">
            <button type="submit"
                title="Pinjam buku ini"
                class="inline-flex h-[38px] w-[38px] shrink-0 items-center justify-center rounded-lg bg-emerald-600 text-white shadow-sm
                       hover:bg-emerald-700 transition-colors">
                <i class="fa-solid fa-right-to-bracket text-xs"></i>
            </button>
        </form>
    </div>
</div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="pt-2">
                    {{ $bukus->withQueryString()->links() }}
                </div>
            @else
                {{-- Empty state --}}
                <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-slate-200 bg-white py-16
                            dark:border-slate-800 dark:bg-slate-900">
                    <i class="fa-solid fa-book-open text-4xl text-slate-300 dark:text-slate-600"></i>
                    <p class="mt-3 text-sm font-medium text-slate-600 dark:text-slate-300">Buku tidak ditemukan</p>
                    <p class="text-sm text-slate-400 dark:text-slate-500">Coba ubah kata kunci atau filter pencarian</p>
                </div>
            @endif
        </div>
    </main>
@endsection