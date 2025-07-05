<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\NotificationHelper;
use App\Http\Resources\PengajuanResource;
use App\Models\HistoriPengajuan;
use App\Models\KartuKeluargaModel;
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
            $qr->whereIn("role", ["rt", "rw", "masyarakat"]);
        })->where("nik", $idMasyarakat)->first();

        if (!$user || !$user->user) {
            return ResponseHelper::error([
                "message" => "Data masyarakat atau user tidak ditemukan."
            ]);
        }

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
            ->when($user->user->role == "rt", function ($qr) use ($user) {
                $qr->whereIn("status", ["di_terima_rt", "di_tolak_rt", "di_terima_rw", "di_tolak_rw", "selesai", "di_tolak_lurah"])
                    ->whereHas("masyarakat.kartuKeluarga", function ($qr2) use ($user) {
                        $qr2->where("rw", $user->kartuKeluarga->rw);
                        $qr2->where("rt", $user->kartuKeluarga->rt);
                    });
            })
            ->orderBy("id", "desc")
            ->get();

        return ResponseHelper::success([
            "pengajuanMenunggu" => PengajuanResource::collection($pengajuan),
            "pengajuanSelesai" => PengajuanResource::collection($pengajuanSelesai),
        ]);
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
            "status" => "required|in:ditolak,disetujui,dibatalkan"
        ]);

        if ($validated->fails()) {
            return ResponseHelper::error(
                ["message" => "Status Pengajuan berhasil diupdate", "error" => $validated->errors()]
            );
        }

        try {
            $pengaturan = Helpers::pengaturan();
            $userAprove = auth()->user();
            $userlogin = User::with("masyarakat.kartuKeluarga")->find($userAprove->id);
            $role = $userAprove->role;
            $statusPengajuan = request()->status;
            $dataRw = $userlogin->masyarakat->kartuKeluarga->rw;

            $pengajuan = PengajuanSuratModel::find($idPengajuan);
            $userpengajuan = MasyarakatModel::with("user")->where("nik", $pengajuan->nik)->first();

            $data2 = KartuKeluargaModel::where('rw', $dataRw)
                ->whereHas('masyarakat.user', function ($query) {
                    $query->where('role', 'rw');
                })
                ->with('masyarakat.user')
                ->first();
            // return response()->json(
            //     $userpengajuan->user->fcm_token,
            //     200
            // );

            $status = "";
            if ($role == "rw") {
                $status = match ($statusPengajuan) {
                    "ditolak" => "di_tolak_rw",
                    "disetujui" => "di_terima_rw",
                    "dibatalkan" => "dibatalkan"
                };
                $pesan = match ($statusPengajuan) {
                    "ditolak" => "Surat ditolak oleh RW",
                    "disetujui" => "Surat Disetujui oleh RW",
                    "dibatalkan" => "dibatalkan"
                };
                if ($status != "dibatalkan") {
                    if ($userpengajuan->user->fcm_token) {
                        NotificationHelper::sendFcm(
                            $userpengajuan->user->fcm_token,
                            'Surat Anda Sudah Diproses',
                            $pesan
                        );
                    }
                }
            } else if ($role == "rt") {
                if (!$pengaturan->hasRw) {
                    $status = match ($statusPengajuan) {
                        "ditolak" => "di_tolak_rt",
                        "disetujui" => "di_terima_rt",
                        "dibatalkan" => "dibatalkan"
                    };
                    $status = "di_terima_rw";
                } else {
                    $status = match ($statusPengajuan) {
                        "ditolak" => "di_tolak_rt",
                        "disetujui" => "di_terima_rt",
                        "dibatalkan" => "dibatalkan"
                    };
                    $pesan = match ($statusPengajuan) {
                        "ditolak" => "Surat ditolak oleh RT",
                        "disetujui" => "Surat Disetujui oleh RT",
                        "dibatalkan" => "dibatalkan"
                    };
                    if ($status != "dibatalkan") {
                        if ($userpengajuan->user->fcm_token) {
                            NotificationHelper::sendFcm(
                                $userpengajuan->user->fcm_token,
                                'Surat Anda Sudah Diproses',
                                $pesan
                            );
                        }
                    }
                    if ($status == "di_terima_rt") {
                        if ($data2 && $data2->masyarakat->first()->user && $data2->masyarakat->first()->user->fcm_token) {
                            NotificationHelper::sendFcm(
                                $data2->masyarakat->first()->user->fcm_token,
                                'Pengajuan Surat Baru',
                                'Ada pengajuan surat baru yang masuk. Silahkan cek di aplikasi.'
                            );
                        }
                    }
                }
            } else {
                $status = match ($statusPengajuan) {
                    "dibatalkan" => "dibatalkan"
                };
            }

            HistoriPengajuan::create([
                "id_pengajuan" => $idPengajuan,
                "id_petugas" => auth()->user()->masyarakat->nik,
                "status_pengajuan" => $status
            ]);
            $pengajuan->update([
                "status" => $status,
                "keterangan_ditolak" => request()->keterangan,
            ]);

            return ResponseHelper::success(
                ["message" => "Status Pengajuan berhasil diupdate"]
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(
                ["message" => $th->getMessage()]
            );
        }
    }
}
