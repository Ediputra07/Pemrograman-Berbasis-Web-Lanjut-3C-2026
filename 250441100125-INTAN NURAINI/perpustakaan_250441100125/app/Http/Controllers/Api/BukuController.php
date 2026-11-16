<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Http\Resources\Api\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku.
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
            ->withCount('peminjamans');

        if ($request->filled('cari')) {
            $cari = $request->input('cari');

            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                    ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where(
                'kategori_id',
                $request->input('kategori')
            );
        }

        if ($request->filled('tahun')) {
            $query->where(
                'tahun_terbit',
                $request->input('tahun')
            );
        }

        $bukus = $query->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return BukuResource::collection($bukus);
    }

    /**
     * Menambahkan buku baru.
     */
    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        $buku->load('kategori');
        $buku->loadCount('peminjamans');

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => new BukuResource($buku),
        ], 201);
    }

    /**
     * Menampilkan detail buku.
     */
    public function show($id)
    {
        $buku = Buku::with([
            'kategori',
            'peminjamans',
        ])->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'data' => new BukuResource($buku),
        ], 200);
    }

    /**
     * Memperbarui data buku.
     */
    public function update(UpdateBukuRequest $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        $buku->update($request->validated());

        $buku->load('kategori');
        $buku->loadCount('peminjamans');

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data' => new BukuResource($buku),
        ], 200);
    }

    /**
     * Menghapus buku.
     */
    public function destroy($id)
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
