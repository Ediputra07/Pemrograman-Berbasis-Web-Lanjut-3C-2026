<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar seluruh peminjaman (Khusus Admin & Petugas).
     */
    public function index()
    {
        // Ubah 'user' menjadi 'anggota' agar sesuai dengan fungsi di model Peminjaman.php
        $peminjamans = Peminjaman::with(['anggota', 'buku'])->get();
        
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Menampilkan form tambah peminjaman baru (Khusus Admin & Petugas).
     */
    public function create()
    {
        $bukus = Buku::all();
        $anggotas = User::role('siswa')->get();
        
        return view('admin.peminjaman.create', compact('bukus', 'anggotas'));
    }

    /**
     * Menyimpan data peminjaman baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required',
            'buku_id' => 'required',
            'tanggal_pinjam' => 'required|date',
        ]);

        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => 'Dipinjam',
        ]);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    /**
     * Memproses pengembalian atau update status peminjaman (Alternatif).
     */
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => now(),
            'tanggal_pengembalian' => now(),
        ]);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Buku berhasil dikembalikan.');
    }

    /**
     * Menghapus data peminjaman dari sistem.
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    /**
     * Menampilkan riwayat peminjaman khusus milik Siswa yang sedang login.
     */
    public function riwayat()
    {
        $peminjamans = Peminjaman::with('buku')
            ->where('anggota_id', auth()->id()) 
            ->get();

        return view('siswa.peminjaman.riwayat', compact('peminjamans'));
    }

    /**
     * Memproses pengajuan peminjaman dari sisi Siswa.
     */
    public function storeSiswa(Request $request, $bukuId)
    {
        Peminjaman::create([
            'anggota_id' => auth()->id(),
            'buku_id' => $bukuId,
            'tanggal_pinjam' => now(),
            'status' => 'Dipinjam',
        ]);

        return redirect()->route('siswa.peminjaman.riwayat')->with('success', 'Buku berhasil dipinjam! Silakan cek riwayat.');
    }

    /**
     * Memproses pengembalian buku oleh Admin/Petugas (Tombol "Proses Pengembalian").
     */
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => now(),
            'tanggal_pengembalian' => now(),
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }

    public function laporan()
    {
        // Tambahkan with(['anggota', 'buku']) agar relasinya ikut terbawa
        $peminjamans = Peminjaman::with(['anggota', 'buku'])->get();
        
        return view('admin.laporan.index', compact('peminjamans'));
    }

    
}