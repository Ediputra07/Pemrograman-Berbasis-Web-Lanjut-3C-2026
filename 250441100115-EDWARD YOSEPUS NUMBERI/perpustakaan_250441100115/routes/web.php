<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\UserController; // Sesuaikan namespace controller user jika ada
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil Pengguna (Bisa diakses semua role yang login)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Daftar Buku (Bisa diakses semua role yang login)
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

    // KHUSUS ADMIN & PETUGAS: Manajemen Data Buku, Peminjaman, dan Laporan
    Route::middleware(['role:admin|petugas'])->group(function () {
        // Kelola Buku (CRUD Buku)
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

        // Peminjaman & Pengembalian (Menggunakan Resource agar lengkap untuk transaksi & pengembalian)
        Route::resource('peminjaman', PeminjamanController::class);

        // KHUSUS ADMIN & PETUGAS: Kelola Peminjaman & Pengembalian
    Route::middleware(['role:admin|petugas'])->group(function () {
        // Menampilkan daftar seluruh peminjaman yang sedang aktif
        Route::get('/admin/peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman.index');
        
        // Memproses pengembalian buku
        Route::put('/admin/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembalikan'])->name('admin.peminjaman.kembali');
    });
        
        // Lihat Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    // KHUSUS ADMIN SAJA: Kelola Pengguna, Akun, dan Penetapan Role
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    });

    // KHUSUS SISWA: Pengajuan Peminjaman & Status Mandiri
    Route::middleware(['role:siswa'])->group(function () {
        // Riwayat peminjaman milik siswa yang sedang login
        Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayat'])->name('siswa.peminjaman.riwayat');
        
        // Jika siswa ingin mengajukan peminjaman buku baru, tambahkan rutenya di sini
        Route::post('/buku/{id}/pinjam', [PeminjamanController::class, 'storeSiswa'])->name('siswa.pinjam');
    });

        Route::get('/laporan', [PeminjamanController::class, 'laporan'])->name('laporan.index');   
    });    

require __DIR__.'/auth.php';