<?php

namespace Database\Factories;

use App\Models\MasyarakatModel;
use App\Models\SuratModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BeritaModel>
 */
class PengajuanModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => MasyarakatModel::inRandomOrder()->first()->nik ?? MasyarakatModel::factory()->create()->nik,
            'id_surat' => SuratModel::inRandomOrder()->first()->id ?? SuratModel::factory()->create()->id,
            'nomor_surat' => $this->faker->numerify('NS-######'),
            'status' => 'pending',
            'pengantar_rt' => $this->faker->sentence(),
            'keterangan' => $this->faker->sentence(5),
            'keterangan_ditolak' => null
        ];
    }
}
