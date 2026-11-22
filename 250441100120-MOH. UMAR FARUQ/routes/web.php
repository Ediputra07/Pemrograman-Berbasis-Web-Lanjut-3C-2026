<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\PermissionMiddleware;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware(PermissionMiddleware::using('lihat profil sendiri'))
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware(PermissionMiddleware::using('ubah profil sendiri'))
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware(PermissionMiddleware::using('ubah profil sendiri'))
        ->name('profile.destroy');
});

Route::middleware(['auth', PermissionMiddleware::using('kelola data buku')])->group(function () {
    Route::resource('buku', BukuController::class);
});

Route::middleware(['auth', PermissionMiddleware::using('kelola data pengguna')])->group(function () {
    Route::resource('users', UserController::class)->except('show');
});

Route::middleware(['auth', PermissionMiddleware::using('kelola role pengguna')])->group(function () {
    Route::get('/users/roles', [UserController::class, 'roles'])->name('users.roles.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.roles.update');
});

Route::middleware(['auth', PermissionMiddleware::using('kelola pengembalian')])->group(function () {
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::put('/pengembalian/{peminjaman}', [PengembalianController::class, 'update'])
        ->middleware(PermissionMiddleware::using('mencatat pengembalian buku'))
        ->name('pengembalian.update');
});

Route::middleware(['auth', PermissionMiddleware::using('lihat laporan perpustakaan')])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

Route::middleware(['auth', PermissionMiddleware::using('lihat daftar buku')])->group(function () {
    Route::get('/katalog-buku', [BukuController::class, 'katalog'])->name('buku.katalog');
});

Route::middleware(['auth', PermissionMiddleware::using('mengajukan peminjaman buku')])->group(function () {
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/peminjaman/status', [PeminjamanController::class, 'status'])
        ->middleware(PermissionMiddleware::using('melihat status peminjaman sendiri'))
        ->name('peminjaman.status');
    Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'index'])
        ->middleware(PermissionMiddleware::using('melihat riwayat peminjaman sendiri'))
        ->name('peminjaman.index');
    Route::get('/peminjaman-saya', [PeminjamanController::class, 'index'])
        ->middleware(PermissionMiddleware::using('melihat riwayat peminjaman sendiri'))
        ->name('peminjaman.saya');

    Route::put('/kelola-peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])
        ->middleware(PermissionMiddleware::using('kelola peminjaman'))
        ->middleware(PermissionMiddleware::using('memproses persetujuan peminjaman'))
        ->name('peminjaman.setujui');
    Route::put('/kelola-peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])
        ->middleware(PermissionMiddleware::using('kelola peminjaman'))
        ->middleware(PermissionMiddleware::using('memproses persetujuan peminjaman'))
        ->name('peminjaman.tolak');
    Route::get('/kelola-peminjaman', [PeminjamanController::class, 'kelola'])
        ->middleware(PermissionMiddleware::using('kelola peminjaman'))
        ->name('peminjaman.kelola');
});

require __DIR__.'/auth.php';