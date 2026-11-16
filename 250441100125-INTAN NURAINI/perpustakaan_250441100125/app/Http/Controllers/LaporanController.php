<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        // Mengambil periode tanggal dari filter
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        // Query data peminjaman
        $query = Peminjaman::with(['anggota', 'buku']);

        // Filter berdasarkan tanggal peminjaman
        if ($tanggalMulai) {
            $query->whereDate('tanggal_pinjam', '>=', $tanggalMulai);
        }

        if ($tanggalSelesai) {
            $query->whereDate('tanggal_pinjam', '<=', $tanggalSelesai);
        }

        // Mengambil data laporan
        $peminjamans = $query->latest('tanggal_pinjam')->get();

        // Menghitung jumlah data
        $totalPeminjaman = $peminjamans->count();

        $totalPengembalian = $peminjamans
            ->whereNotNull('tanggal_kembali')
            ->count();

        $belumDikembalikan = $peminjamans
            ->whereNull('tanggal_kembali')
            ->count();

        return view('laporan.index', compact(
            'peminjamans',
            'totalPeminjaman',
            'totalPengembalian',
            'belumDikembalikan',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }
}