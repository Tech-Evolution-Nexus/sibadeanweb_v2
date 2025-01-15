<?php


use App\Models\PengaturanModel;

class Helpers
{
    static function pengaturan()
    {
        return PengaturanModel::first();
    }
}
