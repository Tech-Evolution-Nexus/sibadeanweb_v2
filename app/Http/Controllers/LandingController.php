<?php

namespace App\Http\Controllers;

use App\Models\BeritaModel;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Landing;
use App\Models\PengaturanModel;

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
}
