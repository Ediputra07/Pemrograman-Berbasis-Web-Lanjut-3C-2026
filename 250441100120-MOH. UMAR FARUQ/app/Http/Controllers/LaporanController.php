<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Contracts\View\View;

class LaporanController extends Controller
{
    public function index(): View
    {
        $peminjamanList = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        $stats = [
            'total' => $peminjamanList->count(),
            'menunggu' => $peminjamanList->whereIn('status', ['Pending', 'Diajukan'])->count(),
            'dipinjam' => $peminjamanList->where('status', 'Dipinjam')->count(),
            'dikembalikan' => $peminjamanList->where('status', 'Dikembalikan')->count(),
            'ditolak' => $peminjamanList->where('status', 'Ditolak')->count(),
        ];

        return view('laporan.index', compact('peminjamanList', 'stats'));
    }
}
