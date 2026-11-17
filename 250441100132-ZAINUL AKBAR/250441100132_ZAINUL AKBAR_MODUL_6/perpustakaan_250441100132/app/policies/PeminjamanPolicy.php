<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // Admin dan petugas boleh melihat semua peminjaman (menggunakan Spatie Permission hasAnyRole)
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;
        }

        // Siswa hanya boleh melihat peminjaman miliknya sendiri
        // (Sesuaikan 'user_id' dengan nama kolom foreign key di tabel peminjamans Anda)
        return $user->id === $peminjaman->user_id;
    }
}