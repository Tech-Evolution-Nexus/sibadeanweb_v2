<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BeritaResource;
use App\Http\Resources\SuratResource;
use App\Models\BeritaModel;
use Illuminate\Http\Request;
use App\Models\MasyarakatModel;
use App\Models\KartuKeluargaModel;
use App\Models\SuratModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Database\Query\Sorter\OrderByKey;
use ResponseHelper;

class DashboardControllerApi extends Controller
{
    public function index()
    {
        return ResponseHelper::success([
            'surat' => SuratResource::collection(SuratModel::limit(3)->whereIn("singkatan_nama_surat", ["skck", "sku", "sktm"])->get()),
            'berita' => BeritaResource::collection(BeritaModel::limit(5)->orderByDesc("created_at")->get()),
        ], 'Data Berhasil Diambil');
    }
}
