<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';
    protected $guarded = ['id'];

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    // TAMBAHKAN RELASI INI AGAR ERROR HILANG
    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id'); 
        // Jika tabel referensinya bernama model Anggota, ubah User::class menjadi Anggota::class
    }

    // Relasi ke Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

}
