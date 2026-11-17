<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // Mengambil nama kategori dari relasi tabel kategoris kolom 'nama'
            'kategori' => $this->kategori->nama ?? '-', 
            
            // Sesuaikan 'judul_buku' atau 'judul' dengan nama kolom di tabel buku Anda
            'judul' => $this->judul_buku ?? $this->judul ?? '-', 
            
            'penulis' => $this->penulis,
            'tahun_terbit' => $this->tahun_terbit,
        ];
    }
}