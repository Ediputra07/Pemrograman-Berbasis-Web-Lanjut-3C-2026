<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // 1. Admin dan petugas boleh melihat semua data peminjaman (status 200)
        if ($user->hasRole(['admin', 'petugas'])) {
            return true;
        }

        // 2. Siswa HANYA boleh melihat jika id usernya cocok dengan anggota_id di peminjaman
        return $user->id === $peminjaman->anggota_id;
    }
}
