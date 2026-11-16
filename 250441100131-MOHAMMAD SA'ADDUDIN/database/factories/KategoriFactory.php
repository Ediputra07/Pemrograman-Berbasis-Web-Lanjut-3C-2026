<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategori>
 */
class KategoriFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->randomElement([
                'Pemrograman',
                'Rekayasa Perangkat Lunak',
                'Basis Data',
                'Pengembangan Web',
                'Pemrograman Web',
                'Jaringan Komputer',
                'Kecerdasan Buatan',
                'Keamanan Informasi',
            ]),
        ];
    }
}
