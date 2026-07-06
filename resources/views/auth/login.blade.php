<x-guest-layout>
    <div class="space-y-8">
        <div class="text-center">
            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">Masuk ke SIPERPUS</span>
            <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900">Login</h1>
            <p class="mt-2 text-sm text-slate-500">Masuk untuk melanjutkan pengelolaan perpustakaan Anda.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" class="text-slate-700" />
                <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" class="text-slate-700" />
                <x-text-input id="password" class="mt-2 block w-full"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-blue-600 hover:text-blue-700" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center rounded-2xl px-4 py-3 text-base">
                {{ __('Log in') }}
            </x-primary-button>

            <p class="text-center text-sm text-slate-500">
                Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">Daftar sekarang</a>
            </p>
        </form>
    </div>
</x-guest-layout>
