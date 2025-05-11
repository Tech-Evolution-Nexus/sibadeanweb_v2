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

class SuratControllerApi extends Controller
{
    public function index()
    {
        return ResponseHelper::success([
            'surat' => SuratResource::collection(SuratModel::get()),
        ], 'Data Berhasil Diambil');
    }
    public function detail($id)
    {
        $surat = SuratModel::with(['fields', 'lampiransurat.lampiran'])->find($id);

        if (!$surat) {
            return ResponseHelper::error('Berita tidak ditemukan', 404);
        }

        return ResponseHelper::success([
            'surat' => new SuratResource($surat),
        ], 'Detail surat berhasil diambil');
    }
}
