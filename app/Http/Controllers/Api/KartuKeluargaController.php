<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasyarakatModel;
use Illuminate\Http\Request;
use ResponseHelper;

class KartuKeluargaController extends Controller
{
  public function getAnggotaKeluarga($nokk)  {
    $anggotaKeluarga=MasyarakatModel::where("no_kk","=",$nokk)->get();
   
    return ResponseHelper::success($anggotaKeluarga);
    
  }
}
