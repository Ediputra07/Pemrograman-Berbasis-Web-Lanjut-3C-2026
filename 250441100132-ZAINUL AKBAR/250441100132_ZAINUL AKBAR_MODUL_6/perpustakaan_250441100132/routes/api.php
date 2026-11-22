<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('buku', BukuController::class)->names('api.buku');


Route::get('/rekap/buku-per-kategori', [BukuController::class, 'rekapBukuPerKategori']);
Route::get('/rekap/peminjaman-per-buku', [BukuController::class, 'rekapPeminjamanPerBuku']);