<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;

Route::redirect('/', '/login');

// Rute Umum yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Rute Daftar Buku (Dapat diakses oleh Admin, Petugas, dan Siswa yang login)
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
});

// Rute Buku Umum (Bisa diakses user terautentikasi, atau sesuaikan kebutuhan)
Route::middleware(['auth'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

    // Pindahkan rute CRUD ini ke sini agar URL-nya menjadi /buku dan /buku/{id}
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // Tambahkan ini jika belum ada:
    Route::get('/buku/pinjam/{id}', [PeminjamanController::class, 'create'])->name('buku.pinjam');
    Route::post('/buku/pinjam', [PeminjamanController::class, 'store'])->name('buku.store_pinjam');
});

// Rute Pengelolaan Peminjaman (Admin & Petugas)
Route::middleware(['auth', 'role:admin|petugas'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::patch('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
    Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
    Route::patch('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    // Fitur Tambah/Edit/Hapus Buku khusus Admin & Petugas (Sesuai Modul 4 & 5)
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
});

// Rute Dashboard Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// Rute Kelola Pengguna & Role (Khusus Admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Rute Dashboard Petugas
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->name('dashboard');
});

// Rute Khusus Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('dashboard');

    // Katalog Buku untuk Siswa
    Route::get('/buku', [BukuController::class, 'katalogSiswa'])->name('buku');

    // Form & Proses Pengajuan Peminjaman
    Route::get('/peminjaman/ajukan/{bukuId}', [PeminjamanController::class, 'formAjukan'])->name('peminjaman.form');
    Route::post('/peminjaman/ajukan/{bukuId}', [PeminjamanController::class, 'ajukan'])->name('peminjaman.ajukan');

    // Riwayat & Status Peminjaman Sendiri
    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayatSiswa'])->name('riwayat');
});

// Rute Laporan (Admin & Petugas)
Route::middleware(['auth', 'role:admin|petugas'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/laporan', [PeminjamanController::class, 'laporan'])->name('laporan.index');
});

// A2
Route::middleware(['auth'])->group(function () {
    Route::get('/buku-cari', [BukuController::class, 'cari'])->middleware('auth');
});

// A3
// Route::middleware(['auth'])->group(function () {
//     Route::get('/buku/{buku}/hapus', [BukuController::class, 'destroy'])->middleware('auth');
// });

// A4
Route::middleware(['auth'])->group(function () {
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
});

// Soal no 3
Route::middleware(['auth', 'can:kelola-buku'])->group(function () {
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
});

// soal 4
Route::middleware(['auth'])->group(function () {
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
});

// soal 5
Route::get('/test-error', function () {
    throw new \RuntimeException('Uji coba error sistem.');
});

require __DIR__ . '/auth.php';