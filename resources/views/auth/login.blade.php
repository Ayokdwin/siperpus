<x-guest-layout>
    <div class="space-y-8">
        <div class="text-center">
            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700
                         dark:bg-emerald-500/10 dark:text-emerald-400">
                Masuk ke SIPERPUS
            </span>
            <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">Login</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Masuk untuk melanjutkan pengelolaan perpustakaan Anda.
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-2 block w-full" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-2 block w-full" type="password" name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Remember me & forgot password --}}
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500
                               dark:border-slate-600 dark:bg-slate-800 dark:text-emerald-500 dark:focus:ring-emerald-500">
                    <span>{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm font-medium text-emerald-600 hover:text-emerald-700
                              dark:text-emerald-400 dark:hover:text-emerald-300">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center rounded-2xl px-4 py-3 text-base">
                {{ __('Log in') }}
            </x-primary-button>

            <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                Belum punya akun?
                <a href="{{ route('register') }}"
                   class="font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">
                    Daftar sekarang
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>
