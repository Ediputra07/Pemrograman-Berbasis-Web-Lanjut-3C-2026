<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    // Rekap jumlah buku per kategori
    public function bukuPerKategori()
    {
        $rekap = DB::table('bukus')
            ->select(
                'kategori_id',
                DB::raw('COUNT(*) as jumlah_buku')
            )
            ->groupBy('kategori_id')
            ->get();

        return response()->json([
            'message' => 'Rekap jumlah buku per kategori berhasil diambil.',
            'data' => $rekap,
        ], 200);
    }

    // Rekap total peminjaman per buku
    public function peminjamanPerBuku()
    {
        $rekap = DB::table('bukus')
            ->leftJoin(
                'peminjamans',
                'bukus.id',
                '=',
                'peminjamans.buku_id'
            )
            ->select(
                'bukus.id as buku_id',
                'bukus.judul',
                DB::raw('COUNT(peminjamans.id) as total_peminjaman')
            )
            ->groupBy('bukus.id', 'bukus.judul')
            ->get();

        return response()->json([
            'message' => 'Rekap peminjaman per buku berhasil diambil.',
            'data' => $rekap,
        ], 200);
    }
}
