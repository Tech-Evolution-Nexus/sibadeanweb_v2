<?php

use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RTController;
use App\Http\Controllers\RWController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use App\Models\PengaturanModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $pengaturan = PengaturanModel::first();
    $fitur = [
        (object)[
            "nama" => "Kecepatan Penyetujuan Surat",
            "deskripsi" => "Proses persetujuan surat lebih cepat dengan sistem otomatis yang efisien.",
            "icon" => "approval.webp"
        ],
        (object)[
            "nama" => "Lacak Surat Secara Real-Time",
            "deskripsi" => "Pantau status surat Anda dari pengajuan hingga diterima dengan transparansi penuh.",
            "icon" => "letter-animate.webp"
        ],
        (object)[
            "nama" => "Keamanan Data Terjamin",
            "deskripsi" => "Setiap surat terenkripsi dengan standar keamanan tinggi untuk menjaga kerahasiaan dokumen.",
            "icon" => "secure.webp"
        ],
        (object)[
            "nama" => "Akses dari Mana Saja",
            "deskripsi" => "Kelola dan akses surat kapan saja, di perangkat apa pun dengan sistem berbasis cloud.",
            "icon" => "cloud.webp"
        ],
    ];
    $testimoni = [
        (object)[
            "pesan" => "Aplikasi ini sangat membantu pekerjaan saya! Proses pembuatan dan pengiriman surat jadi jauh lebih cepat dan praktis.",
            "nama" => "- Budi, HR Manager"
        ],
        (object)[
            "pesan" => "Saya tidak perlu lagi bolak-balik ke kantor kelurahan.
                    Semua bisa dilakukan dari rumah!",
            "nama" => "- Siti, Warga"
        ],
        (object)[
            "pesan" => "Proses surat menyurat jadi lebih efisien.
                    Aplikasi ini sangat membantu!",
            "nama" => "- Pak Rahmat, Petugas Kelurahan"
        ],
    ];
    $faq = [
        (object)[
            "pertanyaan" => "Bagaimana cara mengajukan surat?",
            "jawaban" => "Anda dapat mengajukan surat secara online melalui aplikasi ini dengan mengisi formulir dan mengunggah dokumen yang diperlukan."
        ],
        (object)[
            "pertanyaan" => "Berapa lama proses persetujuan?",
            "jawaban" => "Waktu persetujuan bergantung pada jenis surat. Biasanya proses memakan waktu 1-2 hari kerja."
        ],
    ];
    return view('welcome', compact("pengaturan", "fitur", "testimoni", "faq"));
});
Route::get('/c/private-image', function () {
    $pathToFile = Storage::disk('private')->path(request()->path);
    return file_exists($pathToFile) ? response()->file($pathToFile) : false;
});
Route::post("testimoni/store", function () {})->name("testimoni.store");


Route::prefix("/c/admin")->middleware("auth")->group(function () {
    Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard');
    Route::resource("/surat", SuratController::class);
    Route::resource("/kartu-keluarga", KartuKeluargaController::class);
    Route::resource("/kartu-keluarga/{no_kk}/anggota-keluarga", AnggotaKeluargaController::class);
    Route::resource("/berita", BeritaController::class);
    Route::resource("/users", UserController::class);
    Route::get("/pengajuan-surat", [PengajuanSuratController::class, "index"])->name("pengajuan-surat.index");
    Route::post("/pengajuan-surat/{id}", [PengajuanSuratController::class, "updateStatus"])->name("pengajuan-surat.update");

    Route::resource("/setting", PengaturanController::class);
    Route::resource("/rw", RWController::class);
    Route::resource("/rw/{rw}/rt", RTController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
