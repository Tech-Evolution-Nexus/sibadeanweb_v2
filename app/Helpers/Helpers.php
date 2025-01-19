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
