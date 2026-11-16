<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategoris';

    protected $fillable = [
        'nama',
    ];

    public function bukus(): HasMany
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }

    public function __toString()
    {
        return $this->nama;
    }
}
