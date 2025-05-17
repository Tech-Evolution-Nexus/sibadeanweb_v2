<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BeritaResource;
use App\Http\Resources\SuratResource;
use App\Models\BeritaModel;
use Illuminate\Http\Request;
use App\Models\MasyarakatModel;
use App\Models\KartuKeluargaModel;
use App\Models\PengajuanSuratModel;
use App\Models\SuratModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Database\Query\Sorter\OrderByKey;
use ResponseHelper;

class DashboardControllerApi extends Controller
{
    public function index()
    {
        $masyarakat = auth()->user()->masyarakat;
        $role = auth()->user()->role;

        // Cek apakah data masyarakat tersedia
        if (!$masyarakat) {
            return ResponseHelper::error('Data masyarakat tidak ditemukan', 404);
        }

        $nik = $masyarakat->nik;
        $totalTidakDibatalkan = 0;
        $totalSelesai = 0;

        if ($role === 'masyarakat') {
            $totalTidakDibatalkan = PengajuanSuratModel::where('nik', $nik)
                ->where('status', 'selesai')
                ->count();

            $totalSelesai = PengajuanSuratModel::where('nik', $nik)
                ->whereNotIn('status', [
                    'dibatalkan_rt',
                    'dibatalkan_rw',
                    'dibatalkan_lurah',
                    'dibatalkan'
                ])
                ->count();
        } elseif ($role === 'rt') {
            $totalTidakDibatalkan = PengajuanSuratModel::where('nik', $nik)
                ->where('status', 'pendding')
                ->count();

            $totalSelesai = PengajuanSuratModel::where('nik', $nik)
                ->where('status', 'di_terima_rt')
                ->count();
        } elseif ($role === 'rw') {
            $totalTidakDibatalkan = PengajuanSuratModel::where('nik', $nik)
                ->where('status', 'di_terima_rt')
                ->count();

            $totalSelesai = PengajuanSuratModel::where('nik', $nik)
                ->where('status', 'di_terima_rw')
                ->count();
        } else {
            return ResponseHelper::error('Role tidak dikenali', 400);
        }

        return ResponseHelper::success([
            'dash' => [
                'total_menunggu_persetujuan' => $totalTidakDibatalkan,
                'total_persetujuan_selesai' => $totalSelesai,
            ],
            'surat' => SuratResource::collection(SuratModel::limit(3)->whereIn("singkatan_nama_surat", ["skck", "sku", "sktm"])->get()),
            'berita' => BeritaResource::collection(BeritaModel::limit(5)->orderByDesc("created_at")->get()),
        ], 'Data Berhasil Diambil');
    }
}
