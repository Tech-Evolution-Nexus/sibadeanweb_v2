<?php

use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FormatSuratController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\LampiranController;
use App\Http\Controllers\LampiranSuratController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\PengajuanSuratRtController;
use App\Http\Controllers\PengajuanSuratSelesai;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RTController;
use App\Http\Controllers\RWController;
use App\Http\Controllers\SuraKeluarController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [LandingController::class, "home"]);
Route::get('/berita', [LandingController::class, "berita"]);
Route::get('/berita/{slug}', [LandingController::class, "detailBerita"]);
Route::get('/c/private-image', function () {
    $pathToFile = Storage::disk('private')->path(request()->path);

    // Cek apakah file ada
    if (file_exists($pathToFile)) {
        // Ambil ekstensi file
        $fileExtension = pathinfo($pathToFile, PATHINFO_EXTENSION);

        // Jika file ekstensi .pdf, gunakan Content-Type untuk PDF
        if ($fileExtension === 'pdf') {
            return response()->file($pathToFile, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Pratinjau Surat Keluar"',
            ]);
        }

        // Jika bukan PDF, Anda bisa menambahkan jenis file lainnya jika perlu
        return response()->file($pathToFile);
    }

    // Jika file tidak ditemukan, kembalikan error 404
    abort(404);
});
Route::post("testimoni/store", function () {})->name("testimoni.store");


Route::prefix("/c/admin")->middleware("auth")->group(function () {
    Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard');
    Route::resource("/surat", SuratController::class);
    Route::resource("/faq", FaqController::class);
    Route::resource("/kartu-keluarga", KartuKeluargaController::class);
    Route::resource("/kartu-keluarga/{no_kk}/anggota-keluarga", AnggotaKeluargaController::class);
    Route::resource("/berita", BeritaController::class);
    Route::resource("/users", UserController::class);
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get("/pengajuan-surat", [PengajuanSuratController::class, "index"])->name("pengajuan-surat.index");
    Route::get("/pengajuan-surat/{id}", [PengajuanSuratController::class, "show"])->name("pengajuan-surat.show");
    Route::post("/pengajuan-surat/{id}", [PengajuanSuratController::class, "updateStatus"])->name("pengajuan-surat.update");
    Route::get("/pengajuan-surat/{id}/download", [PengajuanSuratController::class, "download"])->name("pengajuan-surat.download");
    // Route::get("/pengajuan-surat-rt", [PengajuanSuratRtController::class, "index"])->name("pengajuan-surat-rt.index");
    // Route::get("/pengajuan-surat-selesai", [PengajuanSuratSelesai::class, "index"])->name("pengajuan-surat-selesai.index");
    // Route::get("/pengajuan-surat-selesai/{id}", [PengajuanSuratSelesai::class, "show"])->name("pengajuan-surat-selesai.show");


    // Route::get("/surat-keluar", [SuraKeluarController::class, "index"])->name("surat-keluar.index");
    Route::get('/surat-keluar/download/{filename}', [SuraKeluarController::class, 'download'])->name('surat-keluar.download');

    Route::get("/format-surat", [FormatSuratController::class, "index"])->name("format-surat.index");
    Route::get("/format-surat/{id}/edit", [FormatSuratController::class, "edit"])->name("format-surat.edit");
    Route::put("/format-surat/{id}", [FormatSuratController::class, "update"])->name("format-surat.update");

    Route::resource("/surat-keluar", SuraKeluarController::class);
    Route::resource("/petugas", PetugasController::class);

    Route::resource("/lampiran", LampiranController::class);

    Route::resource("/setting", PengaturanController::class);
    Route::resource("/rw", RWController::class);
    Route::resource("/rw/{rw}/rt", RTController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::resource("/setting", TentangController::class);
});


require __DIR__ . '/auth.php';
