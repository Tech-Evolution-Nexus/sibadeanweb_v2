<?php

namespace App\Http\Controllers;

use App\Models\BeritaModel;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Landing;
use App\Models\PengaturanModel;
use Illuminate\Support\Facades\Storage;

class LandingController extends Controller
{
    public function home()
    {
        $pengaturan = PengaturanModel::first();
        $landing = Landing::first();
        $fitur = $landing->fiturUtama()->select("title as judul", "description as deskripsi", "icon")->get();
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
        $faq = Faq::select("question as pertanyaan", "answer as jawaban")->get();
        return view('home', compact("pengaturan", "fitur", "testimoni", "faq", "landing"));
    }

    public function berita()
    {
        $berita = BeritaModel::orderBy("id", "desc")->paginate(9);
        return view("berita", compact("berita"));
    }
    public function detailBerita($slug)
    {
        $berita = BeritaModel::where("slug", $slug)->first();
        $beritaTerbaru = BeritaModel::orderBy("id", "Desc")->whereNot("slug", $slug)->limit(5)->get();
        if (!$berita) return abort(404);
        return view("detail_berita", compact("berita", "beritaTerbaru"));
    }
    public function downloadApp()
    {
        $landing = Landing::first(); // atau berdasarkan ID jika perlu

        if (!$landing || !$landing->mobile_link) {
            return redirect()->back()->with('error', 'Aplikasi tidak tersedia.');
        }

        if ($landing->app_type === 'custom') {
            // Redirect ke URL custom
            return redirect()->away($landing->mobile_link);
        }

        // Jika tipe upload → ambil dari storage/public
        $filePath = str_replace('storage/', '', $landing->mobile_link);

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File aplikasi tidak ditemukan.');
        }

        $fileName = basename($filePath);
        $mime = Storage::disk('public')->mimeType($filePath);

        return response()->download(storage_path('app/public/' . $filePath), $fileName, [
            'Content-Type' => $mime,
        ]);
    }
}
