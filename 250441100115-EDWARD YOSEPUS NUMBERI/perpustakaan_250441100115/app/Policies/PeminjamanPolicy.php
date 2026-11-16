<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    /**
     * Tentukan apakah pengguna dapat melihat peminjaman tertentu.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // 1. Admin dan petugas diizinkan melihat semua data peminjaman
        if ($user->hasRole(['admin', 'petugas'])) {
            return true;
        }

        // 2. Siswa hanya diizinkan melihat peminjaman miliknya sendiri
        return $user->id === $peminjaman->anggota_id; 
    }
}