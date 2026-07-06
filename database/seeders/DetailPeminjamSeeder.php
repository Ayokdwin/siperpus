<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\DetailPeminjam;
use App\Models\Peminjam;
use Illuminate\Database\Seeder;

class DetailPeminjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loan1 = Peminjam::where('tgl_peminjaman', '2026-07-01')->first();
        $loan2 = Peminjam::where('tgl_peminjaman', '2026-06-20')->first();

        $buku1 = Buku::where('kode_buku', 'BK001')->first();
        $buku2 = Buku::where('kode_buku', 'BK003')->first();
        $buku3 = Buku::where('kode_buku', 'BK004')->first();

        $details = [
            [$loan1?->id, $buku1?->id, 1],
            [$loan1?->id, $buku2?->id, 1],
            [$loan2?->id, $buku3?->id, 2],
        ];

        foreach ($details as [$peminjamanId, $bukuId, $jumlah]) {
            if (! $peminjamanId || ! $bukuId) {
                continue;
            }

            DetailPeminjam::updateOrCreate(
                [
                    'peminjaman_id' => $peminjamanId,
                    'buku_id' => $bukuId,
                ],
                [
                    'jumlah' => $jumlah,
                ]
            );
        }
    }
}
