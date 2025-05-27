<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuratResource;
use Illuminate\Http\Request;
use App\Models\SuratModel;
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

    public function masukRt(Request $request)
    {
        $user = $request->user(); // RT yang login

        // Validasi: hanya RT boleh akses
        if (!$user || $user->role !== 'rt') {
            return ResponseHelper::error('Akses ditolak', 403);
        }

        // Ambil surat yang diajukan ke RT tersebut dan masih pending
        $surats = SuratModel::with('user')
            ->where('rt_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return ResponseHelper::success([
            'surat' => SuratResource::collection($surats)
        ], 'Surat masuk berhasil diambil');
    }

    public function acc($id, Request $request)
    {
        $surat = SuratModel::findOrFail($id);

        // Pastikan RT yang sesuai
        if ($request->user()->id !== $surat->rt_id) {
            return ResponseHelper::error('Akses ditolak', 403);
        }

        $surat->status = 'disetujui';
        $surat->save();

        return ResponseHelper::success([], 'Surat berhasil disetujui');
    }

    public function tolak($id, Request $request)
    {
        $surat = SuratModel::findOrFail($id);

        if ($request->user()->id !== $surat->rt_id) {
            return ResponseHelper::error('Akses ditolak', 403);
        }

        $surat->status = 'ditolak';
        $surat->save();

        return ResponseHelper::success([], 'Surat berhasil ditolak');
    }

}
