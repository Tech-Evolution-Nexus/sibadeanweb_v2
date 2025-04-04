<?php

namespace App\Http\Controllers;

use App\Models\SuratModel;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        // default format surat
        // <h2 style="text-align:center;"><strong>Surat Keterangan</strong></h2><p style="text-align:center;"><strong>No.</strong> <strong>{no_surat}</strong></p><p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong>Yang bertanda tangan di bawah ini ketua RT {rt}, RW {rw}, Desa &nbsp;{desa} Kecamatan {kecamatan} Kabupaten {kabupaten} dengan ini menerangkan bahwa :</p><figure class="table"><table><tbody><tr><td>Nama</td><td>: {nama}</td></tr><tr><td>Tempat/ Tanggal lahir</td><td>: {tempat_lahir}/{tanggal_lahir}</td></tr><tr><td>Jenis Kelamin</td><td>: {jenis_kelamin}</td></tr><tr><td>Pekerjaan</td><td>: {pekerjaan}</td></tr><tr><td>Agama</td><td>: {agama}</td></tr><tr><td>Status perkawinan</td><td>: {status_perkawinan}</td></tr><tr><td>Kewarganegaraan</td><td>: {kewarganegaraan}</td></tr><tr><td>Alamat</td><td>: {alamat}</td></tr></tbody></table></figure><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Orang tersebut diatas, adalah benar-benar warga kami dan berdomisili di RT {rt}, RW {rw} Desa {desa} Kecamatan {kecamatan} Kabupaten {kabupaten} surat keterangan ini digunakan sebagai kelengkapan pengurusan perpindahan penduduk.</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Demikian surat keterangan ini kami buat, untuk dapat dipergunakan sebagaimana semestinya.</p><p>&nbsp;</p><p>&nbsp;</p><p style="text-align:right;">{tanggal_pengajuan},Ketua RT {rt} RW {rt} &nbsp; &nbsp; &nbsp;&nbsp;</p><p style="text-align:right;">&nbsp;</p><p style="text-align:right;">&nbsp;</p><p style="text-align:right;">&nbsp;</p><p style="text-align:right;">{nama} &nbsp; &nbsp;</p>
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratModel $suratModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratModel $suratModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratModel $suratModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratModel $suratModel)
    {
        //
    }
}
