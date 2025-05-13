<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BeritaResource;
use App\Http\Resources\SuratResource;
use App\Models\BeritaModel;
use App\Models\FieldValue;
use App\Models\LampiranPengajuanModel;
use App\Models\PengajuanSuratModel;
use Illuminate\Http\Request;
use App\Models\MasyarakatModel;
use App\Models\KartuKeluargaModel;
use App\Models\SuratModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use ResponseHelper;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class PengajuanControllerApi extends Controller
{
    public function index()
    {
        return ResponseHelper::success([
            'pengajuan' => BeritaResource::collection(PengajuanSuratModel::get()),
        ], 'Data Berhasil Diambil');
    }

    public function store(Request $request)
    {
        // 1. Validasi dasar
        $request->validate([
            'nik' => 'required|string',
            'id_surat' => 'required|integer',
            'keterangan' => 'nullable|string',
            'pengantar_rt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        // 2. Simpan data pengajuan
        $pengantarPath = null;
        if ($request->hasFile('pengantar_rt')) {
            $pengantarPath = $request->file('pengantar_rt')->store('pengantar_rt', 'public');
            $pengajuan = PengajuanSuratModel::create([
                'nik' => $request->nik,
                'id_surat' => $request->id_surat,
                'keterangan' => $request->keterangan,
                'pengantar_rt' => $pengantarPath,
                'status' => 'di_terima_rt', // default status
            ]);
        } else {
            $pengajuan = PengajuanSuratModel::create([
                'nik' => $request->nik,
                'id_surat' => $request->id_surat,
                'keterangan' => $request->keterangan,
                'status' => 'pending', // default status
            ]);
        }
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'field_')) {

                $idField = (int) str_replace('field_', '', $key);

                FieldValue::create([
                    'id_field' => $idField,
                    'id_pengajuan' => $pengajuan->id,
                    'value' => $value,
                ]);
            }
        }
        foreach ($request->allFiles() as $key => $file) {
            if (str_starts_with($key, 'lampiran_')) {
                $idLampiran = (int) str_replace('lampiran_', '', $key);
                $path = $file->store('lampiran_surat', 'public');

                LampiranPengajuanModel::create([
                    'id_pengajuan' => $pengajuan->id,
                    'id_lampiran' => $idLampiran,
                    'gambar' => $path,
                ]);
            }
        }
        try {
            $fcmToken = 'elmt0uOhS0O3Ze4EdOcz1N:APA91bFp6dvxMq3JkQV7Ayxtf_dkNPu2OU9545EUPnceG0pSkKmlXBApxtdVC8cgZMQq5juDlHGFHSLcKiRxkxxzsvVsbdUxEO8lj8epG_jkiL0l1__66QY'; // Ambil dari DB atau request jika tersedia

            $factory = (new Factory)->withServiceAccount(base_path('firebase.json'));
            $messaging = $factory->createMessaging();

            $message = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification(Notification::create('Pengajuan Baru', 'Ada pengajuan surat baru yang masuk.'));

            $messaging->send($message);
        } catch (\Throwable $e) {
            // Optional: log error jika notifikasi gagal
            \Log::error('FCM Error: ' . $e->getMessage());
        }
        return response()->json([
            'message' => 'Pengajuan berhasil disimpan.',
            'data' => $pengajuan
        ], 201);
    }
}
