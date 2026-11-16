<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kategori_id' => Kategori::inRandomOrder()->value('id'),
            'judul' => fake()->sentence(3),
            'penulis' => fake()->name(),
            'tahun_terbit' => fake()->numberBetween(1980, 2025),
            'image' => fake()->randomElement([
                'laskar-pelangi.jpg',
                'negeri-5-menara.jpg',
                'laut-bercerita.jpg',
                'perempuan-berkalung-sorban.jpg',
                'filosofi-teras.jpg',
                'sebuah-seni-untuk-bersikap-bodoamat.jpg',
                'ikigai.jpg',
                'habis-gelap-terbitlah-terang.jpg',
                'untuk-negeriku.jpg',
                'sukarno-biografi-singkat.jpg',
                'sekolahnya-manusia.jpg',
                'guru-aini.jpg',
                'disruption.jpg',
                'the-great-shifting.jpg',
                'memahami-ai.jpg',
                'kosmos.jpg',
            ]),
            'description' => fake()->paragraph(),
        ];
    }
}