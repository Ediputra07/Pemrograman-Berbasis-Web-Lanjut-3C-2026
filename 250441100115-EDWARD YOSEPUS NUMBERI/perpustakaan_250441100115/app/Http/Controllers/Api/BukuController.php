<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku beserta pencarian, filter, pagination, dan withCount.
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->withCount('peminjamans');

        // Fitur Pencarian berdasarkan judul atau penulis
        if ($request->has('cari') && !empty($request->cari)) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('judul', 'like', '%' . $cari . '%')
                  ->orWhere('penulis', 'like', '%' . $cari . '%');
            });
        }

        // Fitur Filter berdasarkan kategori_id
        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->where('kategori_id', $request->kategori);
        }

        // Fitur Filter berdasarkan tahun_terbit
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->where('tahun_terbit', $request->tahun);
        }

        // Urutkan dari data terbaru dan terapkan pagination (10 data per halaman)
        $buku = $query->latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar buku berhasil diambil',
            'data' => $buku
        ], 200);
    }

    /**
     * Menyimpan data buku baru (Khusus Admin dan Petugas).
     */
    public function store(Request $request)
    {
        // Khusus Admin dan Petugas
        if (!auth()->user() || !auth()->user()->hasAnyRole(['admin', 'petugas'])) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak. Fitur simpan buku hanya untuk Admin dan Petugas.'
            ], 403);
        }

        // Validasi fleksibel mendukung kedua variasi nama field dari frontend
        $validated = $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'nullable|string|max:255',
            'judul_buku'   => 'nullable|string|max:255',
            'penulis'      => 'required|string|max:255',
            'tahun'        => 'nullable|integer|max:2026',
            'tahun_terbit' => 'nullable|integer|max:2026',
        ], [
            'kategori_id.required' => 'Kategori buku wajib dipilih.',
            'kategori_id.exists'   => 'Kategori buku yang dipilih tidak valid di database.',
            'penulis.required'     => 'Nama penulis wajib diisi.',
            'tahun_terbit.max'     => 'Tahun terbit tidak boleh lebih dari tahun 2026.',
            'tahun.max'            => 'Tahun terbit tidak boleh lebih dari tahun 2026.',
        ]);

        $judulFix = $request->judul_buku ?? $request->judul;
        $tahunFix = $request->tahun_terbit ?? $request->tahun;

        if (!$judulFix || trim($judulFix) === '') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Judul buku wajib diisi.',
                'errors'  => [
                    'judul' => ['Judul buku wajib diisi.']
                ]
            ], 422);
        }

        $buku = Buku::create([
            'kategori_id'  => $request->kategori_id,
            'judul'        => $judulFix, 
            'penulis'      => $request->penulis,
            'tahun_terbit' => $tahunFix ?? date('Y'),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Buku berhasil ditambahkan',
            'data'    => $buku->load('kategori')
        ], 201);
    }

    /**
     * Menampilkan detail buku beserta relasi kategori dan peminjaman.
     */
    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (!$buku) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data buku tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail buku berhasil ditemukan',
            'data' => $buku
        ], 200);
    }

    /**
     * Memperbarui data buku (Khusus Admin dan Petugas).
     */
    public function update(Request $request, $id)
    {
        // Khusus Admin dan Petugas
        if (!auth()->user() || !auth()->user()->hasAnyRole(['admin', 'petugas'])) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak. Fitur ubah buku hanya untuk Admin dan Petugas.'
            ], 403);
        }

        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data buku tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'nullable|string|max:255',
            'judul_buku'   => 'nullable|string|max:255',
            'penulis'      => 'required|string|max:255',
            'tahun'        => 'nullable|integer|max:2026',
            'tahun_terbit' => 'nullable|integer|max:2026',
        ], [
            'kategori_id.required' => 'Kategori buku wajib dipilih.',
            'kategori_id.exists'   => 'Kategori buku yang dipilih tidak valid di database.',
            'penulis.required'     => 'Nama penulis wajib diisi.',
            'tahun_terbit.max'     => 'Tahun terbit tidak boleh lebih dari tahun 2026.',
            'tahun.max'            => 'Tahun terbit tidak boleh lebih dari tahun 2026.',
        ]);

        $judulFix = $request->judul_buku ?? $request->judul ?? $buku->judul;
        $tahunFix = $request->tahun_terbit ?? $request->tahun ?? $buku->tahun_terbit;

        $buku->update([
            'kategori_id'  => $request->kategori_id ?? $buku->kategori_id,
            'judul'        => $judulFix,
            'penulis'      => $request->penulis ?? $buku->penulis,
            'tahun_terbit' => $tahunFix,
        ]);

        $buku->load('kategori');

        return response()->json([
            'status' => 'success',
            'message' => 'Buku berhasil diperbarui',
            'data' => $buku
        ], 200);
    }

    /**
     * Menghapus data buku (Khusus Admin dan Petugas).
     */
    public function destroy($id)
    {
        // Khusus Admin dan Petugas
        if (!auth()->user() || !auth()->user()->hasAnyRole(['admin', 'petugas'])) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak. Fitur hapus buku hanya untuk Admin dan Petugas.'
            ], 403);
        }

        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data buku tidak ditemukan'
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }

    /**
     * Rekapitulasi jumlah buku per kategori.
     */
    public function rekapBukuPerKategori()
    {
        $rekap = Kategori::withCount('bukus')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Rekapitulasi jumlah buku per kategori berhasil diambil',
            'data' => $rekap
        ], 200);
    }

    /**
     * Rekapitulasi total peminjaman per buku.
     */
    public function rekapPeminjamanPerBuku()
    {
        $rekap = Buku::withCount('peminjamans')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Rekapitulasi total peminjaman per buku berhasil diambil',
            'data' => $rekap
        ], 200);
    }
}