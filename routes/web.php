<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamController;
use App\Models\Peminjam;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/katalog-buku', [BukuController::class, 'userIndex'])->name('katalog-buku.index');
    Route::get('/show/{id}',[BukuController::class,'userShow'])->name('katalog-buku.show');
    Route::get('/riwayat-peminjaman',[PeminjamController::class,'riwayat'])->name('riwayat-peminjaman.show');
    Route::get('/peminjaman-saya',[PeminjamController::class,'show'])->name('peminjaman-saya.show');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('buku', BukuController::class);
});

require __DIR__.'/auth.php';
