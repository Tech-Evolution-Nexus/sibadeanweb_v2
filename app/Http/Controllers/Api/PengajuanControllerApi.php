<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\NotificationHelper;
use App\Http\Resources\BeritaResource;
use App\Http\Resources\SuratResource;
use App\Models\BeritaModel;
use App\Models\FieldValue;
use App\Models\HistoriPengajuan;
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

        // 2. Ambil data masyarakat dan role
        $data = MasyarakatModel::where('nik', $request->nik)->with('user')->firstOrFail();
        $userRole = $data->user->role;

        // 3. Simpan file pengantar jika ada
        $pengantarPath = null;
        if ($request->hasFile('pengantar_rt')) {
            $pengantarPath = $request->file('pengantar_rt')->store('pengantar_rt', 'public');
        }

        $dataRt = $data->kartuKeluarga->rt ?? null;
        $dataRw = $data->kartuKeluarga->rw ?? null;

        // 4. Tentukan status berdasarkan role dan pengantar


        if ($userRole === 'masyarakat' || $userRole === 'rw') {
            $status = $pengantarPath ? 'di_terima_rt' : 'pending';

            if ($pengantarPath) {
                // kalau ada pengantar, cari berdasarkan RT & role rt
                $data2 = $this->getKartuKeluargaByRoleAndField('rw', $dataRw, 'rw');
            } else {
                // kalau gak ada pengantar, cari berdasarkan RW & role rw
                $data2 = $this->getKartuKeluargaByRoleAndField('rt', $dataRt, 'rt');
            }
        } elseif ($userRole === 'rt') {
            $status = 'di_terima_rt';
            // rt selalu cari berdasarkan RW & role rw
            $data2 = $this->getKartuKeluargaByRoleAndField('rw', $dataRw, 'rw');
        } else {
            return response()->json([
                'message' => 'Role tidak ditemukan'
            ], 404);
        }


        HistoriPengajuan::create([
            "id_pengajuan" => null,
            "id_petugas" => auth()->user()->id,
            "status_pengajuan" => $status
        ]);
        // 5. Simpan data pengajuan surat
        $pengajuan = PengajuanSuratModel::create([
            'nik' => $request->nik,
            'id_surat' => $request->id_surat,
            'keterangan' => $request->keterangan,
            'pengantar_rt' => $pengantarPath,
            'status' => $status,
        ]);

        // 6. Simpan field dinamis jika ada
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

        // 7. Simpan lampiran file jika ada
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
        if ($data2) {
            NotificationHelper::sendFcm($data2->user->fcm_token, 'Pengajuan Baru', 'Ada pengajuan surat baru yang masuk.');
        }


        // 9. Response
        return response()->json([
            'message' => 'Pengajuan berhasil disimpan.',
            'data' => $pengajuan
        ], 201);
    }
    function getKartuKeluargaByRoleAndField($field, $value, $role)
    {
        return KartuKeluargaModel::where($field, $value)
            ->whereHas('masyarakat.user', function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->with('masyarakat.user')
            ->first();
    }
}
