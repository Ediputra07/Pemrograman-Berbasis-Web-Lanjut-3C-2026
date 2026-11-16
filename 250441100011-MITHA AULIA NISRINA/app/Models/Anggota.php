<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';

    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
