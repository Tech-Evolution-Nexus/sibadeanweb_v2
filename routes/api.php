<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardControllerApi;
use App\Http\Controllers\API\SuratControllerApi;
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
// Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getUserData']);
Route::get('/user', [AuthController::class, 'getUserData']);
Route::get('/dash', [DashboardControllerApi::class, 'index']);
Route::get('/surat', [SuratControllerApi::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
