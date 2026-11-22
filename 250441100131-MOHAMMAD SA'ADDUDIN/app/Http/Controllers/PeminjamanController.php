<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    /** POST /peminjaman (permission: mengajukan peminjaman buku). */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'buku_id' => ['required', 'exists:bukus,id'],
        ], [
            'buku_id.required' => 'Buku yang akan dipinjam belum dipilih.',
            'buku_id.exists'   => 'Buku yang dipilih tidak ditemukan.',
        ]);

        // Anggota diambil dari akun yang login, BUKAN dari input form
        $anggota = $request->user()->pastikanAnggota();

        $sudahAktif = $anggota->peminjaman()
            ->where('buku_id', $data['buku_id'])
            ->aktif()
            ->exists();

        if ($sudahAktif) {
            return back()->with('error', 'Anda masih memiliki pengajuan atau peminjaman yang berjalan untuk buku ini.');
        }

        Peminjaman::create([
            'anggota_id'      => $anggota->id,
            'buku_id'         => $data['buku_id'],
            'tanggal_pinjam'  => now()->toDateString(),
            'tanggal_kembali' => null,
            'status'          => Peminjaman::DIAJUKAN,
        ]);

        return redirect()->route('peminjaman.status')
            ->with('success', 'Pengajuan peminjaman terkirim. Tunggu persetujuan petugas.');
    }

    /**
     * Siswa hanya dapat melihat peminjamannya sendiri; admin dan petugas dapat melihat semua.
     */
    /**
     * A4 (Soal 1): sengaja rentan terhadap IDOR.
     */
    public function show($id): View
    {
        $peminjaman = Peminjaman::findOrFail($id);

        Gate::authorize('view', $peminjaman);

        return view('peminjaman.detail', compact('peminjaman'));
    }
    /** GET /peminjaman-saya (permission: melihat status peminjaman sendiri). */
    public function status(Request $request): View
    {
        $daftar = $request->user()
            ->peminjamanSaya()
            ->aktif()
            ->with('buku.kategori')
            ->latest('id')
            ->get();

        return view('peminjaman.status', compact('daftar'));
    }

    /** GET /riwayat-peminjaman: arahkan ke riwayat milik anggota sendiri. */
    public function riwayatSaya(Request $request): RedirectResponse
    {
        $anggota = $request->user()->pastikanAnggota();

        return redirect()->route('anggota.riwayat', $anggota);
    }

    /**
     * GET /anggota/{anggota}/riwayat.
     * Selain permission pada rute, kepemilikan diperiksa lewat AnggotaPolicy:
     * Siswa yang mencoba membuka riwayat anggota lain mendapat 403.
     */
    public function riwayatAnggota(Anggota $anggota): View
    {
        Gate::authorize('lihatRiwayat', $anggota);

        $daftar = $anggota->peminjaman()
            ->with('buku.kategori')
            ->latest('id')
            ->get();

        return view('peminjaman.riwayat', compact('anggota', 'daftar'));
    }
}
