<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'jumlahAdmin'    => User::role('admin')->count(),
            'jumlahPetugas'  => User::role('petugas')->count(),
            'jumlahSiswa'    => User::role('siswa')->count(),
            'jumlahBuku'     => Buku::count(),
            'jumlahPinjam'   => Peminjaman::where('status', Peminjaman::DIPINJAM)->count(),
            'menungguSetuju' => Peminjaman::where('status', Peminjaman::DIAJUKAN)->count(),
        ]);
    }
}
