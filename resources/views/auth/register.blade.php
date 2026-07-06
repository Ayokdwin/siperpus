<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Daftar Akun</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900">Buat akun baru</h2>
            <p class="mt-2 text-sm text-slate-500">Mulai kelola perpustakaan dengan tampilan yang lebih terstruktur.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Name')" class="text-slate-700" />
                <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" class="text-slate-700" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" class="text-slate-700" />
                <x-text-input id="password" class="mt-1 block w-full"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-slate-700" />
                <x-text-input id="password_confirmation" class="mt-1 block w-full"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <x-primary-button class="mt-2 w-full justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                {{ __('Register') }}
            </x-primary-button>

            <p class="text-center text-sm text-slate-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Masuk di sini</a>
            </p>
        </form>
    </div>
</x-guest-layout>
