<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimpanBukuRequest;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BukuController extends Controller
{
    /** Daftar buku dirender oleh Blade (10 buku per halaman). */
    public function index(): View
    {
        $daftarBuku = Buku::with('kategori')
            ->latest()
            ->latest('id')
            ->paginate(10);

        return view('buku.index', compact('daftarBuku'));
    }

    public function show(Request $request, $id)
    {
        $buku = Buku::with('kategori')->find($id);
        $buku = $buku ? $this->formatBuku($buku) : null;

        // Apakah pengguna ini masih punya pengajuan/peminjaman berjalan untuk buku tersebut?
        $sudahAktif = $buku
            ? $request->user()->peminjamanSaya()->where('buku_id', $buku['id'])->aktif()->exists()
            : false;

        return view('buku.detail', compact('buku', 'sudahAktif'));
    }

    public function create(): View
    {
        return view('buku.form', [
            'buku'           => new Buku(),
            'daftarKategori' => Kategori::orderBy('nama')->get(['id', 'nama']),
        ]);
    }

    public function store(SimpanBukuRequest $request): RedirectResponse
    {
        Buku::create($request->validated());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku): View
    {
        return view('buku.form', [
            'buku'           => $buku,
            'daftarKategori' => Kategori::orderBy('nama')->get(['id', 'nama']),
        ]);
    }

    public function update(SimpanBukuRequest $request, Buku $buku): RedirectResponse
    {
        $buku->update($request->validated());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    // CELAH A2 (sengaja rentan): SQL Injection
    public function cari(Request $request): JsonResponse
    {
        $judul = $request->input('judul');

        $buku = DB::select(
            'SELECT * FROM bukus WHERE judul = ?',
            [$judul]
        );

        return response()->json($buku);
    }
    // Bentuk datanya disamakan dengan array lama, jadi View tidak perlu diubah
    private function formatBuku(Buku $buku): array
    {
        return [
            'id'           => $buku->id,
            'judul'        => $buku->judul,
            'penulis'      => $buku->penulis,
            'tahun_terbit' => $buku->tahun_terbit,
            'kategori'     => $buku->kategori->nama,
        ];
    }

    // Bentuk datanya disamakan dengan array lama, jadi View tidak perlu diubah
    private function formatBuku(Buku $buku): array
    {
        return [
            'id'           => $buku->id,
            'judul'        => $buku->judul,
            'penulis'      => $buku->penulis,
            'tahun_terbit' => $buku->tahun_terbit,
            'kategori'     => $buku->kategori->nama,
        ];
    }
}
