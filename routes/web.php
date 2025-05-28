<?php

use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\API\ProfileControllerApi;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\admin\SuratPengantarController;
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
use App\Http\Controllers\Api\SuraKeluarController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\UserController;
use App\Imports\MasyarakatImport;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


Route::get('/', [LandingController::class, "home"]);
Route::get('/berita', [LandingController::class, "berita"]);
Route::get('/berita/{slug}', [LandingController::class, "detailBerita"]);
Route::get('/c/private-image', function () {
    $pathToFile = Storage::disk('private')->path(request()->path);
    if (file_exists($pathToFile)) {
        $fileExtension = pathinfo($pathToFile, PATHINFO_EXTENSION);
        if ($fileExtension === 'pdf') {
            return response()->file($pathToFile, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Pratinjau Surat Keluar"',
            ]);
        }
        return response()->file($pathToFile);
    }
    abort(404);
})->name("private.image");
Route::post("testimoni/store", function () {})->name("testimoni.store");
Route::get('/pengajuan-surat/export', [PengajuanSuratController::class, 'export'])->name("pengajuan-surat.export");


Route::prefix("/c/admin")->middleware("auth")->group(function () {
    Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard');

    //role admin
    Route::middleware(["roleAkses:admin"])->group(function () {
        Route::resource("/surat", SuratController::class);
        Route::resource("/faq", FaqController::class);
        Route::resource("/kartu-keluarga", KartuKeluargaController::class);
        Route::resource("/kartu-keluarga/{no_kk}/anggota-keluarga", AnggotaKeluargaController::class);
        Route::resource("/berita", BeritaController::class);
        Route::resource("/users", UserController::class);
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
        Route::get("/format-surat", [FormatSuratController::class, "index"])->name("format-surat.index");
        Route::get("/format-surat/{id}/edit", [FormatSuratController::class, "edit"])->name("format-surat.edit");
        Route::put("/format-surat/{id}", [FormatSuratController::class, "update"])->name("format-surat.update");
        Route::resource("/petugas", PetugasController::class);
        Route::resource("/lampiran", LampiranController::class);
        Route::resource("/setting", PengaturanController::class);
        Route::get("/tentang", [TentangController::class, 'index'])->name('tentang.index');
        Route::post("/tentang/{id}", [TentangController::class, 'update'])->name('tentang.update');
        Route::post("/masyarakat/import", function () {
            try {
                request()->validate([
                    'importFile' => 'required|file|mimes:xls,xlsx'
                ]);
                Excel::import(new MasyarakatImport, request()->file('importFile'));
                return back()->with('success', 'Import berhasil.');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengimpor: ' . $e->getMessage());
            }
        })->name("import.masyarakat");
    });


    // role admin dan lurah
    Route::get("/pengajuan-surat", [PengajuanSuratController::class, "index"])->name("pengajuan-surat.index");
    Route::get("/pengajuan-surat/{id}", [PengajuanSuratController::class, "show"])->name("pengajuan-surat.show");
    Route::post("/pengajuan-surat/{id}", [PengajuanSuratController::class, "updateStatus"])->name("pengajuan-surat.update");
    Route::get("/pengajuan-surat/{id}/download", [PengajuanSuratController::class, "download"])->name("pengajuan-surat.download");
    Route::get('/surat-keluar/download/{filename}', [SuraKeluarController::class, 'download'])->name('surat-keluar.download');
    Route::resource("/surat-keluar", SuraKeluarController::class);
    Route::resource("/rw", RWController::class);
    Route::resource("/rw/{rw}/rt", RTController::class);



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/ttd', [ProfileController::class, 'updateTTD'])->name('profile.ttd');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/surat-pengantar/{id}', [SuratPengantarController::class, 'show']);

Route::post("/ckeditor-upload-image", function () {
    if (request()->hasFile('upload')) {
        $file = request()->file('upload');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->move(public_path('assets/images'), $filename);

        // URL relative ke public folder
        $url = asset('assets/images/' . $filename);

        return response()->json([
            'url' => $url
        ]);
    }

    return response()->json(['error' => 'No file uploaded'], 400);
});
require __DIR__ . '/auth.php';
