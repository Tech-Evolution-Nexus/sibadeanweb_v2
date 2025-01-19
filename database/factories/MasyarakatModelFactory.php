<?php

namespace Database\Factories;

use App\Models\BeritaModel;
use App\Models\Kartu2Model;
use App\Models\KartuKeluargaModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MasyarakatModel>
 */
class MasyarakatModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => $this->faker->numerify('################'), // 16-digit number
            'id_user' => User::factory(), // Hubungkan dengan factory User
            'no_kk' => KartuKeluargaModel::factory()->create()->no_kk, // Hubungkan dengan factory KartuKeluarga
            'nama_lengkap' => $this->faker->name,
            'jenis_kelamin' => $this->faker->randomElement(['laki-laki', 'perempuan']),
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date(),
            'agama' => $this->faker->randomElement(['islam', 'kristen_protestan', 'kristen_katolik', 'hindu', 'buddha', 'konghucu', 'lainnya']),
            'pendidikan' => $this->faker->randomElement(['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3']),
            'pekerjaan' => $this->faker->jobTitle,
            'golongan_darah' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'status_perkawinan' => $this->faker->randomElement(['belum_menikah', 'menikah', 'cerai_hidup', 'cerai_mati', 'duda', 'janda']),
            'tanggal_perkawinan' => $this->faker->optional()->date(),
            'status_keluarga' => $this->faker->randomElement(['kk', 'istri', 'anak', 'wali']),
            'kewarganegaraan' => $this->faker->randomElement(['WNI', 'WNA']),
            'no_paspor' => $this->faker->optional()->numerify('###############'),
            'no_kitap' => $this->faker->optional()->numerify('###########'),
            'nama_ayah' => $this->faker->name('male'),
            'nama_ibu' => $this->faker->name('female'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
