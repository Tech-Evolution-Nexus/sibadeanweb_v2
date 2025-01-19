<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            "judul" => $this->faker->sentence,
            "slug" => $this->faker->slug,
            "keterangan" => $this->faker->sentence,
            "konten" => $this->faker->paragraph,
            "gambar" => $this->faker->imageUrl()
        ];
    }
}
