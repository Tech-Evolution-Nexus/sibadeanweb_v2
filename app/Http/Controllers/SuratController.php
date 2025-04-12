<?php

namespace App\Http\Controllers;

use App\Models\SuratModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $surat = SuratModel::orderBy("created_at", "desc")->get();
        $params["data"] = (object)[
            "surat" => $surat
        ];


        if (request()->ajax()) {
            return $this->dataTable($surat);
        }
        return view("admin.surat.surat", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $params["data"] = (object)[
            "title" => "Tambah surat",
            "action_form" => route("surat.store"),
            "method" => "POST",
            "data" => (object)[
                "nama_surat" => "",
                "gambar" => "",
            ]
        ];
        return view("admin.surat.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // Validasi data menggunakan request() dan validasi bahasa Indonesia
        $validated = request()->validate([
            "nama_surat" => "required|min:3|max:50",
            "gambar" => "file|image|max:2024", // Validasi foto (optional)
        ]);

        // Menyimpan data Surat
        $dataSurat = [
            'nama_surat' => $validated['nama_surat'],
            'gambar' => $validated['gambar'],
            'format_surat' => <<<HTML
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
            HTML,
        ];

        // Jika ada file foto Surat
        if (request()->hasFile('gambar')) {
            $file = request()->file('gambar');
            $randomName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('surat', $randomName, ['disk' => 'private']);
            $dataSurat['gambar'] = $randomName;
        }

        // Menyimpan data Surat
        SuratModel::create($dataSurat);
        return redirect()->route('surat.index')->with('success', 'Surat berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(SuratModel $SuratModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $surat = SuratModel::find($id);
        $gambar = $surat->gambar ? url("/c/private-image?path=surat/$surat->gambar") : asset("assets/image/default-2.png");
        $params["data"] = (object)[
            "title" => "Ubah Surat",
            "action_form" => route("surat.update", $id),
            "method" => "PUT",
            "data" => (object)[
                "nama_surat" => $surat->nama_surat,
                "gambar" => $gambar,

            ]
        ];
        return view("admin.surat.form", $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $masyarakat = SuratModel::findOrFail($id)->kepalaKeluarga;
        // Validasi data menggunakan request()
        $validated = request()->validate(
            [
                "nama_surat" => "required|min:3|max:50",
                "gambar" => "file|image|max:2024", // Validasi foto (optional)
            ]
        );

        try {
            // Cari data Surat berdasarkan ID
            $surat = SuratModel::findOrFail($id);
            // Menyimpan data Surat yang telah diperbarui
            $surat->nama_surat = $validated['nama_surat'];
            // $surat->kk_tgl = $validated['tanggal_kk'];
            $oldImagePath = storage_path('app/private/surat/' . $surat->gambar);
            // Jika ada file foto Surat baru
            if (request()->hasFile('gambar')) {
                // Menghapus gambar lama jika ada
                if ($surat->kk_gambar) {
                    $oldImagePath = storage_path('app/private/surat/' . $surat->gambar);
                    if (file_exists($oldImagePath) && $surat->gambar != "default-2.png") {
                        unlink($oldImagePath); // Menghapus file gambar lama
                    }
                }

                // Menyimpan gambar yang baru
                $file = request()->file('gambar');
                $randomName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('surat', $randomName, ['disk' => 'private']);
                $surat->gambar = $randomName;
            }

            // Menyimpan data Surat yang telah diperbarui
            $surat->save();
            return redirect()->route('surat.index')->with('success', 'Surat berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Surat gagal diperbarui');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratModel $surat)
    {
        $oldImagePath = storage_path('app/private/surat/' . $surat->gambar);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath); // Menghapus file gambar lama
        }
        $surat->delete();

        return redirect()->back()->with('success', 'Berita berhasil diperbarui');
    }



    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('gambar', function ($surat) {
                $gambarUrl = $surat->gambar
                    ? url("/c/private-image?path=surat/$surat->gambar")
                    : asset("assets/image/default-2.png");
            
                    return '<img src="' . $gambarUrl . '" alt="Gambar Surat" width="50">';

            })
            
            
            // ->addColumn('kepala_keluarga', function ($row) {
            //     return $row->kepalaKeluarga->nama_lengkap;
            // })
            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';
                $btn .= ' <a href="' . route('surat.edit', $row->id) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
                $message = "Apakah anda yakin menghapus data {$row->nama_surat}?";
                $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'delete'}), message= '$message', url= '" . route("surat.destroy", $row->id) . "'\"><i class='fa fa-trash'></i></button>";
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['gambar','action'])
            ->make(true);
    }
}
