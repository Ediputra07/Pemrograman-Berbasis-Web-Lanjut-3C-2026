<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\BukuCrudController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');

Route::get('/kelola-buku', [BukuCrudController::class, 'index'])->name('kelola-buku.index');