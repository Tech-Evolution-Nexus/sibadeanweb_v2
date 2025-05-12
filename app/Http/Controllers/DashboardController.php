<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSuratModel;
use App\Models\SuratKeluarModel;

class DashboardController extends Controller
{
    public function index()
    {
        $suratTertunda = PengajuanSuratModel::where("status", "di_terima_rw")->count();
        $suratMasuk = PengajuanSuratModel::where("status", "di_terima_rw")->count();
        $suratKeluar = SuratKeluarModel::count();

        $params = [
            "suratTertunda" => $suratTertunda,
            "suratKeluar" => $suratKeluar,
            "suratMasuk" => $suratMasuk,
        ];

        return view("dashboard", $params);
    }
}
