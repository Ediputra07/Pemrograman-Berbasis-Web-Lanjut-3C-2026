<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        $daftar = [
            ['name' => 'Administrator',        'email' => 'admin@gmail.com',   'role' => 'admin',   'no_telepon' => '081200000001'],
            ['name' => 'Petugas Perpustakaan', 'email' => 'petugas@gmail.com', 'role' => 'petugas', 'no_telepon' => '081200000002'],
            ['name' => 'Siswa Teladan',        'email' => 'siswa@gmail.com',   'role' => 'siswa',   'no_telepon' => '081200000003'],
        ];

        foreach ($daftar as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password'),
                ]
            );

            $user->syncRoles($data['role']);

            // Setiap akun punya profil anggota supaya bisa mengajukan peminjaman
            Anggota::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama'       => $data['name'],
                    'email'      => $data['email'],
                    'no_telepon' => $data['no_telepon'],
                ]
            );
        }
        // Mengganti password bawaan akun admin
        $admin = User::where('email', 'admin@gmail.com')->first();

        if ($admin) {
            $admin->password = Hash::make('Akuadmin123');
            $admin->save();
        }
    }
}
