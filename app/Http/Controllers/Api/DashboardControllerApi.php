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
        $user = auth()->user();
        $masyarakat = $user->masyarakat;
        $role = $user->role;

        if (!$masyarakat) {
            return ResponseHelper::error('Data masyarakat tidak ditemukan', 404);
        }

        $nik = $masyarakat->nik;
        $rt = $masyarakat->kartuKeluarga->rt;
        $rw = $masyarakat->kartuKeluarga->rw;
        $totalTidakDibatalkan = 0;
        $totalSelesai = 0;

        $statusDibatalkan = ['dibatalkan_rt', 'dibatalkan_rw', 'dibatalkan_lurah', 'dibatalkan'];

        if ($role === 'masyarakat') {
            $totalTidakDibatalkan = PengajuanSuratModel::where('nik', $nik)
                ->whereNotIn('status', $statusDibatalkan)
                ->count();

            $totalSelesai = PengajuanSuratModel::where('nik', $nik)
                ->where('status', 'selesai')
                ->count();
        } elseif ($role === 'rt') {
            $nikList = MasyarakatModel::whereHas('kartuKeluarga', function ($q) use ($rt, $rw) {
                $q->where('rt', $rt)->where('rw', $rw);
            })->pluck('nik');

            $totalTidakDibatalkan = PengajuanSuratModel::whereIn('nik', $nikList)
                ->where('status', 'pending')
                ->count();

            $totalSelesai = PengajuanSuratModel::whereIn('nik', $nikList)
                ->where('status', 'di_terima_rt')
                ->count();
        } elseif ($role === 'rw') {
            $nikList = MasyarakatModel::whereHas('kartuKeluarga', function ($q) use ($rw) {
                $q->where('rw', $rw);
            })->pluck('nik');

            $totalTidakDibatalkan = PengajuanSuratModel::whereIn('nik', $nikList)
                ->where('status', 'di_terima_rt')
                ->count();

            $totalSelesai = PengajuanSuratModel::whereIn('nik', $nikList)
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
            'surat' => SuratResource::collection(
                SuratModel::whereIn("singkatan_nama_surat", ["skck", "sku", "sktm"])
                    ->limit(3)
                    ->get()
            ),
            'berita' => BeritaResource::collection(
                BeritaModel::orderByDesc("created_at")
                    ->limit(5)
                    ->get()
            ),
        ], 'Data Berhasil Diambil');
    }
}
