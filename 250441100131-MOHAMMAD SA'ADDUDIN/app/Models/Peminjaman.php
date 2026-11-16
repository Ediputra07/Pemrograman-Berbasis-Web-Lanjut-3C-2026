<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = ['anggota_id', 'buku_id', 'tanggal_pinjam', 'tanggal_kembali'];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam'  => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
