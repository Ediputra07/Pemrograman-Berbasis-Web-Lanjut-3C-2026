<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PengembalianController extends Controller
{
    public function index(): View
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        return view('pengembalian.index', compact('peminjamans'));
    }

    public function kembalikan(Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->tanggal_kembali !== null) {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $peminjaman->update([
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return redirect()
            ->route('admin.pengembalian')
            ->with('success', 'Pengembalian buku berhasil dicatat.');
    }
}
