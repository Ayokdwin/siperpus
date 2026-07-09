@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-6xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500
                           hover:bg-slate-100 hover:text-slate-700
                           dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200
                           transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Profil Saya</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Kelola informasi akun dan keamanan Anda</p>
                </div>
            </div>

            {{-- Profile summary --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center gap-4 p-6">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full
                                bg-gradient-to-br from-emerald-500 to-teal-500 text-xl font-semibold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ auth()->user()->name }}</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</p>
                        @php
                            $roleBadge = match (auth()->user()->role) {
                                'admin' => 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
                                'petugas' => 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                                default => 'bg-sky-50 text-sky-700 dark:bg-sky-500/10 dark:text-sky-400',
                            };
                        @endphp
                        <span class="mt-2 inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium capitalize {{ $roleBadge }}">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Section: Informasi Profil --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-100 p-6 dark:border-slate-800">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Informasi Profil</h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Perbarui nama dan alamat email akun Anda.
                    </p>
                </div>

                <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-5">
                    @csrf
                    @method('patch')

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            autofocus autocomplete="name"
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
                            autocomplete="username"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                   placeholder:text-slate-400
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                   transition-colors @error('email') border-rose-300 @enderror" />
                        @error('email')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2 rounded-lg border border-amber-200 bg-amber-50 px-3.5 py-2.5 text-xs text-amber-700
                                        dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-400">
                                <p>
                                    Alamat email Anda belum terverifikasi.
                                    <button form="send-verification" type="submit"
                                        class="font-medium underline underline-offset-2 hover:text-amber-800 dark:hover:text-amber-300">
                                        Klik di sini untuk kirim ulang email verifikasi.
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-1.5 font-medium text-emerald-600 dark:text-emerald-400">
                                        Tautan verifikasi baru telah dikirim ke email Anda.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Kode Anggota: hanya tampil jika role = anggota --}}
                    @if ($user->role === 'anggota')
                        <div>
                            <label for="kode_anggota" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Kode Anggota
                            </label>
                            <input type="text" id="kode_anggota" name="kode_anggota" value="{{ old('kode_anggota', $user->kode_anggota) }}"
                                placeholder="Contoh: AGT001"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('kode_anggota') border-rose-300 @enderror" />
                            @error('kode_anggota')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

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

                    {{-- Action --}}
                    <div class="flex items-center gap-3 border-t border-slate-100 pt-5 dark:border-slate-800">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                                   hover:bg-emerald-700 transition-colors">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 2500)"
                                class="inline-flex items-center gap-1.5 text-sm text-emerald-600 dark:text-emerald-400">
                                <i class="fa-solid fa-circle-check text-xs"></i>
                                Tersimpan.
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Section: Ubah Password --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-100 p-6 dark:border-slate-800">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Ubah Password</h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Gunakan password yang panjang dan acak agar akun Anda tetap aman.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-5">
                    @csrf
                    @method('put')

                    <div>
                        <label for="update_password_current_password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                            Password Saat Ini
                        </label>
                        <input type="password" id="update_password_current_password" name="current_password"
                            autocomplete="current-password"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                   placeholder:text-slate-400
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                   transition-colors @error('current_password', 'updatePassword') border-rose-300 @enderror" />
                        @error('current_password', 'updatePassword')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="update_password_password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Password Baru
                            </label>
                            <input type="password" id="update_password_password" name="password"
                                autocomplete="new-password"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('password', 'updatePassword') border-rose-300 @enderror" />
                            @error('password', 'updatePassword')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="update_password_password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                                autocomplete="new-password"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                       placeholder:text-slate-400
                                       focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                       dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20
                                       transition-colors @error('password_confirmation', 'updatePassword') border-rose-300 @enderror" />
                            @error('password_confirmation', 'updatePassword')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-3 border-t border-slate-100 pt-5 dark:border-slate-800">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                                   hover:bg-emerald-700 transition-colors">
                            <i class="fa-solid fa-key text-xs"></i>
                            Perbarui Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 2500)"
                                class="inline-flex items-center gap-1.5 text-sm text-emerald-600 dark:text-emerald-400">
                                <i class="fa-solid fa-circle-check text-xs"></i>
                                Tersimpan.
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Section: Hapus Akun --}}
            <div class="rounded-xl border border-rose-200 bg-white shadow-sm dark:border-rose-500/20 dark:bg-slate-900"
                x-data="{ confirmingDeletion: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">
                <div class="border-b border-rose-100 p-6 dark:border-rose-500/10">
                    <h3 class="text-sm font-semibold text-rose-700 dark:text-rose-400">Hapus Akun</h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Setelah akun dihapus, seluruh data terkait akan dihapus permanen. Pastikan Anda telah menyimpan data yang diperlukan sebelum melanjutkan.
                    </p>
                </div>

                <div class="p-6">
                    <button type="button" @click="confirmingDeletion = true"
                        class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-medium text-rose-600
                               hover:bg-rose-100
                               dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20
                               transition-colors">
                        <i class="fa-solid fa-trash text-xs"></i>
                        Hapus Akun
                    </button>
                </div>

                {{-- Modal konfirmasi --}}
                <div x-show="confirmingDeletion" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4"
                    x-transition.opacity>
                    <div @click.outside="confirmingDeletion = false"
                        class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-slate-900"
                        x-transition>
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')

                            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                Yakin ingin menghapus akun Anda?
                            </h2>
                            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                                Seluruh data akan dihapus permanen. Masukkan password Anda untuk konfirmasi.
                            </p>

                            <div class="mt-5">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" id="password" name="password" placeholder="Password"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700
                                           placeholder:text-slate-400
                                           focus:border-rose-400 focus:ring-2 focus:ring-rose-100 outline-none
                                           dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-rose-500/20
                                           transition-colors @error('password', 'userDeletion') border-rose-300 @enderror" />
                                @error('password', 'userDeletion')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6 flex items-center justify-end gap-3">
                                <button type="button" @click="confirmingDeletion = false"
                                    class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600
                                           hover:bg-slate-100
                                           dark:text-slate-300 dark:hover:bg-slate-800
                                           transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg bg-rose-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                                           hover:bg-rose-700 transition-colors">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                    Hapus Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
