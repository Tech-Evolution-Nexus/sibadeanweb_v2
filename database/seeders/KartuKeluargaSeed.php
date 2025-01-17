<?php

namespace Database\Seeders;

use App\Models\KartuKeluargaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KartuKeluargaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'no_kk' => "0000000000000001",
                'alamat' => "Bondowoso",
                'rt' => "01",
                'rw' => "01",
            ],
            [
                'no_kk' => "0000000000000002",
                'alamat' => "Bondowoso",
                'rt' => "01",
                'rw' => "01",
            ],
        ];

        foreach ($data as $d) {
            KartuKeluargaModel::create($d);
        }
    }
}
