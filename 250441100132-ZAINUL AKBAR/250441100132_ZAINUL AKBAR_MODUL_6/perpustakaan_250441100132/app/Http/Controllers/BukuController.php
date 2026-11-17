<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    // 1. Menampilkan daftar semua buku
    public function index()
    {
        $books = Buku::with('kategori')->get();
        return view('daftar-buku.index', compact('books'));
    }

    // 2. Menampilkan form Tambah Buku
    public function create()
    {
        $kategories = Kategori::all();
        return view('daftar-buku.create', compact('kategories'));
    }

    // 3. Menyimpan data buku baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'tahun_terbit' => 'required|numeric',
            'kategori_id'  => 'required|exists:kategoris,id',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku baru berhasil ditambahkan!');
    }

    // 4. Menampilkan detail buku
    public function show($id)
    {
        $book = Buku::with('kategori')->findOrFail($id);
        return view('daftar-buku.detail', compact('book'));
    }

    // 5. Menampilkan form Edit buku
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategories = Kategori::all();
        
        return view('daftar-buku.edit', compact('buku', 'kategories'));
    }

    // 6. Memproses update data buku
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'tahun_terbit' => 'required|numeric',
            'kategori_id'  => 'required|exists:kategoris,id',
        ]);

        try {
            $buku = Buku::findOrFail($id);
            $buku->update($request->all());

            return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
        } catch (QueryException $e) {
            return redirect()->route('buku.index')->with('error', 'Gagal memperbarui data buku!');
        }
    }

    // 7. Menghapus data buku
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        try {
            // Hapus riwayat peminjaman terlebih dahulu jika ada
            if (method_exists($buku, 'peminjamans')) {
                $buku->peminjamans()->delete();
            }
            $buku->delete();

            return redirect()->route('buku.index')->with('success', 'Buku dan riwayatnya berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Gagal menghapus buku.');
        }
    }

    // 8. Method Cari Buku (Sudah Ditambal dari Celah A2 SQL Injection)
    public function cari(Request $request)
    {
        $judul = $request->query('judul');
        
        // Penambalan A2: Menggunakan Parameter Binding (?) untuk mencegah SQL Injection
        $buku = DB::select("SELECT * FROM bukus WHERE judul = ?", [$judul]);
        
        return response()->json($buku);
    }

    // 9. Method Simulasi IDOR (A4)
    public function editIdor($id)
    {
        $buku = Buku::findOrFail($id);
        $kategories = Kategori::all();
        return view('daftar-buku.edit', compact('buku', 'kategories'));
    }
}