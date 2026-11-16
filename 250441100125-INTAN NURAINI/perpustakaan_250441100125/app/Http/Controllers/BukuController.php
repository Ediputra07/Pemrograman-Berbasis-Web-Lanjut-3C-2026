<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    // Halaman Kelola Buku untuk Admin dan Petugas
    public function index()
    {
        $buku = Buku::query()
            ->join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->select(
                'bukus.id',
                'bukus.judul',
                'bukus.penulis',
                'bukus.tahun_terbit',
                'kategoris.nama as kategori'
            )
            ->get()
            ->map(function ($data) {
                return [
                    'id' => $data->id,
                    'judul' => $data->judul,
                    'penulis' => $data->penulis,
                    'tahun' => $data->tahun_terbit,
                    'kategori' => $data->kategori,
                ];
            });

        $kategori = Kategori::query()
            ->selectRaw('MIN(id) as id, nama')
            ->groupBy('nama')
            ->orderBy('nama')
            ->get();

        return view('buku.index', [
            'buku' => $buku,
            'kategori' => $kategori,
        ]);
    }

    // Katalog buku khusus tampilan baca untuk Siswa
    public function katalog()
    {
        $buku = Buku::query()
            ->join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->select(
                'bukus.id',
                'bukus.judul',
                'bukus.penulis',
                'bukus.tahun_terbit',
                'kategoris.nama as kategori'
            )
            ->orderBy('bukus.judul')
            ->get();

        return view('buku.katalog', compact('buku'));
    }

    // Detail buku untuk pengguna yang sudah login
    public function detail(int $id)
    {
        $data = Buku::query()
            ->join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.id', $id)
            ->select(
                'bukus.id',
                'bukus.judul',
                'bukus.penulis',
                'bukus.tahun_terbit',
                'kategoris.nama as kategori'
            )
            ->first();

        $buku = null;

        if ($data) {
            $buku = [
                'id' => $data->id,
                'judul' => $data->judul,
                'penulis' => $data->penulis,
                'tahun' => $data->tahun_terbit,
                'kategori' => $data->kategori,
            ];
        }

        return view('buku.detail', [
            'buku' => $buku,
        ]);
    }

    // A2: Perbaikan SQL Injection menggunakan Query Binding
    public function cari()
    {
        $judul = request('judul');

        $hasil = DB::select(
            "SELECT * FROM bukus WHERE judul = ?",
            [$judul]
        );

        return response()->json($hasil);
    }


}
