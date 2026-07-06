<?php

namespace Database\Seeders;

use App\Models\Peminjam;
use App\Models\User;
use Illuminate\Database\Seeder;

class PeminjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $petugasId = User::where('email', 'petugas@perpus.com')->value('id');
        $anggotaSatuId = User::where('email', 'anggota1@perpus.com')->value('id');
        $anggotaDuaId = User::where('email', 'anggota2@perpus.com')->value('id');

        $loans = [
            [
                'user_id' => $anggotaSatuId,
                'petugas_id' => $petugasId,
                'tgl_peminjaman' => '2026-07-01',
                'tgl_jatuh_tempo' => '2026-07-08',
                'tgl_pengembalian' => null,
                'denda' => 0,
                'status' => 'dipinjam',
            ],
            [
                'user_id' => $anggotaDuaId,
                'petugas_id' => $petugasId,
                'tgl_peminjaman' => '2026-06-20',
                'tgl_jatuh_tempo' => '2026-06-27',
                'tgl_pengembalian' => '2026-06-28',
                'denda' => 5000,
                'status' => 'dikembalikan',
            ],
        ];

        foreach ($loans as $loan) {
            if (! $loan['user_id'] || ! $loan['petugas_id']) {
                continue;
            }

            Peminjam::updateOrCreate(
                [
                    'user_id' => $loan['user_id'],
                    'petugas_id' => $loan['petugas_id'],
                    'tgl_peminjaman' => $loan['tgl_peminjaman'],
                ],
                $loan
            );
        }
    }
}
