<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasyarakatModel;
use App\Models\KartuKeluargaModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use ResponseHelper;

class ProfileControllerApi extends Controller
{
    public function ubhEmail(Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
            'email' => 'required|email|unique:users,email',
        ]);

        // Cari user melalui relasi masyarakat
        $user = User::whereHas('masyarakat', function ($query) use ($request) {
            $query->where('nik', $request->nik);
        })->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan.',
            ], 404);
        }

        // Update email
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Email berhasil diubah.',
            'user' => $user->load('masyarakat'), // ikutkan relasi
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    public function ubhNoHp(Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
            'no_hp' => 'required|string',
        ]);

        // Cari user melalui relasi masyarakat
        $user = User::whereHas('masyarakat', function ($query) use ($request) {
            $query->where('nik', $request->nik);
        })->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan.',
            ], 404);
        }


        $user->no_hp = $request->no_hp;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Nomor HP berhasil diubah.',
            'user' => $user->load('masyarakat'), // ikutkan relasi
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }


    public function ubhPass(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:16',
            'password' => 'required|string',
            'newPass' => 'required|string',
            'confPass' => 'required|string',
        ]);

        // Cari user melalui relasi masyarakat
        $user = User::whereHas('masyarakat', function ($query) use ($request) {
            $query->where('nik', $request->nik);
        })->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan.',
            ], 404);
        }


        $user->password = $request->newPass;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diubah.',
            'user' => $user->load('masyarakat'), // ikutkan relasi
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }
    public function updatektpgambar(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png',
            'nik' => 'required',
        ]);

        $data = MasyarakatModel::where('nik', $request->nik)->firstOrFail();

        // Hapus gambar lama jika ada
        if ($data->ktp_gambar) {
            $oldImagePath = storage_path('app/private/' . $data->ktp_gambar);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Simpan gambar baru
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'ktp/' . $filename;

            $file->storeAs('ktp', $filename, ['disk' => 'private']);

            // Simpan path dengan folder ktp/
            $data->ktp_gambar = $path;
        }

        $data->save();

        return ResponseHelper::success([
            'nik_gambar' => $data->ktp_gambar,
        ], 'Gambar KTP berhasil diperbarui');
    }


    public function updatekkgambar(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png',
            'no_kk' => 'required',
        ]);

        $data = KartuKeluargaModel::where('no_kk', $request->no_kk)->firstOrFail();

        // Hapus gambar lama jika ada
        if ($data->kk_gambar) {
            $oldImagePath = storage_path('app/private/' . $data->kk_gambar);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Simpan gambar baru
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'kk/' . $filename;

            $file->storeAs('kk', $filename, ['disk' => 'private']);
            $data->kk_gambar = $path;
        }

        $data->save();

        return ResponseHelper::success([
            'kk' => $data,
        ], 'Gambar KK berhasil diperbarui');
    }

    public function profile(Request $request)
    {
        $request->validate([
            'nik' => 'required',
        ]);

        $data = MasyarakatModel::where('nik', $request->nik)->with('kartuKeluarga', 'user')->firstOrFail();
        if ($data->ktp_gambar) {

            $data->ktp_gambar = url("/c/private-image?path=$data->ktp_gambar") ?? $data->ktp_gambar;
        }
        if ($data->kartuKeluarga->kk_gambar) {
            $data->kartuKeluarga->kk_gambar = url("/c/private-image?path=" . $data->kartuKeluarga->kk_gambar) ?? $data->kartuKeluarga->kk_gambar;
            // $data->kartuKeluarga->kk_gambar = url('storage/kk/' . $data->kartuKeluarga->kk_gambar);
        }

        return ResponseHelper::success(
            $data,
            'Detail berita berhasil diambil'
        );
    }
}
