<?php

namespace App\Http\Controllers\Kelola;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Admin & Petugas: memproses persetujuan peminjaman. */
class PeminjamanController extends Controller
{
    /** GET /kelola/peminjaman (permission: kelola peminjaman). */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $daftar = Peminjaman::with(['anggota', 'buku'])
            ->when(
                in_array($status, Peminjaman::DAFTAR_STATUS, true),
                fn ($q) => $q->where('status', $status)
            )
            ->orderByRaw("CASE WHEN status = 'diajukan' THEN 0 ELSE 1 END")
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('kelola.peminjaman', compact('daftar', 'status'));
    }

    /** POST (permission: memproses persetujuan peminjaman) */
    public function setujui(Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== Peminjaman::DIAJUKAN) {
            return back()->with('error', 'Hanya pengajuan yang berstatus "diajukan" yang dapat diproses.');
        }

        $peminjaman->update([
            'status'         => Peminjaman::DIPINJAM,
            'tanggal_pinjam' => now()->toDateString(),
        ]);

        return back()->with('success', 'Pengajuan peminjaman disetujui.');
    }

    /** POST (permission: memproses persetujuan peminjaman) */
    public function tolak(Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== Peminjaman::DIAJUKAN) {
            return back()->with('error', 'Hanya pengajuan yang berstatus "diajukan" yang dapat diproses.');
        }

        $peminjaman->update(['status' => Peminjaman::DITOLAK]);

        return back()->with('success', 'Pengajuan peminjaman ditolak.');
    }
}
