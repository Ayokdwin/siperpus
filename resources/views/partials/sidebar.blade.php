@php
    $currentUser = auth()->user();
    $isActive = fn(string $pattern) => request()->routeIs($pattern);
    $activeClasses = 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 font-medium';
    $inactiveClasses = 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800';
@endphp

<div x-data="{
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        toggleCollapse() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebarCollapsed', this.collapsed);
        }
    }"
    :class="collapsed ? 'w-[72px]' : 'w-[260px]'"
    class="relative flex flex-col h-screen shrink-0 border-r border-slate-200 bg-white transition-[width] duration-200 ease-in-out dark:border-slate-800 dark:bg-slate-900">

    {{-- Header --}}
    <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-3 dark:border-slate-800">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500 to-teal-500 text-sm font-semibold text-white">
            {{ strtoupper(substr($currentUser->name, 0, 1)) }}
        </div>

        <div x-show="!collapsed" class="min-w-0 flex-1">
            <span class="block truncate text-sm font-semibold text-slate-900 dark:text-slate-100">
                {{ $currentUser->name }}
            </span>
            <span class="capitalize text-xs text-emerald-600 dark:text-emerald-400">
                {{ $currentUser->role }}
            </span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-6 overflow-y-auto px-2 py-4">

        {{-- Dashboard --}}
        <div class="space-y-1">
            <a href="{{ route('dashboard') }}"
                :class="collapsed && 'justify-center'"
                class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $isActive('dashboard') ? $activeClasses : $inactiveClasses }}">
                <i class="fa-solid fa-house w-[18px] text-center"></i>
                <span x-show="!collapsed">Dashboard</span>
            </a>
        </div>

        {{-- ===================== --}}
        {{-- ADMIN & PETUGAS       --}}
        {{-- ===================== --}}
        @if($currentUser->role == 'admin' || $currentUser->role == 'petugas')

            {{-- Master Data --}}
            <div>
                <p x-show="!collapsed" class="mb-1 px-2.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Master Data
                </p>

                <div class="space-y-1">
                    {{-- Buku --}}
                    <a href="{{ route('buku.index') }}"
                        :class="collapsed && 'justify-center'"
                        class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $isActive('buku.*') ? $activeClasses : $inactiveClasses }}">
                        <i class="fa-solid fa-book w-[18px] text-center"></i>
                        <span x-show="!collapsed">Data Buku</span>
                    </a>

                    {{-- Kategori --}}
                    <a href="{{ route('kategori.index') }}"
                        :class="collapsed && 'justify-center'"
                        class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $isActive('kategori.*') ? $activeClasses : $inactiveClasses }}">
                        <i class="fa-solid fa-tags w-[18px] text-center"></i>
                        <span x-show="!collapsed">Kategori Buku</span>
                    </a>

                    {{-- User hanya admin --}}
                    @if($currentUser->role == 'admin')
                        <a href="{{ route('users.index') }}"
                            :class="collapsed && 'justify-center'"
                            class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $isActive('users.*') ? $activeClasses : $inactiveClasses }}">
                            <i class="fa-solid fa-users w-[18px] text-center"></i>
                            <span x-show="!collapsed">Data Pengguna</span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Transaksi --}}
            <div>
                <p x-show="!collapsed" class="mb-1 px-2.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Transaksi
                </p>

                <div class="space-y-1">
                    {{-- Peminjaman --}}
                    <a href="{{ route('peminjaman-buku.index') }}"
                        :class="collapsed && 'justify-center'"
                        class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $isActive('peminjaman-buku.index*') ? $activeClasses : $inactiveClasses }}">
                        <i class="fa-solid fa-book-open-reader w-[18px] text-center"></i>
                        <span x-show="!collapsed">Peminjaman</span>
                    </a>

                    {{-- Pengembalian --}}
                    <a href="{{route('pengembalian.index')}}"
                        :class="collapsed && 'justify-center'"
                        class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $isActive('pengembalian.index*') ? $activeClasses : $inactiveClasses }}">
                        <i class="fa-solid fa-rotate-left w-[18px] text-center"></i>
                        <span x-show="!collapsed">Pengembalian</span>
                    </a>
                </div>
            </div>

            {{-- ===================== --}}
            {{-- LAPORAN               --}}
            {{-- ===================== --}}
            @if($currentUser->role == 'admin')
            <div>
                <p x-show="!collapsed" class="mb-1 px-2.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Laporan
                </p>

                <div class="space-y-1">
                    <a href=""
                        :class="collapsed && 'justify-center'"
                        class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $isActive('laporan.*') ? $activeClasses : $inactiveClasses }}">
                        <i class="fa-solid fa-chart-column w-[18px] text-center"></i>
                        <span x-show="!collapsed">Laporan</span>
                    </a>
                </div>
            </div>
            @endif


        @endif

        {{-- ===================== --}}
        {{-- MENU KHUSUS ANGGOTA   --}}
        {{-- ===================== --}}
        @if($currentUser->role == 'anggota')
            <div>
                <p x-show="!collapsed" class="mb-1 px-2.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Perpustakaan
                </p>

                <div class="space-y-1">
                    {{-- Katalog Buku --}}
                    <a href="{{ route('peminjaman-buku.index') }}"
                        :class="collapsed && 'justify-center'"
                        class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $isActive('peminjaman-buku.index*') ? $activeClasses : $inactiveClasses }}">
                        <i class="fa-solid fa-book w-[18px] text-center"></i>
                        <span x-show="!collapsed">Katalog Buku</span>
                    </a>

                    {{-- Peminjaman Saya --}}
                    <a href="{{route('peminjaman-saya.show')}}"
                        :class="collapsed && 'justify-center'"
                        class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $isActive('peminjaman-saya.*') ? $activeClasses : $inactiveClasses }}">
                        <i class="fa-solid fa-book-open-reader w-[18px] text-center"></i>
                        <span x-show="!collapsed">Peminjaman Saya</span>
                    </a>

                    {{-- Riwayat --}}
                    <a href="{{route('riwayat-peminjaman.show')}}"
                        :class="collapsed && 'justify-center'"
                        class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $isActive('riwayat-peminjaman.*') ? $activeClasses : $inactiveClasses }}">
                        <i class="fa-solid fa-clock-rotate-left w-[18px] text-center"></i>
                        <span x-show="!collapsed">Riwayat Peminjaman</span>
                    </a>
                </div>
            </div>
        @endif

    </nav>

    {{-- ===================== --}}
    {{-- FOOTER                --}}
    {{-- ===================== --}}
    <div class="space-y-1 border-t border-slate-200 px-2 py-3 dark:border-slate-800">
        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                :class="collapsed && 'justify-center'"
                class="flex w-full items-center gap-3 rounded-lg px-2.5 py-2 text-sm transition-colors {{ $inactiveClasses }}">
                <i class="fa-solid fa-right-from-bracket w-[18px] text-center"></i>
                <span x-show="!collapsed">Logout</span>
            </button>
        </form>

    </div>

    {{-- Collapse Button --}}
    <button type="button"
        @click="toggleCollapse()"
        class="absolute -right-3 top-[60px] z-10 flex h-6 w-6 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 shadow-sm transition-colors hover:border-emerald-300 hover:text-emerald-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
        <i :class="collapsed && 'rotate-180'" class="fa-solid fa-angles-left text-xs transition-transform duration-200"></i>
    </button>

</div>
