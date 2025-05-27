<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSuratModel;

class SuratPengantarController extends Controller
{
    public function show()
    {
        $data = PengajuanSuratModel::first();
        $totalPengantarRt = PengajuanSuratModel::whereNotIn("status",["dibatalkan","pending"])->whereNot("id",1)->count() + 1;
        return view('admin.surat_pengantar', compact('data',"totalPengantarRt"));
    }
}
