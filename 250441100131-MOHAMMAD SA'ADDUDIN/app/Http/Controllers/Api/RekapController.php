<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\JsonResponse;

class RekapController extends Controller
{
    
    public function bukuPerKategori(): JsonResponse
    {
        $data = Kategori::withCount('buku')
            ->orderBy('nama')
            ->get()
            ->map(fn (Kategori $kategori) => [
                'kategori_id' => $kategori->id,
                'kategori'    => $kategori->nama,
                'jumlah_buku' => $kategori->buku_count,
            ]);

        return response()->json([
            'data'       => $data,
            'total_buku' => $data->sum('jumlah_buku'),
        ]);
    }

  
    public function peminjamanPerBuku(): JsonResponse
    {
        $data = Buku::with('kategori')
            ->withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->orderBy('judul')
            ->get()
            ->map(fn (Buku $buku) => [
                'buku_id'          => $buku->id,
                'judul'            => $buku->judul,
                'kategori'         => $buku->kategori->nama,
                'total_peminjaman' => $buku->peminjaman_count,
            ]);

        return response()->json([
            'data'             => $data,
            'total_peminjaman' => $data->sum('total_peminjaman'),
        ]);
    }
}
