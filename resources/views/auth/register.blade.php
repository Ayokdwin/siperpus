<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700
                         dark:bg-emerald-500/10 dark:text-emerald-400">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
                Registrasi Akun Anggota
            </span>
            <h1 class="mt-4 text-2xl font-bold text-slate-900 dark:text-slate-100">Buat akun baru</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Daftar sebagai anggota untuk mulai meminjam koleksi buku perpustakaan.
                Kode anggota akan dibuat otomatis setelah pendaftaran berhasil.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- Nama --}}
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="name" placeholder="Nama sesuai identitas" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email"
                    :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Alamat --}}
            <div>
                <x-input-label for="alamat" value="Alamat (opsional)" />
                <x-text-input id="alamat" class="mt-1 block w-full" type="text" name="alamat"
                    :value="old('alamat')" autocomplete="street-address" placeholder="Alamat domisili" />
                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Konfirmasi password --}}
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <x-primary-button class="mt-2 w-full justify-center rounded-xl px-4 py-3 text-sm">
                {{ __('Register') }}
            </x-primary-button>

            <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                Sudah punya akun?
                <a href="{{ route('login') }}"
                   class="font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">
                    Masuk di sini
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>
