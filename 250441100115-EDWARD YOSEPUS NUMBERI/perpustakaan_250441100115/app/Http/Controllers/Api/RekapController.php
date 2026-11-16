<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    /**
     * Rekapitulasi jumlah buku per kategori
     */
    public function rekapBukuPerKategori()
    {
        $rekap = Kategori::withCount('bukus')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Rekapitulasi jumlah buku per kategori berhasil diambil',
            'data' => $rekap
        ], 200);
    }

    /**
     * Rekapitulasi total peminjaman per buku
     */
    public function rekapPeminjamanPerBuku()
    {
        $rekap = Buku::with('kategori')->withCount('peminjamans')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Rekapitulasi peminjaman per buku berhasil diambil',
            'data' => $rekap
        ], 200);
    }
}