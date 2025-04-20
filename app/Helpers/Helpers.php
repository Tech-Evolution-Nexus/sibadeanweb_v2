<?php


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
