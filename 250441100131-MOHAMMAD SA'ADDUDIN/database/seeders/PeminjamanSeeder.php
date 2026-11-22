<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $buku = Buku::all();

        Anggota::all()->each(function ($satuAnggota) use ($buku) {
            Peminjaman::factory()
                ->for($satuAnggota)
                ->for($buku->random())
                ->create();
        });

        // Satu pengajuan baru milik akun siswa, supaya alur persetujuan bisa langsung dicoba
        $anggotaSiswa = User::where('email', 'siswa@gmail.com')->first()?->anggota;

        if ($anggotaSiswa) {
            Peminjaman::factory()
                ->for($anggotaSiswa)
                ->for($buku->random())
                ->create([
                    'tanggal_pinjam'  => now()->toDateString(),
                    'tanggal_kembali' => null,
                    'status'          => Peminjaman::DIAJUKAN,
                ]);
        }
    }
}
