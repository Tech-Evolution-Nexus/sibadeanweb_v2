<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasyarakatModel;
use App\Models\KartuKeluargaModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function getUserData()
{
    $nik = request()->nik;
    $user = User::whereHas('masyarakat',function ($qr)use($nik) {
        $qr->where("nik",$nik);
    })->with(["masyarakat","masyarakat.kartuKeluarga"])->first();

    if (!$user) {
        return response()->json(['error' => 'User tidak ditemukan atau belum login'], 401);
    }
    return response()->json($user);
}
public function login(Request $request) {
    Log::info('Login Request Data', $request->all());

    // Validasi input
    $validator = Validator::make($request->all(), [
        "nik" => "required|numeric|digits:16",
        "password" => "required|min:6",
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Cari user berdasarkan NIK melalui tabel masyarakat
    $user = User::whereHas("masyarakat", function ($query) use ($request) {
        $query->where('nik', $request->nik);
    })->with(["masyarakat", "masyarakat.kartuKeluarga"])->first();

    // Jika user tidak ditemukan
    if (!$user) {
        Log::info('User Not Found', ['nik' => $request->nik]);
        return response()->json(['error' => 'NIK tidak ditemukan'], 404);
    }

    // Pastikan masyarakat terkait user ditemukan
    if (!$user->masyarakat) {
        return response()->json(['error' => 'Data masyarakat tidak ditemukan'], 404);
    }

    // Cek apakah akun sudah aktif
    if ($user->status !== 1) { // Cek dengan angka, bukan string
        return response()->json(['error' => 'Akun belum diaktifkan. Silakan aktivasi terlebih dahulu.'], 403);
    }
    
    
    // Cek password
    if (!Hash::check($request->password, $user->password)) {
        Log::info('Password Mismatch', ['input_password' => $request->password, 'hashed_password' => $user->password]);
        return response()->json(['error' => 'Password salah'], 401);
    }

    // Hapus token lama sebelum membuat token baru
    $user->tokens()->delete();
    $token = $user->createToken('auth_token')->plainTextToken;

    // Kembalikan respons dengan data user (tanpa password untuk keamanan)
    return response()->json([
        'message' => 'Login berhasil',
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'masyarakat' => $user->masyarakat
        ]
    ], 200);
}

public function register(Request $request) {
    // Trim spasi di no_kk
    $request->merge([
        "no_kk" => trim($request->no_kk),
    ]);

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
        "kk_gambar" => "required|image|mimes:jpeg,png,jpg|max:2048" // Validasi gambar KK
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Proses unggah file KK
    $kkGambarPath = 'default.jpg'; // Default jika tidak ada file yang diunggah
    if ($request->hasFile('kk_gambar')) {
        $kkGambarPath = $request->file('kk_gambar')->store('kk', 'public');
    }

    // Cek apakah no_kk sudah ada, jika belum, buat baru
    $kk = KartuKeluargaModel::firstOrCreate(
        ['no_kk' => $request->no_kk],
        ['alamat' => $request->alamat, 'rt' => 1, 'rw' => 1, 'kk_gambar' => $kkGambarPath]
    );

    // Buat user baru
    $user = User::create([
        'name' => $request->nama_lengkap,
        'email' => $request->email,
        'password' => Hash::make($request->password),
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

    return response()->json([
        'message' => 'Registrasi berhasil',
        'user' => $user,
        'masyarakat' => $masyarakat,
        'kk' => $kk
    ], 201);
}

public function verifikasi (Request $request){

    // validasi input
    $request ->validate([
        'nik' => 'required|numeric|digits:16',
    ]);

    //mencari data masyarakat berdasarkan masyrakat
  // Cari data masyarakat berdasarkan NIK
  $masyarakat = MasyarakatModel::where('nik', $request->nik)
  ->with('kartuKeluarga') // Jika ingin mengambil data KK
  ->first();

if (!$masyarakat) {
  return response()->json([
      'error' => 'NIK tidak ditemukan'
  ], 404);
}

return response()->json([
  'message' => 'NIK ditemukan',
  'masyarakat' => $masyarakat
], 200);

    }



    public function activateAccount(Request $request)
{
    $validator = Validator::make($request->all(), [
        "nik" => "required|exists:masyarakat,nik",
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => 'NIK tidak ditemukan'], 404);
    }

    $masyarakat = MasyarakatModel::where('nik', $request->nik)->first();

    if (!$masyarakat) {
        return response()->json(['error' => 'NIK tidak ditemukan'], 404);
    }

    // Pastikan user ada sebelum update
    $user = User::where('id', $masyarakat->id_user)->first();

    if (!$user) {
        return response()->json(['error' => 'Akun tidak ditemukan'], 404);
    }

    $user->update(['status' => 1]); // Langsung update status

    return response()->json([
        'message' => 'Akun berhasil diaktifkan!',
        'user' => $user,
    ], 200);
}

}

