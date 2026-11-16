<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Bungkus dengan middleware web dan auth agar Session login Laravel Breeze terbaca
Route::middleware(['web', 'auth'])->group(function () {
    
    // Route Rekapitulasi API
    Route::get('/rekap/buku-per-kategori', [BukuController::class, 'rekapBukuPerKategori']);
    Route::get('/rekap/peminjaman-per-buku', [BukuController::class, 'rekapPeminjamanPerBuku']);

    // Route API Resource Buku
    Route::apiResource('buku', BukuController::class)->names('api.buku');
});