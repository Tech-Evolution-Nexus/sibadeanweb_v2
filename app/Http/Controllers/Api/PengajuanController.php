<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSuratModel;
use Carbon\Carbon;
use ResponseHelper;

class PengajuanController extends Controller
{
    public function getRiwayat($idMasyarakat)
    {
        $pengajuan = PengajuanSuratModel::where("nik", $idMasyarakat)
            ->with(["masyarakat", "surat", "lampiran"])
            ->where("status", "pending")
            ->orderBy("id", "desc")
            ->get()
            ->map(function ($item) {
                // Format the created_at date
                $item->created_at = Carbon::parse($item->created_at)->format('d-m-Y'); // Modify the format as needed
                return $item;
            });

        $pengajuanProses = PengajuanSuratModel::where("nik", $idMasyarakat)
            ->with(["masyarakat", "surat", "lampiran"])
            ->whereIn("status", ["di_terima_rt", "di_terima_rw"])
            ->orderBy("id", "desc")
            ->get();

        $pengajuanSelesai = PengajuanSuratModel::where("nik", $idMasyarakat)
            ->with(["masyarakat", "surat", "lampiran"])
            ->where("status", "selesai")
            ->orderBy("id", "desc")
            ->get();

        $pengajuanTolak = PengajuanSuratModel::where("nik", $idMasyarakat)
            ->with(["masyarakat", "surat", "lampiran"])
            ->whereIn("status", ["di_tolak_rt", "di_tolak_rw", "di_tolak_lurah"])
            ->orderBy("id", "desc")
            ->get();

        $pengajuanBatal = PengajuanSuratModel::where("nik", $idMasyarakat)
            ->with(["masyarakat", "surat", "lampiran"])
            ->where("status", "dibatalkan")
            ->orderBy("id", "desc")
            ->get();
        return ResponseHelper::success(
            [
                "pengajuanMenunggu" => $pengajuan,
                "pengajuanProses" => $pengajuanProses,
                "pengajuanSelesai" => $pengajuanSelesai,
                "pengajuanTolak" => $pengajuanTolak,
                "pengajuanBatal" => $pengajuanBatal,
            ]
        );
    }
    public function getRiwayatDetail($idPengajuan)
    {
        $pengajuan = PengajuanSuratModel::where("id", $idPengajuan)
            ->with(["masyarakat", "surat", "lampiran"])
            // ->where("status", "pending")
            ->orderBy("id", "desc")
            ->first();


        return ResponseHelper::success(
            $pengajuan,
        );
    }
}
