@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-6xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('users.index') }}"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500
                               hover:bg-slate-100 hover:text-slate-700
                               dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200
                               transition-colors">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Detail Pengguna</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Informasi lengkap akun pengguna</p>
                    </div>
                </div>

                <a href="{{ route('users.edit', $user->id) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                           hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-pen text-xs"></i>
                    Edit
                </a>
            </div>

            {{-- Alert sukses --}}
            @if (session('success'))
                <div class="flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700
                            dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Profile card --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex flex-col items-center gap-4 border-b border-slate-100 p-6 text-center dark:border-slate-800 sm:flex-row sm:text-left">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full
                                bg-gradient-to-br from-emerald-500 to-teal-500 text-xl font-semibold text-white">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $user->name }}</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                    </div>

                    @php
                        $roleBadge = match ($user->role) {
                            'admin' => 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
                            'petugas' => 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                            default => 'bg-sky-50 text-sky-700 dark:bg-sky-500/10 dark:text-sky-400',
                        };
                    @endphp
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium capitalize {{ $roleBadge }}">
                        {{ $user->role }}
                    </span>
                </div>

                {{-- Detail fields --}}
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 p-6 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Nama Lengkap</p>
                        <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">{{ $user->name }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Email</p>
                        <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Role</p>
                        <p class="mt-1 text-sm capitalize text-slate-800 dark:text-slate-200">{{ $user->role }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Kode Anggota</p>
                        <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">{{ $user->kode_anggota ?? '-' }}</p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Alamat</p>
                        <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">{{ $user->alamat ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Email Terverifikasi</p>
                        <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">
                            @if ($user->email_verified_at)
                                <span class="inline-flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400">
                                    <i class="fa-solid fa-circle-check text-xs"></i>
                                    {{ $user->email_verified_at->translatedFormat('d M Y, H:i') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-slate-400">
                                    <i class="fa-solid fa-circle-xmark text-xs"></i>
                                    Belum diverifikasi
                                </span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Terdaftar Sejak</p>
                        <p class="mt-1 text-sm text-slate-800 dark:text-slate-200">
                            {{ $user->created_at->translatedFormat('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Riwayat peminjaman (jika role anggota) --}}
            @if ($user->role === 'anggota' && isset($user->peminjams) && $user->peminjams->isNotEmpty())
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Riwayat Peminjaman Terakhir</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Tanggal Pinjam</th>
                                    <th class="px-6 py-3 font-medium">Jatuh Tempo</th>
                                    <th class="px-6 py-3 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($user->peminjams->take(5) as $peminjam)
                                    <tr>
                                        <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                            {{ optional($peminjam->tanggal_pinjam)->translatedFormat('d M Y') ?? '-' }}
                                        </td>
                                        <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                            {{ optional($peminjam->tanggal_jatuh_tempo)->translatedFormat('d M Y') ?? '-' }}
                                        </td>
                                        <td class="px-6 py-3">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium capitalize
                                                @if ($peminjam->status === 'dikembalikan')
                                                    bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400
                                                @else
                                                    bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                                                @endif
                                            ">
                                                {{ $peminjam->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Action buttons --}}
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('users.index') }}"
                    class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600
                           hover:bg-slate-100
                           dark:text-slate-300 dark:hover:bg-slate-800
                           transition-colors">
                    &larr; Kembali ke Daftar
                </a>

                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-medium text-rose-600
                               hover:bg-rose-100
                               dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20
                               transition-colors">
                        <i class="fa-solid fa-trash text-xs"></i>
                        Hapus Pengguna
                    </button>
                </form>
            </div>
        </div>
    </main>
@endsection
