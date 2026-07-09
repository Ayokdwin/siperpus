@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-5xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Checkout Peminjaman</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Tinjau keranjang lalu proses peminjaman untuk anggota</p>
                </div>

                <a href="{{route('peminjaman-buku.index')}}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-50 transition-colors
                           dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Kembali ke Katalog
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

            {{-- Alert error --}}
            @if (session('error'))
                <div class="flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700
                            dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700
                            dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400">
                    <div class="flex items-center gap-2 font-medium mb-1">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>Periksa kembali input kamu:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Ringkasan cepat --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Jumlah Judul</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ $bukus->count() }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Eksemplar</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-800 dark:text-slate-100">
                        {{ collect($keranjang)->sum() }}
                    </p>
                </div>
            </div>

            {{-- Card: daftar keranjang --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                    <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Buku di Keranjang</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-4 py-3 font-medium">#</th>
                                <th class="px-4 py-3 font-medium">Cover</th>
                                <th class="px-4 py-3 font-medium">Kode</th>
                                <th class="px-4 py-3 font-medium">Judul</th>
                                <th class="px-4 py-3 font-medium">Jumlah</th>
                                <th class="px-4 py-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($bukus as $i => $buku)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $i + 1 }}</td>

                                    <td class="px-4 py-3">
                                        @if ($buku->cover)
                                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul_buku }}"
                                                class="h-12 w-9 rounded object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                                        @else
                                            <div class="flex h-12 w-9 items-center justify-center rounded bg-slate-100 text-slate-400
                                                        dark:bg-slate-800 dark:text-slate-600">
                                                <i class="fa-solid fa-book text-xs"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $buku->kode_buku }}</td>

                                    <td class="px-4 py-3">
                                        <span class="font-medium text-slate-800 dark:text-slate-100">{{ $buku->judul_buku }}</span>
                                        <span class="block text-xs text-slate-400 dark:text-slate-500">{{ $buku->penulis }}</span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700
                                                     dark:bg-indigo-500/10 dark:text-indigo-400">
                                            {{ $keranjang[$buku->id] }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-right">
                                        <form action="{{ route('peminjam.keranjang.hapus', $buku->id) }}" method="POST"
                                            onsubmit="return confirm('Keluarkan {{ $buku->judul_buku }} dari keranjang?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Batalkan"
                                                class="flex h-8 w-8 items-center justify-center ml-auto rounded-lg
                                                    border border-rose-300 text-rose-600
                                                    hover:bg-rose-50 hover:border-rose-500 hover:text-rose-700
                                                    dark:border-rose-500/40 dark:text-rose-400
                                                    dark:hover:bg-rose-500/10 dark:hover:border-rose-400
                                                    transition-colors">
                                                <i class="fa-solid fa-xmark text-xs"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fa-solid fa-cart-shopping text-2xl mb-2 block"></i>
                                        Keranjang masih kosong.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Card: form proses peminjaman --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                    <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Detail Peminjaman</h2>
                </div>

                <form action="{{ route('peminjam.proses') }}" method="POST" class="p-4 space-y-4">
                    @csrf

                    <div>
                        <label for="user_id" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1.5">
                            Anggota
                        </label>
                        <select id="user_id" name="user_id" required
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20">
                            <option value="">-- Pilih Anggota --</option>
                            @foreach ($anggotas as $anggota)
                                <option value="{{ $anggota->id }}" @selected(old('user_id') == $anggota->id)>
                                    {{ $anggota->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="tgl_jatuh_tempo" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1.5">
                            Tanggal Jatuh Tempo
                        </label>
                        <input type="date" id="tgl_jatuh_tempo" name="tgl_jatuh_tempo" required
                            value="{{ old('tgl_jatuh_tempo') }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20">
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm
                                   hover:bg-emerald-700 transition-colors">
                            <i class="fa-solid fa-check text-xs"></i>
                            Proses Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
