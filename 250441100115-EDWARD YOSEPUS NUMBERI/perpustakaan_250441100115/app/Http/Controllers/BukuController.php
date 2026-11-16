<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku; // Pastikan model Buku sudah di-import

class BukuController extends Controller
{
    public function index()
    {
        // Ambil semua data buku (bisa ditambah dengan relasi kategori jika ada: Buku::with('kategori')->get())
        $bukus = Buku::all(); 

        // Kirim data ke view dengan compact hanya sekali
        return view('buku.index', compact('bukus')); 
    }
}