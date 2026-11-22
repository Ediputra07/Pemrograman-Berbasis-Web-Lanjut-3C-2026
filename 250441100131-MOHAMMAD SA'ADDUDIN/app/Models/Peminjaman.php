<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    public const DIAJUKAN     = 'diajukan';
    public const DIPINJAM     = 'dipinjam';
    public const DIKEMBALIKAN = 'dikembalikan';
    public const DITOLAK      = 'ditolak';

    public const DAFTAR_STATUS = [
        self::DIAJUKAN,
        self::DIPINJAM,
        self::DIKEMBALIKAN,
        self::DITOLAK,
    ];

    protected $table = 'peminjamans';

    protected $fillable = ['anggota_id', 'buku_id', 'tanggal_pinjam', 'tanggal_kembali', 'status'];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam'  => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    /** Peminjaman yang masih berjalan: baru diajukan atau sedang dipinjam. */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->whereIn('status', [self::DIAJUKAN, self::DIPINJAM]);
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
