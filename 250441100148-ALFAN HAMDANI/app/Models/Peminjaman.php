<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'anggota_id', // Menggunakan anggota_id sesuai tabel
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    // Relasi ke User (menggunakan foreign key 'anggota_id')
    public function user()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    // Atau buat fungsi alternatif bernama anggota()
    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}