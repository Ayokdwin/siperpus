@extends('layouts.master')

@section('content')
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-6xl mx-auto space-y-6">

            {{-- Page header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Data Pengguna</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Kelola akun admin, petugas, dan anggota perpustakaan</p>
                </div>

                <a href="{{ route('users.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm
                           hover:bg-emerald-700 transition-colors">
                    <i class="fa-solid fa-plus text-xs"></i>
                    Tambah Pengguna
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

            {{-- Card --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                {{-- Toolbar: search + filter role --}}
                <div class="flex flex-col gap-3 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-800">
                    <form method="GET" action="{{ route('users.index') }}" class="relative w-full sm:w-72">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama atau email..."
                            class="w-full pl-9 pr-3 py-2 rounded-lg text-sm
                                   bg-slate-100 dark:bg-slate-800
                                   border border-transparent focus:border-emerald-400 dark:focus:border-emerald-500
                                   focus:bg-white dark:focus:bg-slate-900
                                   text-slate-700 dark:text-slate-200 placeholder:text-slate-400
                                   outline-none focus:ring-2 focus:ring-emerald-100 dark:focus:ring-emerald-500/20
                                   transition-colors"
                        />
                    </form>

                    <div class="flex items-center gap-2">
                        <label for="role" class="text-sm text-slate-500 dark:text-slate-400 shrink-0">Role:</label>
                        <select
                            id="role"
                            onchange="window.location.href = this.value"
                            class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none
                                   dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:ring-emerald-500/20">
                            <option value="{{ route('users.index', array_filter(['search' => request('search')])) }}"
                                {{ request('role') ? '' : 'selected' }}>Semua Role</option>
                            <option value="{{ route('users.index', array_filter(['search' => request('search'), 'role' => 'admin'])) }}"
                                {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="{{ route('users.index', array_filter(['search' => request('search'), 'role' => 'petugas'])) }}"
                                {{ request('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="{{ route('users.index', array_filter(['search' => request('search'), 'role' => 'anggota'])) }}"
                                {{ request('role') === 'anggota' ? 'selected' : '' }}>Anggota</option>
                        </select>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-4 py-3 font-medium">#</th>
                                <th class="px-4 py-3 font-medium">Nama</th>
                                <th class="px-4 py-3 font-medium">Email</th>
                                <th class="px-4 py-3 font-medium">Role</th>
                                <th class="px-4 py-3 font-medium">Kode Anggota</th>
                                <th class="px-4 py-3 font-medium">Alamat</th>
                                <th class="px-4 py-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($users as $user)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-4 py-3 text-slate-500 dark:text-slate-400">
                                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full
                                                        bg-gradient-to-br from-emerald-500 to-teal-500 text-xs font-semibold text-white">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-slate-800 dark:text-slate-100">{{ $user->name }}</span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $user->email }}</td>

                                    <td class="px-4 py-3">
                                        @php
                                            $roleBadge = match ($user->role) {
                                                'admin' => 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
                                                'petugas' => 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                                                default => 'bg-sky-50 text-sky-700 dark:bg-sky-500/10 dark:text-sky-400',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium capitalize {{ $roleBadge }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        {{ $user->kode_anggota ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300 max-w-[200px] truncate">
                                        {{ $user->alamat ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('users.show', $user->id) }}"
                                               class="w-8 h-8 inline-flex items-center justify-center rounded-lg
                                                      text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400
                                                      hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors">
                                                <i class="fa-solid fa-eye text-sm"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                title="Edit"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500
                                                       hover:bg-emerald-50 hover:text-emerald-600
                                                       dark:text-slate-400 dark:hover:bg-emerald-500/10 dark:hover:text-emerald-400
                                                       transition-colors">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </a>

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500
                                                           hover:bg-rose-50 hover:text-rose-600
                                                           dark:text-slate-400 dark:hover:bg-rose-500/10 dark:hover:text-rose-400
                                                           transition-colors">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fa-solid fa-users-slash text-2xl mb-2 block"></i>
                                        Belum ada data pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($users->hasPages())
                    <div class="border-t border-slate-200 px-4 py-3 dark:border-slate-800">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
