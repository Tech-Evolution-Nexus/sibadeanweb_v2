<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSuratModel;
use Illuminate\Http\Request;
use ResponseHelper;

class PengajuanController extends Controller
{
    public function getRiwayat($idMasyarakat) {
        $pengajuan  = PengajuanSuratModel::where("nik",$idMasyarakat)
        ->with(["masyarakat","surat","lampiran"])
        ->orderBy("id","desc")
        ->get();
        return ResponseHelper::success($pengajuan);
    }
}
