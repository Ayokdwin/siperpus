<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-700 antialiased" style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.14),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.08),_transparent_28%),linear-gradient(180deg,#f8fbff_0%,#f8fafc_100%)] px-4 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto flex w-full max-w-6xl flex-col gap-8">
                <header class="flex flex-col gap-4 rounded-[2rem] border border-slate-200 bg-white/90 px-5 py-4 shadow-sm shadow-slate-200/60 backdrop-blur sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <a href="/" class="flex items-center gap-3">
                        <svg class="h-10 w-10" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 8C16 5.5 10 5 5 6v22c5-1 11-0.5 15 2 4-2.5 10-3 15-2V6c-5-1-11-0.5-15 2Z" fill="#F59E0B"/>
                            <path d="M20 8c4-2.5 10-3 15-2v22c-5-1-11-0.5-15 2V8Z" fill="#2563EB"/>
                        </svg>
                        <div class="leading-tight">
                            <p class="text-lg font-extrabold tracking-tight text-slate-900">SIPERPUS</p>
                            <p class="text-xs text-slate-500">Sistem Informasi Perpustakaan</p>
                        </div>
                    </a>

                    <div class="flex flex-wrap items-center justify-end gap-3">
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-full border border-blue-600 bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center rounded-full border border-blue-600 px-5 py-2.5 text-sm font-semibold text-blue-600 transition hover:bg-blue-50">
                            Register
                        </a>
                    </div>
                </header>

                <main class="mx-auto w-full max-w-md rounded-[2rem] border border-slate-200 bg-white/90 p-6 shadow-xl shadow-slate-200/70 backdrop-blur sm:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
