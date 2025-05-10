<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BeritaModelFactory extends Factory
{
    public function definition(): array
    {
        $data = collect([
            [
                'judul' => 'Gotong Royong Bersihkan Lingkungan Desa',
                'keterangan' => 'Warga bersama-sama membersihkan area sekitar balai desa.',
                'konten' => <<<MD
## Gotong Royong Bersihkan Lingkungan

Warga Desa Badean menunjukkan semangat kebersamaan dengan mengadakan kegiatan gotong royong membersihkan lingkungan sekitar balai desa. Kegiatan ini diikuti oleh berbagai lapisan masyarakat, mulai dari anak-anak hingga orang tua.

Kegiatan ini bertujuan untuk menciptakan lingkungan yang bersih dan sehat. Warga membawa peralatan seperti sapu, cangkul, dan gerobak sampah untuk membersihkan selokan dan memotong rumput liar.

Kepala desa menyampaikan terima kasih atas partisipasi aktif masyarakat dan berharap kegiatan seperti ini dapat dilakukan secara rutin demi kenyamanan bersama.
MD
            ],
            [
                'judul' => 'Lomba 17 Agustus Meriahkan HUT RI',
                'keterangan' => 'Berbagai perlombaan digelar untuk memeriahkan kemerdekaan.',
                'konten' => <<<MD
## Lomba HUT RI ke-78

Dalam rangka memperingati Hari Kemerdekaan Republik Indonesia, Desa Badean menyelenggarakan berbagai perlombaan seperti balap karung, panjat pinang, dan tarik tambang.

Antusiasme warga terlihat dari banyaknya peserta yang ikut serta serta dukungan meriah dari penonton. Anak-anak hingga orang tua turut serta menyemarakkan acara ini.

Melalui lomba ini, tidak hanya semangat kemerdekaan yang tumbuh, tapi juga rasa kebersamaan antarwarga makin erat.
MD
            ],
            [
                'judul' => 'Penanaman Pohon Serentak di Badean',
                'keterangan' => 'Kegiatan penghijauan dilakukan di seluruh wilayah desa.',
                'konten' => <<<MD
## Aksi Penghijauan Desa Badean

Sebagai bagian dari upaya menjaga lingkungan, Desa Badean mengadakan kegiatan penanaman pohon serentak di seluruh dusun. Bibit pohon disediakan oleh Dinas Lingkungan Hidup.

Masyarakat sangat antusias mengikuti kegiatan ini. Jenis pohon yang ditanam meliputi trembesi, mangga, dan jambu yang memiliki manfaat jangka panjang.

Kegiatan ini diharapkan menjadi langkah awal untuk menciptakan lingkungan yang lebih hijau dan sehat untuk generasi mendatang.
MD
            ],
            [
                'judul' => 'Pelatihan Digital untuk Pemuda Desa',
                'keterangan' => 'Pelatihan komputer dan internet bagi generasi muda.',
                'konten' => <<<MD
## Pelatihan Komputer dan Internet

Pemerintah Desa Badean bekerja sama dengan Dinas Kominfo mengadakan pelatihan komputer dasar untuk pemuda desa. Pelatihan ini bertujuan meningkatkan keterampilan digital generasi muda.

Materi pelatihan meliputi penggunaan Microsoft Office, email, hingga pembuatan CV. Para peserta diberikan modul serta sertifikat di akhir kegiatan.

Dengan pelatihan ini, diharapkan pemuda desa mampu bersaing di dunia kerja yang semakin digital.
MD
            ],
            [
                'judul' => 'Kunjungan Bupati ke Desa Badean',
                'keterangan' => 'Bupati memberikan bantuan untuk pembangunan jalan desa.',
                'konten' => <<<MD
## Kunjungan Resmi Bupati

Bupati Situbondo mengunjungi Desa Badean dalam rangka evaluasi pembangunan infrastruktur. Dalam kunjungan tersebut, Bupati menyerahkan bantuan dana untuk perbaikan jalan desa.

Warga menyambut hangat kedatangan Bupati. Mereka menyampaikan aspirasi terkait jalan rusak dan kebutuhan fasilitas umum lainnya.

Kepala desa berharap bantuan tersebut dapat segera direalisasikan agar mobilitas warga menjadi lebih baik dan aman.
MD
            ],
            [
                'judul' => 'Pengajian Akbar di Lapangan Badean',
                'keterangan' => 'Masyarakat berkumpul untuk mengikuti pengajian rutin.',
                'konten' => <<<MD
## Pengajian Akbar Rutin

Ribuan warga memadati lapangan desa Badean untuk mengikuti pengajian akbar yang menghadirkan penceramah dari luar kota. Tema pengajian kali ini adalah pentingnya menjaga ukhuwah islamiyah.

Acara ini dibuka dengan lantunan ayat suci Al-Quran dan diakhiri dengan doa bersama. Banyak warga mengaku terharu dengan isi ceramah yang menyentuh hati.

Panitia berharap kegiatan ini bisa terus berlangsung setiap bulan sebagai bentuk penguatan iman masyarakat.
MD
            ],
            [
                'judul' => 'Pembangunan Jembatan Baru Dimulai',
                'keterangan' => 'Proyek jembatan baru di wilayah timur desa dimulai bulan ini.',
                'konten' => <<<MD
## Proyek Jembatan Desa Dimulai

Pemerintah desa mulai melaksanakan proyek pembangunan jembatan penghubung di Dusun Timur yang selama ini hanya menggunakan jembatan darurat dari kayu.

Proyek ini menggunakan dana bantuan dari kabupaten serta swadaya masyarakat. Pengerjaan ditargetkan selesai dalam waktu 3 bulan.

Jembatan ini akan mempermudah akses pertanian dan memperlancar distribusi hasil panen warga.
MD
            ],
            [
                'judul' => 'Vaksinasi Massal di Balai Desa',
                'keterangan' => 'Ratusan warga ikut serta dalam vaksinasi gratis.',
                'konten' => <<<MD
## Vaksinasi Massal COVID-19

Dinas Kesehatan mengadakan vaksinasi massal di Balai Desa Badean. Warga yang belum divaksinasi diminta hadir dengan membawa KTP dan kartu keluarga.

Kegiatan berjalan lancar dengan tetap menerapkan protokol kesehatan. Tenaga medis juga memberikan edukasi seputar manfaat vaksinasi.

Antusiasme warga sangat tinggi, menunjukkan kesadaran masyarakat akan pentingnya menjaga kesehatan bersama.
MD
            ],
            [
                'judul' => 'Turnamen Sepak Bola Antar RW',
                'keterangan' => 'Pertandingan persahabatan antar wilayah desa berlangsung seru.',
                'konten' => <<<MD
## Turnamen Bola Antar RW

Turnamen sepak bola antar RW diselenggarakan di lapangan utama desa sebagai bagian dari kegiatan olahraga tahunan. Acara ini diikuti oleh 6 RW dengan semangat sportivitas tinggi.

Pertandingan berlangsung seru dan ramai penonton. Banyak warga datang memberi semangat sambil membawa spanduk dan terompet.

Selain sebagai hiburan, kegiatan ini juga mempererat solidaritas antarwarga dari berbagai dusun.
MD
            ],
            [
                'judul' => 'Pasar Malam Hadir Kembali di Badean',
                'keterangan' => 'Pasar malam ramai dikunjungi warga dengan berbagai hiburan.',
                'konten' => <<<MD
## Kemeriahan Pasar Malam

Setelah dua tahun vakum, pasar malam kembali hadir di Desa Badean. Berbagai wahana permainan, makanan tradisional, dan pertunjukan musik lokal turut meramaikan suasana.

Warga dari desa tetangga juga berdatangan untuk menikmati suasana pasar malam. Anak-anak sangat antusias bermain bianglala dan membeli mainan.

Pasar malam ini diharapkan bisa menjadi agenda rutin dan menjadi pusat hiburan rakyat desa.
MD
            ],
        ]);

        $berita = $this->faker->unique()->randomElement($data);

        return [
            'judul' => $berita['judul'],
            'slug' => Str::slug($berita['judul']),
            'keterangan' => $berita['keterangan'],
            'konten' => $berita['konten'],
            'gambar' => 'assets/image/badean.jpg',
        ];
    }
}
