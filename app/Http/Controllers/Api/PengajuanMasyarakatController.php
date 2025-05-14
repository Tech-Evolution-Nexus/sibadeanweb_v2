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
use Illuminate\Support\Facades\Validator;
use ResponseHelper;

class PengajuanMasyarakatController extends Controller
{
    public function getRiwayat()
    {
        $idMasyarakat = auth()->user()->masyarakat->nik;
        $user = MasyarakatModel::whereHas("user", function ($qr) {
            $qr->whereIn("role", ["rt", "rw"]);
        })->where("nik", $idMasyarakat)->first();

        $pengajuan = PengajuanSuratModel::with(["masyarakat", "surat", "lampiran"])
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

        $pengajuanSelesai = PengajuanSuratModel::with(["masyarakat", "surat", "lampiran"])
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
                "pengajuan" => $pengajuan
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


    public function updateStatus($idPengajuan)
    {
        $validated = Validator::make(request()->all(), [
            "status" => "required|in:ditolak,disetujui"
        ]);

        if ($validated->fails()) {
            return ResponseHelper::error(
                ["message" => "Status Pengajuan berhasil diupdate", "error" => $validated->errors()]
            );
        }
        $userAprove = auth()->user();
        $role = $userAprove->role;
        $statusPengajuan = request()->status;

        $pengajuan = PengajuanSuratModel::find($idPengajuan);

        $status = "";
        if ($role == "rw") {
            $status = match ($statusPengajuan) {
                "ditolak" => "di_tolak_rw",
                "disetujui" => "di_terima_rw",
            };
        } else if ($role == "rt") {
            $status = match ($statusPengajuan) {
                "ditolak" => "di_tolak_rt",
                "disetujui" => "di_terima_rt",
            };
        }

        $pengajuan->update([
            "status" => $status,
            "keterangan_di_tolak" => request()->keterangan,
        ]);

        return ResponseHelper::success(
            ["message" => "Status Pengajuan berhasil diupdate"]
        );
    }
}
