<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';

    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
    ];

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }
}
