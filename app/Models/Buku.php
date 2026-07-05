<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\DetailPeminjam;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'kategori_id',
        'kode_buku',
        'judul_buku',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'deskripsi',
        'cover',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjam::class, 'buku_id');
    }
}
