@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="w-full max-w-6xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('users.index') }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500
                           hover:bg-slate-100 hover:text-slate-700
                           dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200
                           transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Edit Data Pengguna</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Perbarui informasi pengguna untuk admin, petugas, atau anggota</p>
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
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus
                            placeholder="Masukkan nama lengkap"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                   placeholder:text-slate-400
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                   transition-colors @error('name') border-rose-300 @enderror" />
                        @error('name')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            placeholder="nama@contoh.com"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                   placeholder:text-slate-400
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                   transition-colors @error('email') border-rose-300 @enderror" />
                        @error('email')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password & Konfirmasi --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Password <span class="text-rose-500">*</span>
                            </label>
                            <input type="password" id="password" name="password"
                                placeholder="Minimal 8 karakter"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('password') border-rose-300 @enderror" />
                            @error('password')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Konfirmasi Password <span class="text-rose-500">*</span>
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Ulangi password"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors" />
                        </div>
                    </div>

                    {{-- Role --}}
                    <div x-data="{ role: '{{ old('role', $user->role) }}' }">
                        <label for="role" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                            Role <span class="text-rose-500">*</span>
                        </label>
                        <select id="role" name="role" x-model="role" required
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                   transition-colors @error('role') border-rose-300 @enderror">
                            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                            <option value="petugas" @selected(old('role') === 'petugas')>Petugas</option>
                            <option value="anggota" @selected(old('role') === 'anggota')>Anggota</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror

                        {{-- Kode Anggota: hanya muncul jika role = anggota --}}
                        <div x-show="role === 'anggota'" x-cloak class="mt-5">
                            <label for="kode_anggota" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Kode Anggota
                            </label>
                            <input type="text" id="kode_anggota" name="kode_anggota" value="{{ old('kode_anggota', $user->kode_anggota) }}"
                                @readonly(true)
                                placeholder="Otomatis dibuat oleh sistem"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('kode_anggota') border-rose-300 @enderror" />
                            @error('kode_anggota')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                            Alamat
                        </label>
                        <textarea id="alamat" name="alamat" rows="3"
                            placeholder="Masukkan alamat lengkap (opsional)"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                   placeholder:text-slate-400 resize-none
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                   transition-colors @error('alamat') border-rose-300 @enderror">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5 dark:border-slate-800">
                        <a href="{{ route('users.index') }}"
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
                            Perbarui Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
