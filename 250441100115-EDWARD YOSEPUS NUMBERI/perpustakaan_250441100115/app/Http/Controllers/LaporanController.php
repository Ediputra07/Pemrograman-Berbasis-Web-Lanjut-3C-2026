<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;


class LaporanController extends Controller
{
    public function index()
    {
        // Mengambil seluruh data peminjaman untuk ditampilkan sebagai laporan
        $laporans = Peminjaman::with(['anggota', 'buku'])->get();
        return view('laporan.index', compact('laporans'));
    }
}
