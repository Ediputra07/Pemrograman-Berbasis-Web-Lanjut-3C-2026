<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    /**
     * Menentukan siapa yang boleh melihat detail peminjaman.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // Admin dan Petugas boleh melihat semua peminjaman.
        if ($user->hasAnyRole(['Admin', 'Petugas'])) {
            return true;
        }

        // Pengguna selain Siswa tidak diizinkan.
        if (!$user->hasRole('Siswa')) {
            return false;
        }

        // Siswa hanya boleh melihat peminjaman miliknya sendiri.
        return $peminjaman->anggota !== null
            && (int) $peminjaman->anggota->user_id === (int) $user->id;
    }
}
