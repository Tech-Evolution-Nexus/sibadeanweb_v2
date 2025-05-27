<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSuratModel;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratPengantarController extends Controller
{
    public function show()
    {
        $data = PengajuanSuratModel::first();
        $totalPengantarRt = PengajuanSuratModel::whereNotIn("status", ["dibatalkan", "pending"])->whereNot("id", 1)->count() + 1;
        return Pdf::loadView('admin.surat_pengantar', compact('data', 'totalPengantarRt'))
            ->setOptions(['isRemoteEnabled' => true])
            ->stream('pengantar_rt.pdf');
    }
}
