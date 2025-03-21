<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BeritaModel>
 */
class BeritaModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "judul" => $this->faker->sentence(6, true), // Judul yang lebih panjang dan masuk akal
            "slug" => Str::slug($this->faker->unique()->sentence(4, false)), // Slug unik
            "keterangan" => $this->faker->text(100), // Keterangan lebih deskriptif (100 karakter)
            "konten" => $this->faker->paragraphs(5, true),
            "gambar" => "assets/image/badean.jpg"
        ];
    }
}
