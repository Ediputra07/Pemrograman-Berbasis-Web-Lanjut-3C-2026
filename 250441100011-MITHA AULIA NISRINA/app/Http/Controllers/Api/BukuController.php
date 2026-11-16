<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Menampilkan daftar buku
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
            ->withCount('peminjamans');

        // Pencarian judul atau penulis
        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', '%' . $cari . '%')
                  ->orWhere('penulis', 'like', '%' . $cari . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter berdasarkan tahun terbit
        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        // Pagination 10 buku per halaman
        $bukus = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'data' => $bukus->items(),
            'meta' => [
                'current_page' => $bukus->currentPage(),
                'last_page' => $bukus->lastPage(),
                'per_page' => $bukus->perPage(),
                'total' => $bukus->total(),
            ],
        ], 200);
    }

    // Menambahkan buku baru
    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => $buku->load('kategori'),
        ], 201);
    }

    // Menampilkan detail buku
    public function show(string $id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])
            ->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'data' => $buku,
        ], 200);
    }

    // Memperbarui buku
    public function update(UpdateBukuRequest $request, string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        $buku->update($request->validated());

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data' => $buku->load('kategori'),
        ], 200);
    }

    // Menghapus buku
    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus.',
        ], 200);
    }
}
