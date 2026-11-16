<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    // Halaman Daftar Buku (Menampilkan View atau JSON)
    public function index(Request $request)
    {
        // Jika permintaan berasal dari JavaScript (Fetch API / AJAX), kembalikan data JSON
        if ($request->wantsJson() || $request->ajax()) {
            $buku = Buku::with('kategori')->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'penulis' => $item->penulis,
                    'tahun_terbit' => $item->tahun_terbit,
                    'kategori_id' => $item->kategori_id,
                    'kategori' => $item->kategori->nama ?? 'Umum',
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $buku
            ]);
        }

        // Jika diakses langsung lewat browser, ambil datanya dan kirimkan ke view Blade
        $bukus = Buku::all();
        return view('buku.index', compact('bukus'));
    }

    // Menyimpan Buku Baru (POST)
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
        ]);

        $buku = Buku::create([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tahun_terbit' => $request->tahun_terbit,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan',
            'data' => $buku
        ]);
    }

    // Memperbarui Data Buku (PUT/PATCH)
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tahun_terbit' => $request->tahun_terbit,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diperbarui',
            'data' => $buku
        ]);
    }

    // Menghapus Buku (DELETE)
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus'
        ]);
    }

    public function katalogSiswa()
    {
        $buku = Buku::all();
        return view('siswa.buku', compact('buku'));
    }

    // b
    public function cari(Request $request)
    {
        $judul = $request->query('judul');
        $buku = DB::select("SELECT * FROM bukus WHERE judul = ?", [$judul]);
        return response()->json($buku);
    }
}