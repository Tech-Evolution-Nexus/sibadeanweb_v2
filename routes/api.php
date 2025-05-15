<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeritaControllerApi;
use App\Http\Controllers\Api\DashboardControllerApi;
use App\Http\Controllers\Api\ImageControllerApi;
use App\Http\Controllers\Api\KartuKeluargaController;
use App\Http\Controllers\Api\PengajuanController;
use App\Http\Controllers\Api\PengajuanControllerApi;
use App\Http\Controllers\Api\PengajuanMasyarakatController;
use App\Http\Controllers\Api\SuratControllerApi;
use App\Http\Controllers\Api\ProfileControllerApi;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    try {
        Mail::raw('Ini adalah email uji coba dari Laravel.', function ($message) {
            $message->to('idvar12@gmail.com')
                ->subject('Tes Email Laravel');
        });

        return 'Email berhasil dikirim!';
    } catch (\Exception $e) {
        return 'Gagal mengirim email: ' . $e->getMessage();
    }
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verifikasi', [AuthController::class, 'verifikasi']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/aktivasi', [AuthController::class, 'activateAccount']);


Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/ajukan-surat', [PengajuanControllerApi::class, 'store']);
    Route::get('/profile', [ProfileControllerApi::class, 'profile']);
    Route::post('/updategambarkk', [ProfileControllerApi::class, 'updatekkgambar']);
    Route::post('/updategambarktp', [ProfileControllerApi::class, 'updatektpgambar']);
Route::get('/verifikasi',[AuthController::class,'getVerifikasiMasyarakat']);
Route::post('/verifikasi/{idUser}',[AuthController::class,'postVerifikasiMasyarakat']);
Route::get('/verifikasi/{idUser}',[AuthController::class,'verifikasiDetailMasyarakat']);
    // Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getUserData']);
    Route::get('/riwayat-pengajuan', [PengajuanController::class, 'getRiwayat']);
    Route::get('/riwayat-pengajuan-detail/{idPengajuan}', [PengajuanController::class, 'getRiwayatDetail']);
    Route::get('/riwayat-pengajuan-masyarakat', [PengajuanMasyarakatController::class, 'getRiwayat']);
    Route::post('/riwayat-pengajuan-masyarakat/{idPengajuan}', [PengajuanMasyarakatController::class, 'updateStatus']);
    Route::get('/riwayat-pengajuan/{idPengajuan}/download', [PengajuanController::class, 'download']);
    Route::get('/anggota-keluarga/{nokk}', [KartuKeluargaController::class, 'getAnggotaKeluarga']);
    Route::get('/user', [AuthController::class, 'getUserData']);
    Route::get('/dash', [DashboardControllerApi::class, 'index']);
    Route::get('/surat', [SuratControllerApi::class, 'index']);
    Route::get('/surat/{id}', [SuratControllerApi::class, 'detail']);
    Route::apiResource('/berita', BeritaControllerApi::class)->only('index', 'show');

    Route::get('/detail-pengajuan/{id}', [PengajuanController::class, 'getDetailPengajuan']);

    Route::get('/ubhemail', [ProfileControllerApi::class, 'ubhEmail']);
    Route::post('/ubhPass', [ProfileControllerApi::class, 'ubhPass']);
});
