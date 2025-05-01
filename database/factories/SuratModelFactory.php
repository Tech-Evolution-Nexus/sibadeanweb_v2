<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratModel>
 */
class SuratModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nama_surat" => $this->faker->unique()->randomElement([
                'Surat Keterangan Domisili',
                'Surat Keterangan Tidak Mampu (SKTM)',
                'Surat Keterangan Usaha (SKU)',
                'Surat Keterangan Kematian',
                'Surat Keterangan Kelahiran',
                'Surat Keterangan Pindah',
                'Surat Keterangan Ahli Waris',
                'Surat Pengantar Nikah',
                'Surat Keterangan Tanah',
                'Surat Permohonan SKCK',
            ]),
            "gambar" => "s",
            "format_surat" => <<<HTML
            <h2 style='text-align:center;'><strong>Surat Keterangan</strong></h2>
            <p style='text-align:center;'><strong>No.</strong> <strong>{no_surat}</strong></p>
            <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong>Yang bertanda tangan di bawah ini ketua RT {rt}, RW {rw}, Desa {desa} Kecamatan {kecamatan} Kabupaten {kabupaten} dengan ini menerangkan bahwa :</p>
            <figure class='table'>
                <table>
                    <tbody>
                        <tr><td>Nama</td><td>: {nama}</td></tr>
                        <tr><td>Tempat/ Tanggal lahir</td><td>: {tempat_lahir}/{tanggal_lahir}</td></tr>
                        <tr><td>Jenis Kelamin</td><td>: {jenis_kelamin}</td></tr>
                        <tr><td>Pekerjaan</td><td>: {pekerjaan}</td></tr>
                        <tr><td>Agama</td><td>: {agama}</td></tr>
                        <tr><td>Status perkawinan</td><td>: {status_perkawinan}</td></tr>
                        <tr><td>Kewarganegaraan</td><td>: {kewarganegaraan}</td></tr>
                        <tr><td>Alamat</td><td>: {alamat}</td></tr>
                    </tbody>
                </table>
            </figure>
            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Orang tersebut diatas, adalah benar-benar warga kami dan berdomisili di RT {rt}, RW {rw} Desa {desa} Kecamatan {kecamatan} Kabupaten {kabupaten} surat keterangan ini digunakan sebagai kelengkapan pengurusan perpindahan penduduk.</p>
            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Demikian surat keterangan ini kami buat, untuk dapat dipergunakan sebagaimana semestinya.</p>
            <p style="text-align:right;">{tanggal_pengajuan},Ketua RT {rt} RW {rt} &nbsp; &nbsp; &nbsp;&nbsp;</p>
            <p style='text-align:right;'>{nama} &nbsp; &nbsp;</p>
            HTML];
    }
}
