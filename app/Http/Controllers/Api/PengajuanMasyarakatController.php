<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengajuanResource;
use App\Models\LampiranSuratModel;
use App\Models\MasyarakatModel;
use App\Models\PengajuanSuratModel;
use App\Models\SuratModel;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Helpers;
use ResponseHelper;

class PengajuanMasyarakatController extends Controller
{
    public function getRiwayat()
    {
        $idMasyarakat = auth()->user()->masyarakat->nik;
        $user = MasyarakatModel::whereHas("user", function ($qr) {
            $qr->whereIn("role", ["rt", "rw"]);
        })->where("nik", $idMasyarakat)->first();

        $pengajuan = PengajuanSuratModel::where("nik", $idMasyarakat)
            ->with(["masyarakat", "surat", "lampiran"])
            ->when($user->user->role == "rw", function ($qr) use ($user) {
                $qr->where("status", "di_terima_rt")
                    ->whereHas("masyarakat.kartuKeluarga", function ($qr2) use ($user) {
                        $qr2->where("rw", $user->kartuKeluarga->rw);
                    });
            })
            ->when($user->user->role == "rt", function ($qr) use ($user) {
                $qr->where("status", "pending")
                    ->whereHas("masyarakat.kartuKeluarga", function ($qr2) use ($user) {
                        $qr2->where("rw", $user->kartuKeluarga->rw);
                        $qr2->where("rt", $user->kartuKeluarga->rt);
                    });
                ;
            })
            ->orderBy("id", "desc")
            ->get();

        $pengajuanSelesai = PengajuanSuratModel::where("nik", $idMasyarakat)
            ->with(["masyarakat", "surat", "lampiran"])
            ->when($user->user->role == "rw", function ($qr) use ($user) {
                $qr->whereIn("status", ["di_terima_rw", "di_tolak_rw", "selesai", "di_tolak_lurah"])
                    ->whereHas("masyarakat.kartuKeluarga", function ($qr2) use ($user) {
                        $qr2->where("rw", $user->kartuKeluarga->rw);
                    });
            })
            ->when($user->user->role == "rt", callback: function ($qr) use ($user) {
                $qr->whereIn("status", ["di_terima_rt", "di_tolak_rt", "di_terima_rw", "di_tolak_rw", "selesai", "di_tolak_lurah"])
                    ->whereHas("masyarakat.kartuKeluarga", function ($qr2) use ($user) {
                        $qr2->where("rw", $user->kartuKeluarga->rw);
                        $qr2->where("rt", $user->kartuKeluarga->rt);
                    });
                ;
            })->orderBy("id", "desc")
            ->get();
        return ResponseHelper::success(
            [
                "pengajuanMenunggu" => PengajuanResource::collection($pengajuan),
                "pengajuanSelesai" => PengajuanResource::collection($pengajuanSelesai),
            ]
        );
    }
    public function getRiwayatDetail($idPengajuan)
    {
        $pengajuan = PengajuanSuratModel::where("id", $idPengajuan)
            ->with(["masyarakat", "surat", "lampiran", "field_values"])
            // ->where("status", "pending")
            ->orderBy("id", "desc")
            ->first();

        return ResponseHelper::success(
            $pengajuan,
        );
    }
}
