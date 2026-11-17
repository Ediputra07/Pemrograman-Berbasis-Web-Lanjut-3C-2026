<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PengembalianController extends Controller
{
    public function index(): View
    {
        $peminjamanList = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'Dipinjam')
            ->orderBy('tanggal_pinjam')
            ->get();

        return view('pengembalian.index', compact('peminjamanList'));
    }

    public function update(Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== 'Dipinjam') {
            return redirect()->route('pengembalian.index')
                ->with('error', 'Hanya buku yang sedang dipinjam yang dapat dicatat pengembaliannya.');
        }

        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return redirect()->route('pengembalian.index')
            ->with('success', 'Pengembalian buku berhasil dicatat.');
    }
}
