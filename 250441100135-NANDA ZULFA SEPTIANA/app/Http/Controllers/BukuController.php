<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->latest()->get(); 
        
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|min:3',
            'penulis'      => 'required|string|min:3',
            'tahun_terbit' => 'required|integer|min:1901|max:2026',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|min:3',
            'penulis'      => 'required|string|min:3',
            'tahun_terbit' => 'required|integer|min:1901|max:2026',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }

    public function dashboardSiswa()
{
    // Mengambil semua data buku beserta relasi kategorinya
    $bukus = Buku::with('kategori')->get();
    
    return view('siswa.dashboard', compact('bukus'));
}

public function show($id)
{
    $buku = Buku::with('kategori')->findOrFail($id);
    return view('buku.show', compact('buku')); // <-- Harus mereturn view, bukan response()->json()
}
}

