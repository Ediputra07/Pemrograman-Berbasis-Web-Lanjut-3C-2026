<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku untuk semua mahasiswa dari database terpusat.
     */
    public function index(Request $request)
    {
        // Mengambil data buku dari database, di mana tahun terbit dibatasi minimal 2000 (menghilangkan tahun 1900-an/1980)
        // Serta diurutkan dari yang terbaru
        $books = Buku::with('kategori')
                    ->where('tahun_terbit', '>=', 2000)
                    ->latest()
                    ->get();

        return view('daftar-buku.index', compact('books'));
    }

    /**
     * Menampilkan detail buku berdasarkan ID dari database.
     */
    public function show($id)
    {
        $book = Buku::with(['kategori', 'peminjamans'])->findOrFail($id);

        return view('daftar-buku.detail', compact('book'));
    }
}