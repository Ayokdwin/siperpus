@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-6xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('buku.index') }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500
                           hover:bg-slate-100 hover:text-slate-700
                           dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200
                           transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Tambah Buku</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Tambahkan koleksi buku baru ke perpustakaan</p>
                </div>
            </div>

            {{-- Alert error --}}
            @if ($errors->any())
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700
                            dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400">
                    <div class="flex items-center gap-2 font-medium">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>Terjadi kesalahan, mohon periksa kembali isian Anda:</span>
                    </div>
                    <ul class="mt-2 ml-6 list-disc space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Card form --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                    @csrf

                    {{-- Cover upload --}}
                    <div x-data="{ preview: null, fileName: null }">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                            Cover Buku
                        </label>

                        <div class="flex items-center gap-4">
                            <div class="flex h-28 w-20 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-dashed
                                        border-slate-300 bg-slate-50 dark:border-slate-700 dark:bg-slate-800">
                                <template x-if="preview">
                                    <img :src="preview" class="h-full w-full object-cover" />
                                </template>
                                <template x-if="!preview">
                                    <i class="fa-solid fa-image text-xl text-slate-300 dark:text-slate-600"></i>
                                </template>
                            </div>

                            <div class="flex-1">
                                <label for="cover"
                                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm
                                           font-medium text-slate-600 hover:bg-slate-50
                                           dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700
                                           transition-colors">
                                    <i class="fa-solid fa-upload text-xs"></i>
                                    Pilih Gambar
                                </label>
                                <input type="file" id="cover" name="cover" accept="image/*" class="hidden"
                                    @change="
                                        const file = $event.target.files[0];
                                        if (file) {
                                            fileName = file.name;
                                            preview = URL.createObjectURL(file);
                                        }
                                    " />
                                <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500" x-text="fileName || 'PNG, JPG, maksimal 2MB'"></p>
                                @error('cover')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Kode Buku & Kategori --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="kode_buku" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Kode Buku <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="kode_buku" name="kode_buku" value="{{ old('kode_buku') }}" required
                                placeholder="Otomatis dibuat oleh sistem"
                                @readonly(true)
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('kode_buku') border-rose-300 @enderror" />
                            @error('kode_buku')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kategori_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Kategori <span class="text-rose-500">*</span>
                            </label>
                            <select id="kategori_id" name="kategori_id" required
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('kategori_id') border-rose-300 @enderror">
                                <option value="" disabled {{ old('kategori_id') ? '' : 'selected' }}>Pilih kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>
                                        {{ $kategori->name_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Judul --}}
                    <div>
                        <label for="judul_buku" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                            Judul Buku <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="judul_buku" name="judul_buku" value="{{ old('judul_buku') }}" required
                            placeholder="Masukkan judul buku"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                   placeholder:text-slate-400
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                   transition-colors @error('judul_buku') border-rose-300 @enderror" />
                        @error('judul_buku')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Penulis & Penerbit --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="penulis" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Penulis <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="penulis" name="penulis" value="{{ old('penulis') }}" required
                                placeholder="Nama penulis"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('penulis') border-rose-300 @enderror" />
                            @error('penulis')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="penerbit" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Penerbit <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" required
                                placeholder="Nama penerbit"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('penerbit') border-rose-300 @enderror" />
                            @error('penerbit')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Tahun Terbit & Stok --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="tahun_terbit" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Tahun Terbit <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required
                                min="1900" max="{{ date('Y') }}"
                                placeholder="Contoh: {{ date('Y') }}"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('tahun_terbit') border-rose-300 @enderror" />
                            @error('tahun_terbit')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stok" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Stok <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" id="stok" name="stok" value="{{ old('stok', 1) }}" required min="0"
                                placeholder="Jumlah eksemplar"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('stok') border-rose-300 @enderror" />
                            @error('stok')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            placeholder="Sinopsis atau deskripsi singkat buku (opsional)"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                   placeholder:text-slate-400 resize-none
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                   transition-colors @error('deskripsi') border-rose-300 @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5 dark:border-slate-800">
                        <a href="{{ route('buku.index') }}"
                            class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600
                                   hover:bg-slate-100
                                   dark:text-slate-300 dark:hover:bg-slate-800
                                   transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                                   hover:bg-emerald-700 transition-colors">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            Simpan Buku
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
