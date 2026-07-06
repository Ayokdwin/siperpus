<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            'Fiksi',
            'Nonfiksi',
            'Teknologi',
            'Pendidikan',
            'Referensi',
        ];

        foreach ($kategoris as $name) {
            Kategori::updateOrCreate(
                ['name_kategori' => $name],
                ['name_kategori' => $name]
            );
        }
    }
}
