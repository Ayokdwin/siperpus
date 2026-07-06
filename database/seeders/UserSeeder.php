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
        $users = [
            [
                'name' => 'Administrator',
                'role' => 'admin',
                'email' => 'admin@perpus.com',
                'kode_anggota' => null,
                'alamat' => 'Yogyakarta',
            ],
            [
                'name' => 'Petugas Perpustakaan',
                'role' => 'petugas',
                'email' => 'petugas@perpus.com',
                'kode_anggota' => null,
                'alamat' => 'Yogyakarta',
            ],
            [
                'name' => 'Anggota Satu',
                'role' => 'anggota',
                'email' => 'anggota1@perpus.com',
                'kode_anggota' => 'AGT001',
                'alamat' => 'Yogyakarta',
            ],
            [
                'name' => 'Anggota Dua',
                'role' => 'anggota',
                'email' => 'anggota2@perpus.com',
                'kode_anggota' => 'AGT002',
                'alamat' => 'Sleman',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData + [
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}
