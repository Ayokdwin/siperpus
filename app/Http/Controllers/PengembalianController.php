<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index(){
        $peminjams = Peminjam::with('anggota','petugas')->get();
        return view('pengembalian.index',compact('peminjams'));
    }
    public function konfirmasi($id)
    {
        $peminjam = Peminjam::with(['anggota', 'detailPeminjaman.buku'])
            ->where('status', 'dipinjam')
            ->findOrFail($id);
            return view('pengembalian.konfirmasi', compact('peminjam'));
    }
    public function proses(Request $request, $id)
    {
        $request->validate([
            'tgl_pengembalian' => 'required|date',
            'denda'            => 'required|integer|min:0',
        ]);
 
        $peminjam = Peminjam::with('detailPeminjaman.buku')
            ->where('status', 'dipinjam')
            ->findOrFail($id);
 
        DB::transaction(function () use ($peminjam, $request) {
            $peminjam->update([
                'tgl_pengembalian' => $request->tgl_pengembalian,
                'denda'            => $request->denda,
                'status'           => 'dikembalikan',
            ]);
 
            foreach ($peminjam->detailPeminjaman as $detail) {
                $detail->buku()->increment('stok', $detail->jumlah);
            }
        });
 
        return redirect()
            ->route('pengembalian.index')
            ->with('success', 'Pengembalian buku berhasil dikonfirmasi.');
    }
}
