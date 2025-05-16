<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSuratModel;
use App\Models\SuratKeluarModel;
use Carbon\Carbon;

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
            "chart" => $this->getChartDataMingguIni(),
        ];

        return view("dashboard", $params);
    }


    private function getChartDataMingguIni()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Ambil data surat masuk per hari
        $suratMasukPerHari = PengajuanSuratModel::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('status', 'di_terima_rw')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Ambil data surat keluar per hari
        $suratKeluarPerHari = SuratKeluarModel::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Buat array tanggal dan label hari (Senin, Selasa, ...)
        $dates = [];
        $dayLabels = [];
        for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
            $dayLabels[] = $date->format('l'); // Nama hari bahasa Inggris, bisa diubah ke bahasa Indonesia jika perlu
        }

        // Data surat masuk dan keluar per tanggal
        $suratMasukData = [];
        $suratKeluarData = [];
        foreach ($dates as $date) {
            $suratMasukData[] = $suratMasukPerHari->has($date) ? $suratMasukPerHari[$date]->total : 0;
            $suratKeluarData[] = $suratKeluarPerHari->has($date) ? $suratKeluarPerHari[$date]->total : 0;
        }

        return [
            'dates' => $dates,
            'labels' => $dayLabels,
            'suratMasukData' => $suratMasukData,
            'suratKeluarData' => $suratKeluarData,
        ];
    }
}
