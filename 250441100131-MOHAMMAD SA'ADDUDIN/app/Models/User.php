<?php

namespace App\Models;


use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// Catatan: kolom role/permission TIDAK ada di $fillable, jadi tidak bisa
// diisi lewat mass assignment (mis. dari formulir registrasi).
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
   
    use HasFactory, Notifiable, HasRoles;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** Profil keanggotaan perpustakaan milik pengguna ini. */
    public function anggota(): HasOne
    {
        return $this->hasOne(Anggota::class);
    }

    /** Ambil data anggota milik pengguna; dibuatkan jika belum ada. */
    public function pastikanAnggota(): Anggota
    {
        return $this->anggota ?? $this->anggota()->create([
            'nama'       => $this->name,
            'email'      => $this->email,
            'no_telepon' => '-',
        ]);
    }

   
    public function peminjamanSaya(): Builder
    {
        return Peminjaman::query()
            ->whereHas('anggota', fn ($q) => $q->where('user_id', $this->id));
    }
}
