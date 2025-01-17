<?php

namespace Database\Seeders;

use App\Models\MasyarakatModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasyarakatSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nik' => "1000000000000000",
                'no_kk' => "0000000000000001",
                'nama_lengkap' => "Ahmad Yusuf",
                'jenis_kelamin' => "laki-laki",
                'tempat_lahir' => "Bondowoso",
                'tanggal_lahir' => date("Y-m-d"),
                'agama' => "islam",
                'pendidikan' => "D4",
                'pekerjaan' => "Pelajar",
                'golongan_darah' => "A+",
                'status_perkawinan' => "belum_menikah",
                'status_keluarga' => "kk",
                'kewarganegaraan' => "WNI",
                'no_paspor' => null,
                'no_kitap' => null,
                'nama_ayah' => "Ahmad ",
                'nama_ibu' => "Suryati",
                "created_at" => date("Y-m-d H:i")

            ],
            [
                'nik' => "2000000000000000",
                'no_kk' => "0000000000000002",
                'nama_lengkap' => "Ahmad Bakri",
                'jenis_kelamin' => "laki-laki",
                'tempat_lahir' => "Bondowoso",
                'tanggal_lahir' => date("Y-m-d"),
                'agama' => "islam",
                'pendidikan' => "D4",
                'pekerjaan' => "Pelajar",
                'golongan_darah' => "A+",
                'status_perkawinan' => "belum_menikah",
                'status_keluarga' => "kk",
                'kewarganegaraan' => "WNI",
                'no_paspor' => null,
                'no_kitap' => null,
                'nama_ayah' => "Ahmad ",
                'nama_ibu' => "Suryati",
                "created_at" => date("Y-m-d H:i")
            ]
        ];

        foreach ($data as $d) {
            MasyarakatModel::create($d);
        }
    }
}
