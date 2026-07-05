@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-6xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('kategori.index') }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500
                           hover:bg-slate-100 hover:text-slate-700
                           dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200
                           transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Edit Kategori</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Perbarui informasi kategori untuk mengelompokkan buku</p>
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
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nama Kategori --}}
                    <div>
                        <label for="name_kategori" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                            Nama Kategori <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="name_kategori" name="name_kategori" value="{{ old('name_kategori', $kategori->name_kategori) }}" required autofocus
                            placeholder="Contoh: Fiksi, Sains, Sejarah"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                   placeholder:text-slate-400
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                   transition-colors @error('name_kategori') border-rose-300 @enderror" />
                        @error('name_kategori')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500">
                            Nama kategori harus unik dan belum digunakan sebelumnya.
                        </p>
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5 dark:border-slate-800">
                        <a href="{{ route('kategori.index') }}"
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
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
