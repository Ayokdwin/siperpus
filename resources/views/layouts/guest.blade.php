<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIPERPUS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Anti-flash: terapkan tema tersimpan sebelum halaman dirender --}}
        <script>
            if (localStorage.getItem('theme') === 'dark' ||
                (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>
    </head>
    <body
        x-data="{
            dark: localStorage.getItem('theme')
                ? localStorage.getItem('theme') === 'dark'
                : window.matchMedia('(prefers-color-scheme: dark)').matches,
            toggleTheme() {
                this.dark = !this.dark;
                localStorage.setItem('theme', this.dark ? 'dark' : 'light');
            }
        }"
        x-init="document.documentElement.classList.toggle('dark', dark)"
        x-effect="document.documentElement.classList.toggle('dark', dark)"
        class="min-h-screen bg-slate-50 text-slate-700 antialiased dark:bg-slate-950 dark:text-slate-300"
        style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;"
    >
        <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.14),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.08),_transparent_28%),linear-gradient(180deg,#f8fbff_0%,#f8fafc_100%)] px-4 py-8 dark:bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.10),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.06),_transparent_28%),linear-gradient(180deg,#020617_0%,#0f172a_100%)] sm:px-6 lg:px-8">
            <div class="mx-auto flex w-full max-w-6xl flex-col gap-8">

                {{-- Header --}}
                <header class="flex flex-col gap-4 rounded-[2rem] border border-slate-200 bg-white/90 px-5 py-4 shadow-sm shadow-slate-200/60 backdrop-blur sm:flex-row sm:items-center sm:justify-between sm:px-8
                               dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                    <a href="/" class="flex items-center gap-3">
                        <svg class="h-10 w-10" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 8C16 5.5 10 5 5 6v22c5-1 11-0.5 15 2 4-2.5 10-3 15-2V6c-5-1-11-0.5-15 2Z" fill="#F59E0B"/>
                            <path d="M20 8c4-2.5 10-3 15-2v22c-5-1-11-0.5-15 2V8Z" fill="#2563EB"/>
                        </svg>
                        <div class="leading-tight">
                            <p class="text-lg font-extrabold tracking-tight text-slate-900 dark:text-slate-100">SIPERPUS</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Sistem Informasi Perpustakaan</p>
                        </div>
                    </a>

                    <div class="flex flex-wrap items-center justify-end gap-3">
                        {{-- Theme toggle --}}
                        <button
                            type="button"
                            @click="toggleTheme()"
                            title="Ganti tema"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-500
                                   hover:bg-slate-100 transition-colors
                                   dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                        >
                            <svg x-show="!dark" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.4 6.4l-.7-.7M6.3 6.3l-.7-.7m12.8 0l-.7.7M6.3 17.7l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z" />
                            </svg>
                            <svg x-show="dark" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.8A9 9 0 0111.2 3 7 7 0 1021 12.8z" />
                            </svg>
                        </button>

                        <a href="{{ route('login') }}"
                           class="inline-flex items-center rounded-full border border-emerald-600 bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700
                                  dark:border-emerald-600 dark:bg-emerald-600 dark:shadow-none dark:hover:bg-emerald-700">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center rounded-full border border-emerald-600 px-5 py-2.5 text-sm font-semibold text-emerald-600 transition hover:bg-emerald-50
                                  dark:border-emerald-500 dark:text-emerald-400 dark:hover:bg-emerald-500/10">
                            Register
                        </a>
                    </div>
                </header>

                {{-- Content card --}}
                <main class="mx-auto w-full max-w-md rounded-[2rem] border border-slate-200 bg-white/90 p-6 shadow-xl shadow-slate-200/70 backdrop-blur sm:p-8
                             dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
