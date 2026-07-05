<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'name_kategori',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}
