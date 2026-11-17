<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard Umum
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// SEMUA ROUTE DI DALAM GRUP INI WAJIB LOGIN (Middleware: auth)
Route::middleware('auth')->group(function () {
    
    // 1. ROUTE PROFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. ROUTE KHUSUS ADMIN
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('dashboard');
        })->name('admin.dashboard');
        
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::put('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // 3. ROUTE KHUSUS PETUGAS
    Route::middleware(['role:petugas'])->group(function () {
        Route::get('/petugas/dashboard', function () {
            return view('dashboard');
        })->name('petugas.dashboard');
    });

    // 4. ROUTE ADMIN & PETUGAS (Laporan Perpustakaan)
    Route::middleware(['role:admin|petugas'])->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    // 5. ROUTE KELOLA DATA BUKU (Admin & Petugas melalui Gate)
    Route::middleware(['can:kelola-buku'])->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
    });

    // 6. ROUTE SEMUA ROLE: Admin, Petugas, Siswa (Lihat Buku)
    Route::middleware(['permission:Lihat daftar buku'])->group(function () {
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    });

    // 7. ROUTE PEMINJAMAN & PENGEMBALIAN BUKU
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    
    Route::middleware(['role:admin|petugas'])->group(function () {
        Route::patch('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    });

    // --- SOAL 2 (A2 Remediasi): Route Pencarian Buku Menggunakan Parameter Binding (Aman) ---
    Route::get('/buku-cari', function (Request $request) {
        $judul = $request->query('judul');
        $buku = DB::select("SELECT * FROM bukus WHERE judul = ?", [$judul]);
        return response()->json($buku);
    })->name('buku.cari');

    // --- SOAL 1 (A4): Route Detail Peminjaman (Wajib ditaruh PALING BAWAH) ---
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

});

require __DIR__.'/auth.php';

// Route::get('/uji-error', function () {
//     throw new \RuntimeException('Uji coba error production');
// });


