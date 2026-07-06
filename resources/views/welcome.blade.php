<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPERPUS - Sistem Informasi Perpustakaan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-slate-700">

    {{-- ============ NAVBAR ============ --}}
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="flex items-center justify-between h-20">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0">
                    <svg class="w-9 h-9" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 8C16 5.5 10 5 5 6v22c5-1 11-0.5 15 2 4-2.5 10-3 15-2V6c-5-1-11-0.5-15 2Z" fill="#F59E0B"/>
                        <path d="M20 8c4-2.5 10-3 15-2v22c-5-1-11-0.5-15 2V8Z" fill="#2563EB"/>
                    </svg>
                    <div class="leading-tight">
                        <p class="text-xl font-extrabold tracking-tight text-slate-900">SIPERPUS</p>
                        <p class="text-[11px] text-slate-400 -mt-0.5">Sistem Informasi Perpustakaan</p>
                    </div>
                </a>

                {{-- Nav links --}}
                <nav class="hidden lg:flex items-center gap-10 text-[15px] font-medium">
                    <a href="#beranda" class="relative text-blue-600 pb-6 -mb-6">
                        Beranda
                        <span class="absolute left-0 right-0 -bottom-[1px] h-0.5 bg-blue-600 rounded-full"></span>
                    </a>
                    <a href="#tentang" class="text-slate-600 hover:text-blue-600 transition">Tentang</a>
                    <a href="#fitur" class="text-slate-600 hover:text-blue-600 transition">Fitur</a>
                    <a href="#kontak" class="text-slate-600 hover:text-blue-600 transition">Kontak</a>
                </nav>

                {{-- Auth buttons --}}
                <div class="hidden md:flex items-center gap-3">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-blue-600 text-blue-600 font-semibold text-sm px-5 py-2.5 hover:bg-blue-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                            Login
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white font-semibold text-sm px-5 py-2.5 hover:bg-blue-700 shadow-sm shadow-blue-200 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v6m3-3h-6M6.75 7.5a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM1.5 20.118a7.5 7.5 0 0 1 12.548-5.624"/>
                            </svg>
                            Register
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- ============ HERO ============ --}}
    <section id="beranda" class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-sky-50 to-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid lg:grid-cols-2 gap-10 items-center py-14 lg:py-0 lg:min-h-[560px]">

                {{-- Left copy --}}
                <div class="relative z-10">
                    <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold px-4 py-1.5">
                        📖 Selamat Datang
                    </span>

                    <h1 class="mt-6 text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 leading-[1.1]">
                        Sistem Informasi<br>
                        <span class="text-blue-600">Perpustakaan</span>
                    </h1>

                    <p class="mt-6 max-w-lg text-slate-500 text-[15px] leading-relaxed">
                        Kelola koleksi buku, data anggota, peminjaman, dan pengembalian
                        buku dengan lebih mudah, cepat, dan efisien dalam satu sistem
                        terintegrasi.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="{{ Route::has('dashboard') ? url('/dashboard') : '#' }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white font-semibold px-6 py-3 hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"/>
                            </svg>
                            Masuk ke Dashboard
                        </a>
                        <a href="#tentang"
                           class="inline-flex items-center gap-2 rounded-lg border border-blue-600 text-blue-600 font-semibold px-6 py-3 hover:bg-blue-50 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                            </svg>
                            Pelajari Selengkapnya
                        </a>
                    </div>
                </div>

                {{-- Right image --}}
                <div class="relative lg:h-[560px] -mx-6 lg:mx-0">
                    <div class="relative h-72 sm:h-96 lg:h-full lg:absolute lg:inset-y-0 lg:right-0 lg:w-[130%] overflow-hidden lg:rounded-l-[2rem]">
                        <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1400&auto=format&fit=crop"
                             alt="Rak buku perpustakaan"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-sky-50 via-sky-50/10 to-transparent lg:w-1/3"></div>

                        {{-- Book stack card --}}
                        <div class="hidden sm:flex absolute bottom-8 right-10 flex-col gap-1.5 w-64">
                            @foreach ([
                                ['label' => 'MANAJEMEN PERPUSTAKAAN', 'color' => '#1E3A8A'],
                                ['label' => 'DASAR-DASAR INFORMASI', 'color' => '#0F766E'],
                                ['label' => 'SISTEM INFORMASI', 'color' => '#6D28D9'],
                                ['label' => 'TEKNOLOGI INFORMASI', 'color' => '#7C3AED'],
                                ['label' => 'BASIS DATA', 'color' => '#1E293B'],
                                ['label' => 'PEMROGRAMAN WEB', 'color' => '#0F172A'],
                            ] as $book)
                                <div class="flex items-center justify-between rounded-md px-4 py-2 text-white text-[11px] font-semibold tracking-wide shadow-md"
                                     style="background-color: {{ $book['color'] }}">
                                    <span>{{ $book['label'] }}</span>
                                    <span class="opacity-70">›</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ FITUR ============ --}}
    <section id="fitur" class="py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">

            <div class="text-center max-w-xl mx-auto mb-14">
                <p class="text-blue-600 font-semibold text-sm tracking-wide uppercase">Fitur Utama</p>
                <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-slate-900">Fitur yang Tersedia</h2>
                <span class="block w-14 h-1 bg-blue-600 rounded-full mx-auto mt-4"></span>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $features = [
                        [
                            'title' => 'Koleksi Buku',
                            'desc' => 'Kelola data buku dan kategori dengan mudah',
                            'bg' => 'bg-blue-100', 'fg' => 'text-blue-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>',
                        ],
                        [
                            'title' => 'Data Anggota',
                            'desc' => 'Kelola data anggota perpustakaan',
                            'bg' => 'bg-emerald-100', 'fg' => 'text-emerald-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>',
                        ],
                        [
                            'title' => 'Peminjaman',
                            'desc' => 'Proses peminjaman buku secara cepat',
                            'bg' => 'bg-amber-100', 'fg' => 'text-amber-500',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>',
                        ],
                        [
                            'title' => 'Pengembalian',
                            'desc' => 'Kelola pengembalian dan hitung denda otomatis',
                            'bg' => 'bg-rose-100', 'fg' => 'text-rose-500',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3"/>',
                        ],
                        [
                            'title' => 'Laporan',
                            'desc' => 'Laporan lengkap dan akurat setiap saat',
                            'bg' => 'bg-violet-100', 'fg' => 'text-violet-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>',
                        ],
                        [
                            'title' => 'Pengaturan',
                            'desc' => 'Atur sistem sesuai kebutuhan perpustakaan',
                            'bg' => 'bg-teal-100', 'fg' => 'text-teal-600',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.281ZM15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>',
                        ],
                    ];
                @endphp

                @foreach ($features as $f)
                    <div class="group rounded-2xl border border-slate-100 bg-white p-7 shadow-[0_10px_30px_-15px_rgba(15,23,42,0.15)] hover:shadow-[0_15px_35px_-15px_rgba(37,99,235,0.25)] hover:-translate-y-1 transition duration-300">
                        <div class="w-14 h-14 rounded-xl {{ $f['bg'] }} flex items-center justify-center mb-5">
                            <svg class="w-7 h-7 {{ $f['fg'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                {!! $f['icon'] !!}
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $f['title'] }}</h3>
                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ FOOTER ============ --}}
    <footer id="kontak" class="bg-slate-900 text-slate-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10 flex flex-col md:flex-row items-center justify-between gap-6">

            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <svg class="w-8 h-8" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 8C16 5.5 10 5 5 6v22c5-1 11-0.5 15 2 4-2.5 10-3 15-2V6c-5-1-11-0.5-15 2Z" fill="#F59E0B"/>
                    <path d="M20 8c4-2.5 10-3 15-2v22c-5-1-11-0.5-15 2V8Z" fill="#3B82F6"/>
                </svg>
                <div class="leading-tight text-left">
                    <p class="text-white font-extrabold">SIPERPUS</p>
                    <p class="text-[11px] text-slate-400">Sistem Informasi Perpustakaan</p>
                </div>
            </a>

            <p class="text-sm text-slate-400 order-3 md:order-2">© {{ date('Y') }} SIPERPUS. All rights reserved.</p>

            <div class="flex items-center gap-3 order-2 md:order-3">
                <a href="#" class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12.06C22 6.505 17.523 2 12 2S2 6.505 2 12.06c0 5.02 3.657 9.184 8.438 9.94v-7.03H7.898v-2.91h2.54V9.845c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562v1.877h2.773l-.443 2.91h-2.33V22c4.78-.756 8.437-4.92 8.437-9.94Z"/></svg>
                </a>
                <a href="#" class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c-2.72 0-3.06.01-4.12.06-1.06.05-1.79.22-2.43.47a4.9 4.9 0 0 0-1.77 1.15A4.9 4.9 0 0 0 2.53 5.45c-.25.64-.42 1.37-.47 2.43C2.01 8.94 2 9.28 2 12s.01 3.06.06 4.12c.05 1.06.22 1.79.47 2.43a4.9 4.9 0 0 0 1.15 1.77 4.9 4.9 0 0 0 1.77 1.15c.64.25 1.37.42 2.43.47C8.94 21.99 9.28 22 12 22s3.06-.01 4.12-.06c1.06-.05 1.79-.22 2.43-.47a4.9 4.9 0 0 0 1.77-1.15 4.9 4.9 0 0 0 1.15-1.77c.25-.64.42-1.37.47-2.43.05-1.06.06-1.4.06-4.12s-.01-3.06-.06-4.12c-.05-1.06-.22-1.79-.47-2.43a4.9 4.9 0 0 0-1.15-1.77A4.9 4.9 0 0 0 18.55 2.53c-.64-.25-1.37-.42-2.43-.47C15.06 2.01 14.72 2 12 2Zm0 1.8c2.67 0 2.99.01 4.04.06.98.04 1.5.21 1.86.35.47.18.8.4 1.15.75.35.35.57.68.75 1.15.14.36.31.88.35 1.86.05 1.05.06 1.37.06 4.04s-.01 2.99-.06 4.04c-.04.98-.21 1.5-.35 1.86-.18.47-.4.8-.75 1.15-.35.35-.68.57-1.15.75-.36.14-.88.31-1.86.35-1.05.05-1.37.06-4.04.06s-2.99-.01-4.04-.06c-.98-.04-1.5-.21-1.86-.35a3.1 3.1 0 0 1-1.15-.75 3.1 3.1 0 0 1-.75-1.15c-.14-.36-.31-.88-.35-1.86-.05-1.05-.06-1.37-.06-4.04s.01-2.99.06-4.04c.04-.98.21-1.5.35-1.86.18-.47.4-.8.75-1.15.35-.35.68-.57 1.15-.75.36-.14.88-.31 1.86-.35 1.05-.05 1.37-.06 4.04-.06Zm0 3.38a4.82 4.82 0 1 0 0 9.64 4.82 4.82 0 0 0 0-9.64Zm0 7.95a3.13 3.13 0 1 1 0-6.26 3.13 3.13 0 0 1 0 6.26Zm6.14-8.14a1.13 1.13 0 1 1-2.25 0 1.13 1.13 0 0 1 2.25 0Z"/></svg>
                </a>
                <a href="#" class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0-.621.504-1.125 1.125-1.125h17.25c.621 0 1.125.504 1.125 1.125v10.5c0 .621-.504 1.125-1.125 1.125H3.375A1.125 1.125 0 0 1 2.25 17.25V6.75Zm0 0 9.75 6.75 9.75-6.75"/></svg>
                </a>
            </div>
        </div>
    </footer>

</body>
</html>