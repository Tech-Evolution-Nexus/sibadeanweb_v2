<?php

namespace Database\Factories;

use App\Models\KartuKeluargaModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MasyarakatModel>
 */
class KartuKeluargaModelFactory extends Factory
{
    protected $model = KartuKeluargaModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'no_kk' => $this->faker->unique()->numerify('################'),
            'alamat' => $this->faker->address,
            'rt' => $this->faker->numberBetween(1, 10),
            'rw' => $this->faker->numberBetween(1, 10),
            'kk_gambar' => null,
        ];
    }

    // public function hasMasyarakat()
    // {
    //     return $this->has(MasyarakatModelFactory);
    // }
}
