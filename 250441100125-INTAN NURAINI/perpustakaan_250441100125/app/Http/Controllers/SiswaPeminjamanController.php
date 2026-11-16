<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaPeminjamanController extends Controller
{
    // Menampilkan form pengajuan peminjaman
    public function create(int $buku_id)
    {
        $buku = Buku::findOrFail($buku_id);

        $anggota = Anggota::where('user_id', Auth::id())->firstOrFail();

        return view('peminjaman.siswa.create', compact('buku', 'anggota'));
    }

    // Menyimpan pengajuan peminjaman
    public function store(Request $request, int $buku_id)
    {
        $buku = Buku::findOrFail($buku_id);

        $anggota = Anggota::where('user_id', Auth::id())->firstOrFail();

        $sudahMengajukan = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->whereNull('tanggal_kembali')
            ->exists();

        if ($sudahMengajukan) {
            return back()->with('error', 'Kamu masih memiliki pengajuan atau peminjaman aktif untuk buku ini.');
        }

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => null,
            'status' => 'Menunggu',
        ]);

        return redirect()
            ->route('siswa.peminjaman.status')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    // Melihat status peminjaman milik Siswa sendiri
    public function status()
    {
        $anggota = Anggota::where('user_id', Auth::id())->firstOrFail();

        $peminjamans = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->where('status', 'Menunggu')
            ->latest()
            ->get();

        return view('peminjaman.siswa.status', compact('peminjamans'));
    }

    // Melihat seluruh riwayat peminjaman milik Siswa sendiri
    public function riwayat()
    {
        $anggota = Anggota::where('user_id', Auth::id())->firstOrFail();

        $peminjamans = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->get();

        return view('peminjaman.siswa.riwayat', compact('peminjamans'));
    }
}
