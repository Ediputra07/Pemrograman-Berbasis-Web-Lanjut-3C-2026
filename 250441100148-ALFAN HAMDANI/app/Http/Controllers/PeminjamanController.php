<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    // 1. Menampilkan daftar seluruh peminjaman (Untuk Admin & Petugas)
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku', 'anggota'])->latest()->get();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    // 2. Fitur Siswa: Mengajukan Peminjaman Buku
    public function ajukan(Request $request, $bukuId)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        Peminjaman::create([
            'anggota_id' => Auth::id(), // ID siswa yang sedang login
            'buku_id' => $bukuId,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'Diajukan', // Status awal pengajuan
        ]);

        return redirect()->route('siswa.riwayat')->with('success', 'Pengajuan peminjaman buku berhasil dikirim.');
    }

    // 3. Fitur Admin/Petugas: Memproses Persetujuan Peminjaman (Setujui)
    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'Dipinjam']);

        return redirect()->back()->with('success', 'Peminjaman buku telah disetujui.');
    }

    // Fitur Admin/Petugas: Menolak Peminjaman
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'Ditolak']);

        return redirect()->back()->with('success', 'Pengajuan peminjaman buku ditolak.');
    }

    // 4. Fitur Admin/Petugas: Mencatat Pengembalian Buku
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => now()->toDateString(), // Catat tanggal aktual dikembalikan
        ]);

        return redirect()->back()->with('success', 'Pengembalian buku berhasil dicatat.');
    }

    // 5. Fitur Siswa: Melihat Status & Riwayat Peminjaman Sendiri
    public function riwayatSiswa()
    {
        $peminjaman = Peminjaman::with('buku')
            ->where('anggota_id', Auth::id())
            ->latest()
            ->get();

        return view('siswa.riwayat', compact('peminjaman'));
    }

    public function formAjukan($bukuId)
    {
        $buku = Buku::findOrFail($bukuId);
        return view('siswa.ajukan-form', compact('buku'));
    }

    public function laporan()
    {
        // Pastikan variabel yang dikirim bernama 'laporan'
        $laporan = \App\Models\Peminjaman::with(['user', 'buku'])->get();

        return view('admin.laporan.index', compact('laporan'));
    }

    // A4
    // public function show($id)
    // {
    //     // Mengambil data secara langsung tanpa pemeriksaan pemilik (Sesuai instruksi A4)
    //     $peminjaman = Peminjaman::findOrFail($id);

    //     // Nonaktifkan sementara Gate agar tidak memunculkan 403 Forbidden
    //     // Gate::authorize('view', $peminjaman);

    //     return view('siswa.peminjaman.show', compact('peminjaman'));
    // }

    // soal 4
    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        Gate::authorize('view', $peminjaman);

        // Ubah menjadi 'siswa.peminjaman.show' sesuai susunan folder Anda
        return view('siswa.peminjaman.show', compact('peminjaman'));
    }

}