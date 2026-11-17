<?php

namespace App\Http\Controllers\Kelola;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/** Admin & Petugas: mencatat pengembalian buku. */
class PengembalianController extends Controller
{
    /** GET /kelola/pengembalian (permission: kelola pengembalian). */
    public function index(): View
    {
        $daftar = Peminjaman::with(['anggota', 'buku'])
            ->where('status', Peminjaman::DIPINJAM)
            ->orderBy('tanggal_pinjam')
            ->paginate(10);

        return view('kelola.pengembalian', compact('daftar'));
    }

    /** POST (permission: mencatat pengembalian buku). */
    public function catat(Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== Peminjaman::DIPINJAM) {
            return back()->with('error', 'Hanya buku yang sedang dipinjam yang dapat dicatat pengembaliannya.');
        }

        $peminjaman->update([
            'status'          => Peminjaman::DIKEMBALIKAN,
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return back()->with('success', 'Pengembalian buku berhasil dicatat.');
    }
}
