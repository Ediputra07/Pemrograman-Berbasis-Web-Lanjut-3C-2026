<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Anggota::factory()->count(3)->sequence(
            ['nama' => 'Ahmad Fauzi', 'email' => 'ahmad.fauzi@gmail.com', 'no_telepon' => '081234567890'],
            ['nama' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@gmail.com', 'no_telepon' => '082345678901'],
            ['nama' => 'Rizky Pratama', 'email' => 'rizky.pratama@gmail.com', 'no_telepon' => '083456789012']
        )->create();
    }
}
