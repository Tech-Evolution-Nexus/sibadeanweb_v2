<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SuratPengantarController extends Controller
{
    public function show()
    {
        $data = (object)[
            'nomor_surat' => '28/08.02/2025',
            'nama' => 'AKBAR MAULIDI RUSDIANSYAH',
            'tempat_lahir' => 'Bondowoso',
            'tanggal_lahir' => '2004-05-03',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'no_ktp_kk' => '3511110805061693',
            'pekerjaan' => 'Mahasiswa',
            'keperluan' => 'Mengurus SKTM',
            'rt' => '008',
            'rw' => '002',
            'tanggal_surat' => '2025-05-27',
            'nama_ketua_rt' => 'GITA AMIN HIDAYAT, SPd',
        ];

        return view('admin.surat_pengantar', compact('data'));
    }
}
