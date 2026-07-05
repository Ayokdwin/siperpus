<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    private function generateKodeAnggota()
    {
        $lastUser = User::whereNotNull('kode_anggota')
            ->orderByDesc('id')
            ->first();

        if (!$lastUser) {
            return 'AGT0001';
        }

        $lastNumber = (int) substr($lastUser->kode_anggota, 3);

        return 'AGT' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'in:admin,petugas,anggota'],
            'kode_anggota' => ['nullable', 'string', 'max:50', 'unique:users,kode_anggota'],
            'alamat' => ['nullable', 'string'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($validated['role'] === 'anggota') {
            $validated['kode_anggota'] = $this->generateKodeAnggota();
        } else {
            $validated['kode_anggota'] = null;
        }

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'role' => ['required', 'in:admin,petugas,anggota'],
            'kode_anggota' => ['nullable', 'string', 'max:50', 'unique:users,kode_anggota,' . $user->id],
            'alamat' => ['nullable', 'string'],
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($validated['role'] === 'anggota') {
            if (!$user->kode_anggota) {
                    $validated['kode_anggota'] = $this->generateKodeAnggota();
                }
            } else {
                $validated['kode_anggota'] = null;
            }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

}
