<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    // Siswa mengajukan peminjaman buku[cite: 3]
    public function store($id)
    {
        Peminjaman::create([
            'anggota_id' => Auth::id(), // Sesuai struktur migrasi tabel peminjamans kamu
            'buku_id' => $id,
            'tanggal_pinjam' => now(),
            'status' => 'dipinjam',
        ]);

        return redirect()->route('siswa.riwayat')->with('success', 'Pengajuan peminjaman buku berhasil!');
    }

    // Siswa melihat status & riwayat peminjaman miliknya sendiri[cite: 3]
    public function riwayat()
    {
        $peminjamans = Peminjaman::with('buku')
            ->where('anggota_id', Auth::id())
            ->latest()
            ->get();

        return view('siswa.riwayat', compact('peminjamans'));
    }

    // Siswa mengembalikan buku miliknya[cite: 3]
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('anggota_id', Auth::id())
            ->firstOrFail();

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now(),
        ]);

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    // Admin & Petugas melihat dan memproses seluruh peminjaman[cite: 3]
    public function indexAdmin()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])->latest()->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    // Admin & Petugas memproses persetujuan/pengembalian buku[cite: 3]
    public function prosesAdmin($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now(),
        ]);

        return back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }

//     public function show(Peminjaman $peminjaman)
// {
//     // $peminjaman = Peminjaman::findOrFail($id); // Tanpa pemeriksaan kepemilikan user
//     Gate::authorize('view', $peminjaman);
//     return view('peminjaman.show', compact('peminjaman'));
// }

public function show($id)
{
    $peminjaman = Peminjaman::findOrFail($id); // Tanpa pemeriksaan kepemilikan user
    return view('peminjaman.show', compact('peminjaman'));
}

}