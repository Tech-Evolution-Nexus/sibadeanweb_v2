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
        //  return response()->json($request->all());
        // 1. Validasi dasar
        $request->validate([
            'nik' => 'required|string|exists:masyarakat,nik',
            'id_surat' => 'required|integer',
            'keterangan' => 'nullable|string',
            'pengantar_rt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // 2. Ambil data masyarakat beserta user
        $data = MasyarakatModel::where('nik', $request->nik)->with(['user', 'kartuKeluarga'])->first();
        if (!$data || !$data->user) {
            return response()->json(['message' => 'Data masyarakat atau user tidak ditemukan.'], 404);
        }

        $userRole = $data->user->role;
        $dataRt = $data->kartuKeluarga->rt ?? null;
        $dataRw = $data->kartuKeluarga->rw ?? null;

        // 3. Simpan file pengantar jika ada
        $pengantarPath = null;
        if ($request->hasFile('pengantar_rt')) {
            $pengantarPath = $request->file('pengantar_rt')->store('pengantar_rt', 'private');
        }

        // 4. Tentukan status & cari petugas penerima
        if ($userRole === 'masyarakat' || $userRole === 'rw') {
            $status = $pengantarPath ? 'di_terima_rt' : 'pending';

            // cari KK yang rt & rw sama, dan user-nya role = 'rt'
            $data2 = KartuKeluargaModel::where('rt', $dataRt)
                ->where('rw', $dataRw)
                ->whereHas('masyarakat.user', function ($query) {
                    $query->where('role', 'rt');
                })
                ->with(['masyarakat' => function ($query) {
                    $query->whereHas('user', function ($q) {
                        $q->where('role', 'rt');
                    });
                }, 'masyarakat.user'])
                ->first();
        } elseif ($userRole === 'rt') {
            $status = 'di_terima_rt';

            $data2 = KartuKeluargaModel::where('rw', $dataRw)
                ->whereHas('masyarakat.user', function ($query) {
                    $query->where('role', 'rw');
                })
                ->with('masyarakat.user')
                ->first();
        } else {
            return response()->json(['message' => 'Role tidak dikenali.'], 403);
        }
        // return response()->json(

        //     $data2->masyarakat->first(),
        //     200
        // );

        // 5. Simpan data pengajuan surat
        $pengajuan = PengajuanSuratModel::create([
            'nik' => $request->nik,
            'id_surat' => $request->id_surat,
            'keterangan' => $request->keterangan,
            'pengantar_rt' => $pengantarPath,
            'nik_pengaju' => auth()->user()->masyarakat->nik,
            'status' => $status,
        ]);

        // 6. Simpan histori pengajuan
        HistoriPengajuan::create([
            "id_pengajuan" => $pengajuan->id,
            "id_petugas" => auth()->user()->masyarakat->nik ?? auth()->user()->nik,
            "status_pengajuan" => $status
        ]);

        // 7. Simpan field dinamis jika ada
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

        // 8. Simpan lampiran file jika ada
        foreach ($request->allFiles() as $key => $file) {
            if (str_starts_with($key, 'lampiran_')) {
                $idLampiran = (int) str_replace('lampiran_', '', $key);
                $path = $file->store('lampiran_surat', 'private');

                LampiranPengajuanModel::create([
                    'id_pengajuan' => $pengajuan->id,
                    'id_lampiran' => $idLampiran,
                    'gambar' => $path,
                ]);
            }
        }

        // 9. Kirim notifikasi jika data2 tersedia
        if ($data2 && $data2->masyarakat->first()->user && $data2->masyarakat->first()->user->fcm_token) {
            NotificationHelper::sendFcm(
                $data2->masyarakat->first()->user->fcm_token,
                'Pengajuan Surat Baru',
                'Ada pengajuan surat baru yang masuk. Silahkan cek di aplikasi.'
            );
        }

        // 10. Response sukses
        return response()->json([
            'message' => 'Pengajuan berhasil disimpan.',
            'data' => $pengajuan
        ], 200);
    }

    function getKartuKeluargaByRoleAndField($field, $value, $role)
    {
        $kk = KartuKeluargaModel::where($field, $value)
            ->whereHas('masyarakat.user', function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->with(['masyarakat.user'])
            ->first();

        if ($kk) {
            // Filter masyarakat berdasarkan role
            $kk->masyarakat = $kk->masyarakat->filter(function ($masyarakat) use ($role) {
                return $masyarakat->user && $masyarakat->user->role === $role;
            })->values()->take(1); // ambil hanya 1 orang
        }

        return $kk;
    }
}
