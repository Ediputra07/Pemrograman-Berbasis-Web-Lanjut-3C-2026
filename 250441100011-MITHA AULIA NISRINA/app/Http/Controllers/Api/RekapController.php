<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;

class RekapController extends Controller
{
    public function bukuPerKategori()
    {
        $data = Buku::join(
            'kategoris',
            'bukus.kategori_id',
            '=',
            'kategoris.id'
        )
            ->select(
                'kategoris.id as kategori_id',
                'kategoris.nama as nama_kategori'
            )
            ->selectRaw('COUNT(bukus.id) as jumlah_buku')
            ->groupBy('kategoris.id', 'kategoris.nama')
            ->orderBy('kategoris.nama')
            ->get();

        return response()->json([
            'message' => 'Rekap buku per kategori berhasil diambil.',
            'data' => $data,
        ], 200);
    }

    public function peminjamanPerBuku()
    {
        $data = Buku::select('id', 'judul', 'penulis')
            ->withCount('peminjamans')
            ->orderBy('judul')
            ->get();

        return response()->json([
            'message' => 'Rekap peminjaman per buku berhasil diambil.',
            'data' => $data,
        ], 200);
    }
}