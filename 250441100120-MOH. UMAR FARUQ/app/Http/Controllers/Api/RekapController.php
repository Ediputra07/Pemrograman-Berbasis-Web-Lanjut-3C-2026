<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    // Endpoint: GET /api/rekap/buku-per-kategori
    // Menghitung jumlah buku per kategori menggunakan join, count, dan groupBy
    public function bukuPerKategori()
    {
        $rekap = Buku::select('kategoris.nama as kategori', DB::raw('count(bukus.id) as jumlah_buku'))
            ->join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->groupBy('kategoris.id', 'kategoris.nama')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $rekap
        ], 200);
    }

    // Endpoint: GET /api/rekap/peminjaman-per-buku
    // Menampilkan total peminjaman per buku menggunakan withCount
    public function peminjamanPerBuku()
    {
        $rekap = Buku::select('id', 'judul', 'penulis', 'tahun_terbit')
            ->withCount('peminjaman')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $rekap
        ], 200);
    }
}
