<?php

use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;
use Illuminate\Support\Facades\Route;


Route::apiResource('buku', BukuController::class)->names('api.buku');


Route::prefix('rekap')->name('api.rekap.')->controller(RekapController::class)->group(function () {
    Route::get('buku-per-kategori', 'bukuPerKategori')->name('buku-per-kategori');
    Route::get('peminjaman-per-buku', 'peminjamanPerBuku')->name('peminjaman-per-buku');

    
    Route::get('pemminjaman-per-buku', 'peminjamanPerBuku')->name('pemminjaman-per-buku');
});