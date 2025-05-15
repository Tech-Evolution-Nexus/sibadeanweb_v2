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
use ResponseHelper;

class BeritaControllerApi extends Controller
{
    public function index()
    {
        return ResponseHelper::success([
            'berita' => BeritaResource::collection(BeritaModel::orderByDesc("created_at")->get()),
        ], 'Data Berhasil Diambil');
    }
    public function show($id)
    {
        $berita = BeritaModel::find($id);

        if (!$berita) {
            return ResponseHelper::error('Berita tidak ditemukan', 404);
        }

        return ResponseHelper::success([
            'berita' => new BeritaResource($berita),
        ], 'Detail berita berhasil diambil');
    }
}
