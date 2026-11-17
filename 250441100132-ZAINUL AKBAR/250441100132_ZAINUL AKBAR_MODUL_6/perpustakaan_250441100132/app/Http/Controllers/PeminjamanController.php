<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // Menampilkan daftar peminjaman (untuk Petugas & Siswa)
    public function index()
    {
        if (Auth::user()->hasRole(['admin', 'petugas'])) {
            $peminjaman = Peminjaman::with(['user', 'buku'])->latest()->get();
        } else {
            $peminjaman = Peminjaman::with(['buku'])->where('user_id', Auth::id())->latest()->get();
        }

        return view('peminjaman.index', compact('peminjaman'));
    }

    // Formulir pinjam buku (untuk Siswa)
    public function create()
    {
        $buku = Buku::all();
        return view('peminjaman.create', compact('buku'));
    }

    // Menyimpan data peminjaman baru
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        Peminjaman::create([
            'user_id' => Auth::id(),
            'anggota_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'Dipinjam',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman buku berhasil diajukan!');
    }

    // --- SOAL 4 (A4 Remediation): Otorisasi Menggunakan PeminjamanPolicy ---
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);

        Gate::authorize('view', $peminjaman);

        return view('peminjaman.show', compact('peminjaman'));
    }

    // Proses pengembalian buku (oleh Petugas)
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // UPDATE: Catat waktu riil saat petugas menekan tombol
        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_dikembalikan' => Carbon::now()->toDateString()
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }
}