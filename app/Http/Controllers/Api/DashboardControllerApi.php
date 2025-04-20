<?php

namespace App\Http\Controllers\API;

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
use ResponseHelper;

class DashboardControllerApi extends Controller
{
    public function index()
    {
        return ResponseHelper::success([
            'surat' => SuratResource::collection(SuratModel::limit(5)->get()),
            'berita' => BeritaResource::collection(BeritaModel::limit(5)->get()),
        ], 'Data Berhasil Diambil');
    }
}
