<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index(){
        $peminjams = Peminjam::with('anggota','petugas')->get();
        return view('pengembalian.index',compact('peminjams'));
    }
}
