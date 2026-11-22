<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku']);

        // Filter jika hanya mengisi Tanggal Mulai
        if ($request->filled('tanggal_mulai') && !$request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->tanggal_mulai);
        }

        // Filter jika hanya mengisi Tanggal Selesai
        if (!$request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->tanggal_selesai);
        }

        // Filter jika mengisi KEDUA tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_pinjam', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        // Ambil data hasil filter
        $laporan = $query->latest()->get();

        // Hitung statistik dinamis sesuai hasil filter
        $totalPeminjaman   = $laporan->count();
        $totalDipinjam     = $laporan->where('status', 'Dipinjam')->count();
        $totalDikembalikan = $laporan->where('status', 'Dikembalikan')->count();

        return view('laporan.index', compact('laporan', 'totalPeminjaman', 'totalDipinjam', 'totalDikembalikan'));
    }
}