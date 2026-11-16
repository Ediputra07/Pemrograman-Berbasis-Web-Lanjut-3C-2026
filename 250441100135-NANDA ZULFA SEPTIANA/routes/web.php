<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\BukuCrudController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\RekapController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;

// 1. Halaman utama langsung diarahkan ke halaman login
// Route::get('/', function () {
//     return redirect()->route('login');
// });

// // 2. Memuat rute autentikasi bawaan Breeze (login, register, logout, dll)
// 

// // 3. Semua rute yang memerlukan autentikasi & verifikasi
// Route::middleware(['auth', 'verified'])->group(function () {
    
//     // --- DASHBOARD UTAMA (Diakses Admin & Petugas) ---
//     Route::get('/dashboard', [BukuCrudController::class, 'index'])->name('dashboard');

//     // --- CRUD BUKU (Tambah, Simpan, Edit, Update, Hapus) ---
//     Route::get('/buku-crud/create', [BukuCrudController::class, 'create'])->name('buku-crud.create');
//     Route::post('/buku-crud', [BukuCrudController::class, 'store'])->name('buku-crud.store');
//     Route::get('/buku-crud/{id}/edit', [BukuCrudController::class, 'edit'])->name('buku-crud.edit');
//     Route::put('/buku-crud/{id}', [BukuCrudController::class, 'update'])->name('buku-crud.update');
//     Route::delete('/buku-crud/{id}', [BukuCrudController::class, 'destroy'])->name('buku-crud.destroy');

//     // --- PENGELOLAAN PROFIL ---
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//     Route::get('/admin/peminjaman', [PeminjamanController::class, 'indexAdmin'])->name('admin.peminjaman.index');

//     // --- HAK AKSES KHUSUS ADMIN (Rekap) ---
//     Route::middleware(['role:admin'])->group(function () {
//         Route::get('/admin/rekap', [RekapController::class, 'index'])->name('admin.rekap');
//     });

//     // --- LIHAT DAFTAR & DETAIL BUKU (Umum) ---
//     Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
//     Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
// });

// Route::middleware(['auth', 'verified', 'role:siswa'])->group(function () {
//     Route::get('/siswa/dashboard', [BukuController::class, 'dashboardSiswa'])->name('siswa.dashboard');
//     // Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
//     Route::post('/buku/{id}/pinjam', [PeminjamanController::class, 'store'])->name('buku.pinjam');
//     Route::get('/siswa/riwayat', [PeminjamanController::class, 'riwayat'])->name('siswa.riwayat');
//     Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
// });

// Route::middleware(['auth', 'verified'])->group(function () {
// Route::get('/buku-cari', [BukuCrudController::class, 'cari'])->name('buku.cari');
//     // ==========================================
//     // HAK AKSES: ADMIN & PETUGAS (Operasional Buku & Peminjaman)
//     // ==========================================
//     Route::middleware(['role:admin|petugas'])->group(function () {
//         Route::get('/dashboard', [BukuCrudController::class, 'index'])->name('dashboard');
        
//         // Kelola Data Buku (Admin & Petugas)
//         Route::get('/buku-crud/create', [BukuCrudController::class, 'create'])->name('buku-crud.create');
//         Route::post('/buku-crud', [BukuCrudController::class, 'store'])->name('buku-crud.store');
//         Route::get('/buku-crud/{id}/edit', [BukuCrudController::class, 'edit'])->name('buku-crud.edit');
//         Route::put('/buku-crud/{id}', [BukuCrudController::class, 'update'])->name('buku-crud.update');
//         // Route::delete('/buku-crud/{id}', [BukuCrudController::class, 'destroy'])->name('buku-crud.destroy');
//         // Pastikan rute ini diletakkan di bagian atas (sebelum Route::resource jika ada)
//         // Route::get('/buku-crud-hapus/{id}', [BukuCrudController::class, 'destroy'])->name('buku-crud.destroy');

//         // // Route resource standar Laravel
//         // Route::resource('buku-crud', BukuCrudController::class);

//         // Kelola Peminjaman & Pengembalian (Admin & Petugas)
//         Route::get('/admin/peminjaman', [PeminjamanController::class, 'indexAdmin'])->name('admin.peminjaman.index');
//         Route::post('/admin/peminjaman/{id}/proses', [PeminjamanController::class, 'prosesAdmin'])->name('admin.peminjaman.proses');
//     });

//     // ==========================================
//     // HAK AKSES: KHUSUS ADMIN (Kelola Pengguna & Role)[cite: 3]
//     // ==========================================
//     Route::middleware(['role:admin'])->group(function () {
//         // Tempat khusus admin mengelola data pengguna & role[cite: 3]
//         // Route::resource('/admin/users', UserController::class);
//         Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
//         Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
//         Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
//     });

//     // ==========================================
//     // HAK AKSES: KHUSUS SISWA (Katalog, Peminjaman, Riwayat)[cite: 3]
//     // ==========================================
//     Route::middleware(['role:siswa'])->group(function () {
//         Route::get('/siswa/dashboard', [BukuController::class, 'dashboardSiswa'])->name('siswa.dashboard');
//         Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
        
//         // Mengajukan peminjaman & melihat status/riwayat sendiri[cite: 3]
//         Route::post('/buku/{id}/pinjam', [PeminjamanController::class, 'store'])->name('buku.pinjam');
//         Route::get('/siswa/riwayat', [PeminjamanController::class, 'riwayat'])->name('siswa.riwayat');
//         Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
//     });

//     // ==========================================
//     // PROFIL PENGGUNA (Semua Role: Lihat & Ubah Profil Sendiri)[cite: 3]
//     // ==========================================
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
 
//         Route::get('/hapus-buku-darurat/{id}', [BukuCrudController::class, 'destroy']);



Route::get('/hapus-buku-darurat/{id}', function ($id) {
    $buku = \App\Models\Buku::find($id);
    if ($buku) {
        $buku->delete();
        return "Buku dengan ID " . $id . " BERHASIL DIHAPUS!";
    }
    return "Buku tidak ditemukan di database.";
});
// 1. Halaman utama langsung diarahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/buku-cari', [BukuCrudController::class, 'cari'])->name('buku.cari');

    // ==========================================
    // HAK AKSES: ADMIN & PETUGAS (Operasional Buku & Peminjaman)
    // ==========================================
    Route::middleware(['role:admin|petugas'])->group(function () {
        Route::get('/dashboard', [BukuCrudController::class, 'index'])->name('dashboard');
        
        // Kelola Data Buku (Admin & Petugas)
        Route::get('/buku-crud/create', [BukuCrudController::class, 'create'])->name('buku-crud.create');
        Route::post('/buku-crud', [BukuCrudController::class, 'store'])->name('buku-crud.store');
        Route::get('/buku/create', [BukuCrudController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuCrudController::class, 'store'])->name('buku.store');
        Route::get('/buku-crud/{id}/edit', [BukuCrudController::class, 'edit'])->name('buku-crud.edit');
        Route::put('/buku-crud/{id}', [BukuCrudController::class, 'update'])->name('buku-crud.update');
        
        // RUTE HAPUS / CSRF DIAKTIFKAN DI SINI (DI DALAM MIDDLEWARE AUTH)
        Route::get('/hapus-buku-darurat/{id}', [BukuCrudController::class, 'hapusDarurat']);
        // Ubah menjadi support GET dan DELETE sekaligus
        Route::match(['get', 'delete'], '/hapus-buku-darurat/{id}', [BukuCrudController::class, 'destroy'])->name('buku-crud.destroy');
        // Route::get('/hapus-buku-darurat/{id}', [BukuCrudController::class, 'destroy']);
        // Kelola Peminjaman & Pengembalian (Admin & Petugas)
        Route::get('/admin/peminjaman', [PeminjamanController::class, 'indexAdmin'])->name('admin.peminjaman.index');
        Route::post('/admin/peminjaman/{id}/proses', [PeminjamanController::class, 'prosesAdmin'])->name('admin.peminjaman.proses');

        Route::get('/laporan/pdf', [BukuCrudController::class, 'cetakPdf'])->name('laporan.pdf');
    });

    // ==========================================
    // HAK AKSES: KHUSUS ADMIN (Kelola Pengguna & Role)
    // ==========================================
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    });

    // ==========================================
    // HAK AKSES: KHUSUS SISWA (Katalog, Peminjaman, Riwayat)
    // ==========================================
    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/siswa/dashboard', [BukuController::class, 'dashboardSiswa'])->name('siswa.dashboard');
        Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
        
        Route::post('/buku/{id}/pinjam', [PeminjamanController::class, 'store'])->name('buku.pinjam');
        Route::get('/siswa/riwayat', [PeminjamanController::class, 'riwayat'])->name('siswa.riwayat');
        Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    });

    // ==========================================
    // PROFIL PENGGUNA
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'can:kelola-buku'])->group(function () {
//     Route::get('/buku/create', [BukuCrudController::class, 'create'])->name('buku.create');
//     Route::post('/buku', [BukuCrudController::class, 'store'])->name('buku.store');
//     // route ubah dan hapus lainnya...
// });

Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
    ->middleware('auth')
    ->name('peminjaman.show');

require __DIR__.'/auth.php';
