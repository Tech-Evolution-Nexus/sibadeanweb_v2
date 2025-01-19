<?php

namespace Database\Seeders;

use App\Models\KartuKeluargaModel;
use App\Models\MasyarakatModel;
use App\Models\PengaturanModel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // $result =   MasyarakatModel::factory()->count(10)->create();
        KartuKeluargaModel::factory(20)->create()->each(function ($kartuKeluarga) {
            MasyarakatModel::factory()->create([
                'no_kk' => $kartuKeluarga->no_kk,
                "status_keluarga" => "kk"
            ]);
            MasyarakatModel::factory()->create([
                'no_kk' => $kartuKeluarga->no_kk,
                "status_keluarga" => "istri"
            ]);
            MasyarakatModel::factory()->create([
                'no_kk' => $kartuKeluarga->no_kk,
                "status_keluarga" => "anak"
            ]);
        });

        User::factory()->create([
            'name' => 'Muhammad Nor Kholit',
            'email' => 'badean@gmail.com',
            "password" => bcrypt("12341234"),
            "role" => "admin",
            "status" => 1
        ]);

        PengaturanModel::create([
            "hasRw" => 1,
            "primary_color" => "#052158",
            "secondary_color" => "#052158",
            "logo_horizontal" => "6782678fb6528.png",
            "logo" => "6782671469edb.png",
            "kelurahan" => "Badean",
            "kode_pos" => "68727",
            "kabupaten" => "Bondowoso",
            "kecamatan" => "Badean",
            "provinsi" => "Jawa Timur"
        ]);
    }
}
