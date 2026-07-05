<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Peminjam extends Model
{
    protected $table = 'peminjams';

    protected $fillable = [
        'user_id',
        'petugas_id',
        'tgl_peminjaman',
        'tgl_jatuh_tempo',
        'tgl_pengembalian',
        'denda',
        'status',
    ];
    public function anggota()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjam::class, 'peminjaman_id');
    }
}
