<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamController extends Controller
{
    public function riwayat()
    {
        $peminjams = Peminjam::where('user_id',Auth::id())->get();
        return view('peminjam.riwayat',compact('peminjams'));
    }
    public function show()
    {
        $peminjams = Peminjam::where('user_id',Auth::id())->get();
        return view('peminjam.show',compact('peminjams'));
    }
}
