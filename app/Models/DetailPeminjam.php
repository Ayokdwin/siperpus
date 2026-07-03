<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Peminjam;
use app\Models\Buku;

class DetailPeminjam extends Model
{
    protected $table = 'detail_peminjams';

    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'jumlah',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjam::class, 'peminjaman_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
