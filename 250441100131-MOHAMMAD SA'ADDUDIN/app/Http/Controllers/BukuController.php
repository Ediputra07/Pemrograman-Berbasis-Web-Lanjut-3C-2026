<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function index()
    {
        // Data buku diambil oleh JavaScript dari GET /api/buku.
        // Controller hanya menyediakan daftar kategori untuk pilihan pada formulir.
        return view('buku.index', [
            'daftarKategori' => Kategori::orderBy('nama')->get(['id', 'nama']),
        ]);
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);
        $buku = $buku ? $this->formatBuku($buku) : null;

        return view('buku.detail', compact('buku'));
    }

    // Bentuk datanya disamakan dengan array lama, jadi View tidak perlu diubah
    private function formatBuku(Buku $buku): array
    {
        return [
            'id'           => $buku->id,
            'judul'        => $buku->judul,
            'penulis'      => $buku->penulis,
            'tahun_terbit' => $buku->tahun_terbit,
            'kategori'     => $buku->kategori->nama,
        ];
    }
}
