<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('petugas.dashboard', [
            'menungguSetuju' => Peminjaman::where('status', Peminjaman::DIAJUKAN)->count(),
            'sedangDipinjam' => Peminjaman::where('status', Peminjaman::DIPINJAM)->count(),
            'jumlahBuku'     => Buku::count(),
            'pengajuanBaru'  => Peminjaman::with(['anggota', 'buku'])
                ->where('status', Peminjaman::DIAJUKAN)
                ->latest('id')
                ->limit(5)
                ->get(),
        ]);
    }
}
