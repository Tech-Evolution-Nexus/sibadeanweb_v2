<?php

namespace App\Http\Controllers\API;

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
        try {
            $validatedData = $request->validate([
                'nik' => 'required|string',
                'email' => 'required|string|email',
            ], [
                'nik.required' => 'NIK tidak ada.',
                'nik.string' => 'Harus berupa angka.',
                'email.required' => 'E-mail tidak boleh kosong.',
                'email.string' => 'E-mail tidak boleh kosong.',
                'email.email' => 'Format E-Mail tidak valid.',
            ]);

            return ResponseHelper::success([
                'nik_gambar' => null,
            ], 'Detail berita berhasil diambil');
        } catch (ValidationException $e) {
            return ResponseHelper::error('Berita tidak ditemukan', 404);
        }
    }

    public function ubhNoHp(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required|string',
            // 'noHp' => 'required|digits_between:12,13',
            'no_kitap' => 'required|digits_between:12,13',
        ], [
            'nik.required' => 'NIK tidak ada.',
            'nik.string' => 'Harus berupa angka',
            // 'noHp.required' => 'Nomor HP tidak boleh kosong.',
            // 'noHp.digits_between' => 'Nomor HP harus berupa angka.',
            'no_kitap.required' => 'Nomor HP tidak boleh kosong.',
            'no_kitap.digits_between' => 'Nomor HP harus berupa angka.',
        ]);

        return response()->json([
            'message' => 'Berhasil ubah Nomor HP!',
            'data' => $data = [null],
        ], 200);
    }


    public function ubhPass(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required|string|max:16',
            'password' => 'required|string',
            'newPass' => 'required|string',
            'confPass' => 'required|string',

        ], [
            'nik.required' => 'NIK tidak ada.',
            'nik.string' => 'Harus berupa angka',
            'password.required' => 'Password tidak boleh kosong.',
            'password.string' => 'Password tidak simbol.',
            'password.min' => 'Password minimal 6 karakter.',
            'newPass.required' => 'Password tidak boleh kosong.',
            'newPass.string' => 'Password tidak simbol.',
            'newPass.min' => 'Password minimal 6 karakter.',
            'confPass.required' => 'Password tidak boleh kosong.',
            'confPass.string' => 'Password tidak simbol.',
            'confPass.min' => 'Password minimal 6 karakter.',

        ]);

        return response()->json([
            'message' => 'Berhasil ubah password!',
            'data' => $data = [null],
        ], 200);
    }
    public function updatektpgambar(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png',
            'nik' => 'required',

        ]);


        $data = MasyarakatModel::where('nik', $request->nik)->firstOrFail();

        // Validasi

        // Cek apakah ada gambar yang di-upload
        if ($request->hasFile('file')) {
            // Hapus gambar lama jika ada
            if ($data->ktp_gambar && Storage::exists('ktp/' . $data->ktp_gambar)) {
                Storage::delete('ktp/' . $data->ktp_gambar);
            }

            // Simpan gambar baru
            $imageName = time() . '.' . $request->file->extension();
            $request->file->storeAs('ktp', $imageName);

            // Update nama gambar di database
            $data->ktp_gambar = $imageName;
        }

        $data->save();
        return ResponseHelper::success([
            'nik_gambar' => null,
        ], 'Detail berita berhasil diambil');
    }
    public function updatekkgambar(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png',
            'no_kk' => 'required',
        ]);
        $data = KartuKeluargaModel::where('no_kk', $request->no_kk)->firstOrFail();


        // Validasi


        // Cek apakah ada gambar yang di-upload
        if ($request->hasFile('file')) {
            // Hapus gambar lama jika ada
            if ($data->kk_gambar && Storage::exists('kk/' . $data->kk_gambar)) {
                Storage::delete('kk/' . $data->kk_gambar);
            }

            // Simpan gambar baru
            $imageName = time() . '.' . $request->file->extension();
            $request->file->storeAs('kk', $imageName);

            // Update nama gambar di database
            $data->kk_gambar = $imageName;
        }


        $data->save();
        return ResponseHelper::success([
            'nik_gambar' => null,
        ], 'Detail berita berhasil diambil');
    }
    public function profile(Request $request)
    {
        $request->validate([
            'nik' => 'required',
        ]);

        $data = MasyarakatModel::where('nik', $request->nik)->with('kartuKeluarga', 'user')->firstOrFail();
        return ResponseHelper::success(
            $data,
            'Detail berita berhasil diambil'
        );
    }
}
