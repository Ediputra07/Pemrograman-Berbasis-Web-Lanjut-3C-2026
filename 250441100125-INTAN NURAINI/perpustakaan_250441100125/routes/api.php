<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RekapController;
use App\Http\Controllers\Api\BukuController;

// Menampilkan daftar dan detail buku.
// Kedua route ini tetap tersedia untuk pengguna.
Route::apiResource('buku', BukuController::class)
    ->only(['index', 'show']);

// Menambah dan mengedit buku.
// Hanya pengguna yang login dengan role Admin atau Petugas.
Route::middleware(['web', 'auth', 'can:kelola-buku'])->group(function () {

    // Tambah buku
    Route::post('/buku', [BukuController::class, 'store'])
        ->name('buku.store');

    // Edit buku
    Route::match(['put', 'patch'], '/buku/{id}', [BukuController::class, 'update'])
        ->name('buku.update');
});

// Rekap buku berdasarkan kategori
Route::get(
    '/rekap/buku-per-kategori',
    [RekapController::class, 'bukuPerKategori']
);

// Rekap peminjaman berdasarkan buku
Route::get(
    '/rekap/pemminjaman-per-buku',
    [RekapController::class, 'peminjamanPerBuku']
);
