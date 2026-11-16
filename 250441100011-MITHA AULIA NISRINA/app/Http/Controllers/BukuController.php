<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{

    public function index(Request $request)
    {
        $buku = Buku::with('kategori')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->judul,
                'author' => $item->penulis,
                'year' => $item->tahun_terbit,
                'category' => $item->kategori->nama,
                'image' => $item->image,
                'description' => $item->description,
            ];
        });

        $kategori = $request->query('category');

        if ($kategori) {
            $buku = $buku->filter(function ($item) use ($kategori) {
                return $item['category'] == $kategori;
            });
        }

        return view('buku.index', compact('buku', 'kategori'));
    }

    public function show($id)
    {
        $item = Buku::with('kategori')->find($id);

        $bukuDitemukan = null;

        if ($item) {
            $bukuDitemukan = [
                'id' => $item->id,
                'title' => $item->judul,
                'author' => $item->penulis,
                'year' => $item->tahun_terbit,
                'category' => $item->kategori->nama,
                'image' => $item->image,
                'description' => $item->description,
            ];
        }

        return view('buku.detail', compact('bukuDitemukan'));
    }
}
