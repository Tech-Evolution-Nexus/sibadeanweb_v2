<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\MasyarakatModel;
use App\Models\KartuKeluargaModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use ResponseHelper;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function getUserData()
    {
        $nik = request()->nik;
        $user = User::all();
        return response()->json($user);
    }
    public function login(Request $request)
    {
        Log::info('Login Request Data', $request->all());

        // Validasi input
        $validator = Validator::make($request->all(), [
            "nik" => "required|numeric|digits:16",
            "password" => "required|min:6",
        ]);

        // Jika validasi gagal, kembalikan pesan error
        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors()->first(), 422);
        }

        // Cari user berdasarkan NIK melalui tabel masyarakat
        $user = User::whereHas('masyarakat', function ($query) use ($request) {
            $query->where('nik', $request->nik);
        })->with(['masyarakat', 'masyarakat.kartuKeluarga'])->first();

        // Jika user tidak ditemukan, log dan kembalikan error
        if (!$user) {
            Log::warning('User not found with NIK', ['nik' => $request->nik]);
            return ResponseHelper::error('NIK tidak ditemukan', 404);
        }

        // Pastikan masyarakat terkait user ditemukan
        if (!$user->masyarakat) {
            return ResponseHelper::error('Data masyarakat tidak ditemukan', 404);
        }

        // Cek apakah akun sudah aktif (status user = 1)
        if ($user->status !== 1) {
            return ResponseHelper::error('Akun belum diaktifkan. Silakan aktivasi terlebih dahulu.', 403);
        }

        // Verifikasi password
        if (!Hash::check($request->password, $user->password)) {
            Log::warning('Invalid password attempt', ['nik' => $request->nik]); // Jangan log password
            return ResponseHelper::error('Invalid credentials', 401);
        }

        // Hapus token lama sebelum membuat token baru
        $user->tokens()->delete();

        // Membuat token akses baru
        $token = $user->createToken('auth_token')->plainTextToken;
        Auth::login($user);
        // Kembalikan response dengan data user (tanpa password) dan token
        return ResponseHelper::success([
            'user' => [
                'id' => $user->id,
                'name' => $user->masyarakat->nama_lengkap,
                'email' => $user->email,
                'role' => $user->role,
                'masyarakat' => $user->masyarakat
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Login Sukses');
    }


    public function register(Request $request)
    {
        // Trim spasi di no_kk
        $request->merge([
            "no_kk" => trim($request->no_kk),
        ]);

        // Validasi input pengguna
        $validator = Validator::make($request->all(), [
            "nama_lengkap" => "required|string|max:255",
            "nik" => "required|unique:masyarakat,nik",
            "no_kk" => "required|string|max:16",
            "tempat_lahir" => "required|string|max:255",
            "tanggal_lahir" => "required|date",
            "jenis_kelamin" => "required|in:Laki-laki,Perempuan",
            "alamat" => "required|string",
            "pekerjaan" => "required|string",
            "agama" => "required|string",
            "phone" => "required|numeric",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6",
            "kk_gambar" => "required|image|mimes:jpeg,png,jpg|max:2048", // Validasi gambar KK
            "ktp_gambar" => "required|image|mimes:jpeg,png,jpg|max:2048" // Validasi gambar KTP
        ]);

        // Jika validasi gagal, kembalikan pesan error
        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors()->first(), 422);
        }

        // Proses unggah file KK
        $kkGambarPath = 'default.jpg'; // Default jika tidak ada file yang diunggah
        if ($request->hasFile('kk_gambar')) {
            // Validasi dan simpan file dengan nama aman
            $kkGambarPath = $request->file('kk_gambar')->store('kk', 'public');
        }

        // Cek apakah no_kk sudah ada, jika belum, buat baru
        $kk = KartuKeluargaModel::firstOrCreate(
            ['no_kk' => $request->no_kk],
            [
                'alamat' => $request->alamat,
                'rt' => 1,
                'rw' => 1,
                'kk_gambar' => $kkGambarPath
            ]
        );

        // Buat user baru dengan password yang aman
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            "asal_Data" => "register"
        ]);

        // Buat masyarakat terkait user
        $masyarakat = MasyarakatModel::create([
            "nik" => $request->nik,
            "id_user" => $user->id,
            "no_kk" => $request->no_kk,
            "nama_lengkap" => $request->nama_lengkap,
            "jenis_kelamin" => $request->jenis_kelamin,
            "tempat_lahir" => $request->tempat_lahir,
            "tanggal_lahir" => $request->tanggal_lahir,
            "agama" => $request->agama,
            "pekerjaan" => $request->pekerjaan,
            "alamat" => $request->alamat,
            "phone" => $request->phone,
        ]);

        // Respons berhasil dengan data user, masyarakat, dan kk
        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ],
            'masyarakat' => $masyarakat,
            'kk' => $kk
        ], 201);
    }

    public function verifikasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nik" => "required|numeric|digits:16",
        ]);
        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors()->first(), 422);
        }
        // Cari data masyarakat berdasarkan NIK dan ambil juga data KK (relasi)
        $masyarakat = MasyarakatModel::with('kartuKeluarga')
            ->where('nik', $request->nik)
            ->first();

        // Jika data tidak ditemukan
        if (!$masyarakat) {
            return ResponseHelper::error('NIK tidak ditemukan', 404);
        }

        // Jika ditemukan, kembalikan data masyarakat
        return ResponseHelper::success([
            'masyarakat' => $masyarakat,
        ], "Nik Ditemukan", 200);
    }



    public function activateAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|exists:masyarakat,nik',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors()->first(), 422);
        }

        // Cari data masyarakat berdasarkan NIK
        $masyarakat = MasyarakatModel::where('nik', $request->nik)->first();

        if (!$masyarakat) {
            return ResponseHelper::error('NIK tidakd ditemukan', 404);
        }

        // Cari user berdasarkan id_user dari masyarakat
        $user = User::find($masyarakat->id_user);

        if (!$user) {
            return ResponseHelper::error('User tidak ditemukan', 404);
        }

        $user->update([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1,
        ]);
        $user->makeHidden(['password']);
        return response()->json([
            'message' => 'Akun berhasil diaktifkan!',
            'user' => $user,
        ], 200);
    }


    public function logout(Request $request)
    {
        // Hapus token dari user yang sedang login
        $request->user()->currentAccessToken()->delete();
        return ResponseHelper::success(null, 'Berhasil logout', 200);
    }



    public function forgotPassword(Request $request)
    {
        // Validasi email yang dimasukkan
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors()->first(), 422);
        }

        // Mengirimkan link reset password ke email pengguna
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Menangani jika email tidak ditemukan
        if ($status == Password::RESET_LINK_SENT) {
            return ResponseHelper::success(null, 'Link reset password telah dikirim ke email Anda', 200);
        } else {
            return ResponseHelper::error('Terjadi kesalahan, email tidak ditemukan', 404);
        }
    }


    public function resetPassword(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors()->first(), 422);
        }

        // Proses reset password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return ResponseHelper::success(null, 'Password berhasil diubah', 200);
        } else {
            return ResponseHelper::error('Terjadi kesalahan saat reset password', 500);
        }
    }

    public function getVerifikasiMasyarakat()
    {
        $kartuKeluarga = auth()->user()->masyarakat->kartuKeluarga;
        $verifikasiMenunggu = MasyarakatModel::whereHas('kartuKeluarga', function ($query) use ($kartuKeluarga) {
            $query->where('rt', $kartuKeluarga->rt)->where('rw', $kartuKeluarga->rw);
        })->whereHas('user', function ($query) {
            $query->where('status', 0);
            $query->where('asal_data', "register");
        })
            ->with(['user', 'kartuKeluarga'])
            ->get();
        $verifikasiSelesai = MasyarakatModel::whereHas('kartuKeluarga', function ($query) use ($kartuKeluarga) {
            $query->where('rt', $kartuKeluarga->rt)->where('rw', $kartuKeluarga->rw);
        })->whereHas('user', function ($query) {
            $query->whereIn('status', [1, -1]);
            $query->where('asal_data', "register");
        })
            ->with(['user', 'kartuKeluarga'])
            ->get();

        $params = [
            "verifikasiMenunggu" => $verifikasiMenunggu,
            "verifikasiSelesai" => $verifikasiSelesai,
        ];
        return ResponseHelper::success($params);
    }
    public function postVerifikasiMasyarakat($idUser)
    {
        User::find($idUser)->update(['status' => request('status')]);
        return ResponseHelper::success([]);
    }
    public function verifikasiDetailMasyarakat($idUser)
    {
        $masyarakat = MasyarakatModel::where("id_user", $idUser)
            // ->with(['user', 'kartuKeluarga'])
            ->first();
        return ResponseHelper::success($masyarakat);
    }
    public function cekuser(Request $request)
    {
        $user = $request->user();
        return ResponseHelper::success([
            'user' => [
                'id' => $user->id,
                'name' => $user->masyarakat->nama_lengkap,
                'email' => $user->email,
                'role' => $user->role,
                'masyarakat' => $user->masyarakat
            ]
        ], 'Login Sukses');
        // return ResponseHelper::success($user);
    }
}
