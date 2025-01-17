<?php

use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RWController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/c/private-image', function () {
    $pathToFile = Storage::disk('private')->path(request()->path);
    return file_exists($pathToFile) ? response()->file($pathToFile) : false;
});



Route::prefix("/c/admin")->middleware("auth")->group(function () {
    Route::get('/dashboard', [DashboardController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');
    Route::resource("/surat", SuratController::class);
    Route::resource("/kartu-keluarga", KartuKeluargaController::class);
    Route::resource("/kartu-keluarga/{no_kk}/anggota-keluarga", AnggotaKeluargaController::class);
    Route::resource("/berita", BeritaController::class);
    Route::resource("/users", UserController::class);
    Route::resource("/pengajuan-surat", PengajuanSuratController::class);
    Route::resource("/setting", PengaturanController::class);
    Route::resource("/rw", RWController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
