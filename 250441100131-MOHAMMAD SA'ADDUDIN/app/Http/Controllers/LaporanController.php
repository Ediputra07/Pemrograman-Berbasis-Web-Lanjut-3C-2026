<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /** GET /laporan (permission: lihat laporan perpustakaan). */
    public function index(): View
    {
        return view('laporan.index', [
            'bukuPerKategori'   => Kategori::withCount('buku')->orderBy('nama')->get(),
            'peminjamanPerBuku' => Buku::with('kategori')
                ->withCount('peminjaman')
                ->orderByDesc('peminjaman_count')
                ->orderBy('judul')
                ->get(),
            'perStatus'         => Peminjaman::select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status'),
            'daftarPeminjaman'  => Peminjaman::with(['anggota', 'buku'])
                ->orderBy('id')
                ->get(),
        ]);
    }
}
