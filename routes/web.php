<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use App\Models\PengaturanModel;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix("/c/admin")->middleware("auth")->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::resource("/surat", SuratController::class);
    Route::resource("/kartu-keluarga", KartuKeluargaController::class);
    Route::resource("/berita", BeritaController::class);
    Route::resource("/users", UserController::class);
    Route::resource("/pengajuan-surat", PengajuanSuratController::class);
    Route::resource("/setting", PengaturanController::class);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
