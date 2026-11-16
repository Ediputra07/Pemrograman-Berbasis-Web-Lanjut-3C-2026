<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
<<<<<<< HEAD
=======
use App\Http\Resources\Api\BukuResource;
>>>>>>> 75a12f2 (250441100125_INTAN NURAINI_MODUL 4_EDI PUTRA)
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
<<<<<<< HEAD

=======
    /**
     * Menampilkan daftar buku.
     */
>>>>>>> 75a12f2 (250441100125_INTAN NURAINI_MODUL 4_EDI PUTRA)
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
            ->withCount('peminjamans');

<<<<<<< HEAD
        // A. Pencarian berdasarkan judul atau penulis
=======
>>>>>>> 75a12f2 (250441100125_INTAN NURAINI_MODUL 4_EDI PUTRA)
        if ($request->filled('cari')) {
            $cari = $request->input('cari');

            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                    ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

<<<<<<< HEAD
        // B. Filter berdasarkan kategori
=======
>>>>>>> 75a12f2 (250441100125_INTAN NURAINI_MODUL 4_EDI PUTRA)
        if ($request->filled('kategori')) {
            $query->where(
                'kategori_id',
                $request->input('kategori')
            );
        }

<<<<<<< HEAD
        // C. Filter berdasarkan tahun terbit
=======
>>>>>>> 75a12f2 (250441100125_INTAN NURAINI_MODUL 4_EDI PUTRA)
        if ($request->filled('tahun')) {
            $query->where(
                'tahun_terbit',
                $request->input('tahun')
            );
        }

<<<<<<< HEAD
        // D. Urutkan data terbaru dan tampilkan 10 data per halaman
        $bukus = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return response()->json($bukus, 200);
    }


=======
        $bukus = $query->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return BukuResource::collection($bukus);
    }

    /**
     * Menambahkan buku baru.
     */
>>>>>>> 75a12f2 (250441100125_INTAN NURAINI_MODUL 4_EDI PUTRA)
    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        $buku->load('kategori');
        $buku->loadCount('peminjamans');

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
<<<<<<< HEAD
            'data' => $buku,
        ], 201);
    }

    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])
            ->find($id);
=======
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
>>>>>>> 75a12f2 (250441100125_INTAN NURAINI_MODUL 4_EDI PUTRA)

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        return response()->json([
<<<<<<< HEAD
            'data' => $buku,
        ], 200);
    }

=======
            'data' => new BukuResource($buku),
        ], 200);
    }

    /**
     * Memperbarui data buku.
     */
>>>>>>> 75a12f2 (250441100125_INTAN NURAINI_MODUL 4_EDI PUTRA)
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
<<<<<<< HEAD
            'data' => $buku,
        ], 200);
    }

=======
            'data' => new BukuResource($buku),
        ], 200);
    }

    /**
     * Menghapus buku.
     */
>>>>>>> 75a12f2 (250441100125_INTAN NURAINI_MODUL 4_EDI PUTRA)
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
<<<<<<< HEAD
}
=======
}
>>>>>>> 75a12f2 (250441100125_INTAN NURAINI_MODUL 4_EDI PUTRA)
