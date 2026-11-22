<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kelola\PeminjamanController as KelolaPeminjamanController;
use App\Http\Controllers\Kelola\PengembalianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman beranda: terbuka untuk umum
Route::get('/', function () {
    return view('beranda');
})->name ('home');


Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //  Buku: tambah, ubah, hapus (Gate kelola-buku; didaftarkan lebih dulu agar /buku/create tidak ditangkap /buku/{id})

    // Buku: tambah, ubah, hapus (Gate kelola-buku)
    Route::middleware('can:kelola-buku')->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])
            ->name('buku.create');

        Route::post('/buku', [BukuController::class, 'store'])
            ->name('buku.store');

        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])
            ->name('buku.edit');

        Route::put('/buku/{buku}', [BukuController::class, 'update'])
            ->name('buku.update');

        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
            ->name('buku.destroy');
    });

    // Buku: lihat
    Route::middleware('permission:lihat daftar buku')->group(function () {
        Route::get('/buku', [BukuController::class, 'index'])
            ->name('buku.index');

        Route::get('/buku/{id}', [BukuController::class, 'show'])
            ->name('buku.show');
    });

    // Pencarian buku
    Route::get('/buku-cari', [BukuController::class, 'cari'])
        ->name('buku.cari');


    //  Profil 
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')
        ->name('profile.update');

    //  Peminjaman 
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->middleware('permission:mengajukan peminjaman buku')
        ->name('peminjaman.store');
    // Detail peminjaman (A4 diperbaiki: kepemilikan diperiksa PeminjamanPolicy di controller)
    // A4 (Soal 1): sengaja rentan terhadap IDOR, sesuai spesifikasi praktikum.
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
        ->name('peminjaman.show');
    Route::get('/peminjaman-saya', [PeminjamanController::class, 'status'])
        ->middleware('permission:melihat status peminjaman sendiri')
        ->name('peminjaman.status');
    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayatSaya'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')
        ->name('peminjaman.riwayat');
    Route::get('/anggota/{anggota}/riwayat', [PeminjamanController::class, 'riwayatAnggota'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')
        ->name('anggota.riwayat');

    //  Dashboard Admin 
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware(['role:admin', 'permission:akses dashboard admin'])
        ->name('admin.dashboard');

    //  Dashboard Petugas
    Route::get('/petugas/dashboard', [PetugasDashboardController::class, 'index'])
        ->middleware(['role:petugas', 'permission:akses dashboard petugas'])
        ->name('petugas.dashboard');

    //  Kelola pengguna & role 
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('permission:kelola data pengguna')->group(function () {
            Route::resource('pengguna', PenggunaController::class)
                ->except('show')
                ->parameters(['pengguna' => 'pengguna']);
        });

        Route::patch('pengguna/{pengguna}/role', [PenggunaController::class, 'updateRole'])
            ->middleware('permission:kelola role pengguna')
            ->name('pengguna.role');
    });

    // Operasional peminjaman & pengembalian 
    Route::prefix('kelola')->name('kelola.')->group(function () {
        Route::get('peminjaman', [KelolaPeminjamanController::class, 'index'])
            ->middleware('permission:kelola peminjaman')
            ->name('peminjaman.index');
        Route::post('peminjaman/{peminjaman}/setujui', [KelolaPeminjamanController::class, 'setujui'])
            ->middleware('permission:memproses persetujuan peminjaman')
            ->name('peminjaman.setujui');
        Route::post('peminjaman/{peminjaman}/tolak', [KelolaPeminjamanController::class, 'tolak'])
            ->middleware('permission:memproses persetujuan peminjaman')
            ->name('peminjaman.tolak');

        Route::get('pengembalian', [PengembalianController::class, 'index'])
            ->middleware('permission:kelola pengembalian')
            ->name('pengembalian.index');
        Route::post('pengembalian/{peminjaman}/catat', [PengembalianController::class, 'catat'])
            ->middleware('permission:mencatat pengembalian buku')
            ->name('pengembalian.catat');
    });



    //  Laporan perpustakaan 
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')
        ->name('laporan.index');
});


require __DIR__ . '/auth.php';
