<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'kategori' => 'Fiksi',
                'kode_buku' => 'BK001',
                'judul_buku' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'penerbit' => 'KPG',
                'tahun_terbit' => 2017,
                'stok' => 5,
                'deskripsi' => 'Novel fiksi sejarah tentang ingatan dan kehilangan.',
            ],
            [
                'kategori' => 'Fiksi',
                'kode_buku' => 'BK002',
                'judul_buku' => 'Bumi',
                'penulis' => 'Tere Liye',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2014,
                'stok' => 7,
                'deskripsi' => 'Petualangan fantasi remaja dengan dunia paralel.',
            ],
            [
                'kategori' => 'Nonfiksi',
                'kode_buku' => 'BK003',
                'judul_buku' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'penerbit' => 'Avery',
                'tahun_terbit' => 2018,
                'stok' => 4,
                'deskripsi' => 'Panduan membangun kebiasaan kecil yang berdampak besar.',
            ],
            [
                'kategori' => 'Teknologi',
                'kode_buku' => 'BK004',
                'judul_buku' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'penerbit' => 'Prentice Hall',
                'tahun_terbit' => 2008,
                'stok' => 3,
                'deskripsi' => 'Prinsip menulis kode yang rapi dan mudah dirawat.',
            ],
            [
                'kategori' => 'Pendidikan',
                'kode_buku' => 'BK005',
                'judul_buku' => 'Metode Penelitian Pendidikan',
                'penulis' => 'Sugiyono',
                'penerbit' => 'Alfabeta',
                'tahun_terbit' => 2022,
                'stok' => 6,
                'deskripsi' => 'Buku rujukan penelitian di bidang pendidikan.',
            ],
            [
                'kategori' => 'Referensi',
                'kode_buku' => 'BK006',
                'judul_buku' => 'Kamus Besar Bahasa Indonesia',
                'penulis' => 'Badan Bahasa',
                'penerbit' => 'Kemendikbud',
                'tahun_terbit' => 2023,
                'stok' => 2,
                'deskripsi' => 'Referensi bahasa Indonesia untuk penggunaan sehari-hari.',
            ],
        ];

        foreach ($books as $book) {
            $kategoriId = Kategori::where('name_kategori', $book['kategori'])->value('id');

            if (! $kategoriId) {
                continue;
            }

            Buku::updateOrCreate(
                ['kode_buku' => $book['kode_buku']],
                [
                    'kategori_id' => $kategoriId,
                    'judul_buku' => $book['judul_buku'],
                    'penulis' => $book['penulis'],
                    'penerbit' => $book['penerbit'],
                    'tahun_terbit' => $book['tahun_terbit'],
                    'stok' => $book['stok'],
                    'deskripsi' => $book['deskripsi'],
                    'cover' => null,
                ]
            );
        }
    }
}
