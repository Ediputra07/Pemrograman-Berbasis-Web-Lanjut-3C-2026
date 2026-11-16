<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        return view('peminjaman.index', compact('peminjamans'));
    }

    // A4: Perbaikan IDOR menggunakan PeminjamanPolicy
    public function show(int $id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->findOrFail($id);
        
        // Memeriksa apakah pengguna berhak melihat peminjaman ini.
        Gate::authorize('view', $peminjaman);

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $peminjaman->update([
            'status' => $request->status,
        ]);

        $pesan = $request->status === 'Disetujui'
            ? 'Pengajuan peminjaman berhasil disetujui.'
            : 'Pengajuan peminjaman berhasil ditolak.';

        return back()->with('success', $pesan);
    }
}
