<?php

namespace Database\Seeders;

use App\Models\BeritaModel;
use App\Models\Faq;
use App\Models\FiturUtama;
use App\Models\KartuKeluargaModel;
use App\Models\Landing;
use App\Models\MasyarakatModel;
use App\Models\PengaturanModel;
use App\Models\Petugas;
use App\Models\SuratModel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        SuratModel::factory(10)->create();
        // $result =   MasyarakatModel::factory()->count(10)->create();
        KartuKeluargaModel::factory(20)->create()->each(function ($kartuKeluarga) {
            MasyarakatModel::factory()->create([
                'no_kk' => $kartuKeluarga->no_kk,
                "status_keluarga" => "kk"
            ]);
            MasyarakatModel::factory()->create([
                'no_kk' => $kartuKeluarga->no_kk,
                "status_keluarga" => "istri"
            ]);
            MasyarakatModel::factory()->create([
                'no_kk' => $kartuKeluarga->no_kk,
                "status_keluarga" => "anak"
            ]);
        });

        $landing = Landing::create([
            "hero_title" => "Bikin Surat Lebih Mudah dan Cepat",
            "hero_description" => "Aplikasi pengelolaan surat kelurahan yang memudahkan warga dalam pembuatan dan pengajuan surat secara digital. Hemat waktu, efisien, dan tanpa ribet!",
            "hero_img" => "assets/image/hero.png",
            "about_title" => "Tentang Desa Badean",
            "about_description" => "Desa Badean adalah desa yang terletak di wilayah strategis dengan berbagai potensi sumber daya alam dan budaya. Dengan adanya sistem digitalisasi surat, Desa Badean kini lebih modern dan efisien dalam pelayanan administrasi kepada masyarakat.",
            "about_img" => "assets/image/badean.jpg",
            "demo_url" => "https://www.youtube.com/embed/video_id",
            "mobile_link" => ""
        ]);

        FiturUtama::insert([
            [
                "title" => "Kecepatan Penyetujuan Surat",
                "description" => "Proses persetujuan surat lebih cepat dengan sistem otomatis yang efisien.",
                "icon" => "assets/image/approval.webp",
                "landing_id" => $landing->id
            ],
            [
                "title" => "Lacak Surat Secara Real-Time",
                "description" => "Pantau status surat Anda dari pengajuan hingga diterima dengan transparansi penuh.",
                "icon" => "assets/image/letter-animate.webp",
                "landing_id" => $landing->id
            ],
            [
                "title" => "Keamanan Data Terjamin",
                "description" => "Setiap surat terenkripsi dengan standar keamanan tinggi untuk menjaga kerahasiaan dokumen.",
                "icon" => "assets/image/secure.webp",
                "landing_id" => $landing->id
            ],
            [
                "title" => "Akses dari Mana Saja",
                "description" => "Kelola dan akses surat kapan saja, di perangkat apa pun dengan sistem berbasis cloud.",
                "icon" => "assets/image/cloud.webp",
                "landing_id" => $landing->id
            ],
        ]);


       $user =  User::factory()->create([
            // 'name' => 'Muhammad Nor Kholit',
            'email' => 'badean@gmail.com',
            "password" => bcrypt("12341234"),
            "role" => "admin",
            "status" => 1
        ]);

        Petugas::create([
            "id_user"=>$user->id,
            "nama"=>"Muhammad Nor Kholit",
            "nip"=>1234567890123456
        ]);

        PengaturanModel::create([
            "hasRw" => 1,
            "primary_color" => "#052158",
            "secondary_color" => "#052158",
            "logo_horizontal" => "6782678fb6528.png",
            "tanda_tangan" => "6782678fb6528.png",
            "logo" => "6782671469edb.png",
            "kelurahan" => "Badean",
            "kode_pos" => "68727",
            "kabupaten" => "Bondowoso",
            "kecamatan" => "Badean",
            "provinsi" => "Jawa Timur"
        ]);

        Faq::insert([
            [
                "question" => "Bagaimana cara mengajukan surat?",
                "answer" => "Anda dapat mengajukan surat secara online melalui aplikasi ini dengan mengisi formulir dan mengunggah dokumen yang diperlukan."
            ],
            [
                "question" => "Berapa lama proses persetujuan?",
                "answer" => "Waktu persetujuan bergantung pada jenis surat. Biasanya proses memakan waktu 1-2 hari kerja."
            ],
        ]);

        BeritaModel::factory(10)->create();
    }
}
