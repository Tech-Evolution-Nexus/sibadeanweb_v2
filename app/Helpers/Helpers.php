<?php


use App\Models\PengajuanSuratModel;
use App\Models\PengaturanModel;
use Carbon\Carbon;

class Helpers
{
    static function pengaturan()
    {
        return PengaturanModel::first();
    }

    static function formatDate($date, $showDay = false)
    {
        Carbon::setLocale('id');
        if ($showDay) {
            return Carbon::parse($date)->translatedFormat('l, d F Y');
        }
        return Carbon::parse($date)->translatedFormat('d F Y');
    }

    static function getCountPengajuan()
    {
        $countMenungguPengajuan = PengajuanSuratModel::where("status", "di_terima_rw")->count();
        $countPengajuan = PengajuanSuratModel::where("status", "selesai")->orWhere("status", "di_terima_rw")->count();

        return (object) ["countMenungguPengajuan" => $countMenungguPengajuan, "countPengajuan" => $countPengajuan];
    }

    static function formatStatusPengajuan($status)
    {
        return match ($status) {
            "pending" => "Menunggu Rt",
            "di_terima_rt" => "Diterima oleh RT",
            "di_tolak_rt" => "Ditolak oleh RT",
            "di_terima_rw" => "Diterima oleh RW",
            "di_tolak_rw" => "Ditolak oleh RW",
            "selesai" => "Diterima oleh Lurah",
            "di_tolak_lurah" => "Ditolak oleh Lurah",

        };
    }
}
class ResponseHelper
{

    static function success($data = [], $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    static function error($message = 'Error', $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }
}
