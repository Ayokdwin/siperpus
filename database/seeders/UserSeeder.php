<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'role' => 'admin',
            'email' => 'admin@perpus.com',
            'kode_anggota' => null,
            'alamat' => 'Yogyakarta',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Petugas Perpustakaan',
            'role' => 'petugas',
            'email' => 'petugas@perpus.com',
            'kode_anggota' => null,
            'alamat' => 'Yogyakarta',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Anggota',
            'role' => 'anggota',
            'email' => 'anggota@perpus.com',
            'kode_anggota' => 'AGT001',
            'alamat' => 'Yogyakarta',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
    }
}
