<?php

namespace App\Policies;

use App\Models\Anggota;
use App\Models\User;

class AnggotaPolicy
{
   
    public function lihatRiwayat(User $user, Anggota $anggota): bool
    {
        if ($user->can('kelola peminjaman')) {
            return true;
        }

        return $user->can('melihat riwayat peminjaman sendiri')
            && $anggota->user_id === $user->id;
    }
}
