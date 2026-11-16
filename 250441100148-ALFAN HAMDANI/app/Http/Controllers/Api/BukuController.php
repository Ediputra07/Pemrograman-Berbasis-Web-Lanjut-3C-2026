<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Http\Resources\V1\BukuResource; // 1. Import BukuResource di sini
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // a. Index: Daftar buku dengan pencarian, filter, pagination, withCount, & urutan terbaru
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->withCount('peminjamans');

        // Filter berdasarkan pencarian judul atau penulis (cari)
        if ($request->has('cari')) {
            $cari = $request->input('cari');
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                    ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        // Filter berdasarkan kategori_id
        if ($request->has('kategori')) {
            $query->where('kategori_id', $request->input('kategori'));
        }

        // Filter berdasarkan tahun terbit
        if ($request->has('tahun')) {
            $query->where('tahun_terbit', $request->input('tahun'));
        }

        // Urutkan data terbaru lebih dulu
        $query->latest();

        // Pagination 10 data per halaman (query string otomatis terbawa)
        $buku = $query->paginate(10)->appends($request->query());

        // 2. Ubah return response()->json() menggunakan BukuResource::collection
        return BukuResource::collection($buku);
    }

    // b. Store: Menyimpan data baru menggunakan validated()
    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        // 3. Bungkus dengan new BukuResource
        return (new BukuResource($buku))
            ->additional([
                'success' => true,
                'message' => 'Buku berhasil ditambahkan'
            ])
            ->response()
            ->setStatusCode(201);
    }

    // c. Show: Detail satu buku beserta relasi kategori dan peminjaman
    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        // 4. Bungkus dengan new BukuResource
        return (new BukuResource($buku))
            ->additional([
                'success' => true
            ])
            ->response()
            ->setStatusCode(200);
    }

    // d. Update: Memperbarui data buku
    public function update(UpdateBukuRequest $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $buku->update($request->validated());

        // 5. Bungkus dengan new BukuResource
        return (new BukuResource($buku))
            ->additional([
                'success' => true,
                'message' => 'Buku berhasil diperbarui'
            ])
            ->response()
            ->setStatusCode(200);
    }

    // e. Destroy: Menghapus data buku (Tidak perlu resource karena data dihapus)
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }
}