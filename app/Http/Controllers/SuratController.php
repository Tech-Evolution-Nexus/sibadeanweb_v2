<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\LampiranModel;
use App\Models\LampiranSuratModel;
use App\Models\SuratModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $surat = SuratModel::orderBy("created_at", "desc")->get();
        $params["data"] = (object) [
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
        $params = (object) [
            "title" => "Tambah Surat",
            "action_form" => route("surat.store"),
            "method" => "POST",
            "data" => (object) [
                "nama_surat" => "",
                "singkatan_surat" => "",
                "gambar" => "",
                "pendukungFields" => [],
                "lampiranFields" => [] // Tambahkan properti fields dengan array kosong
            ]
        ];
        return view("admin.surat.form", [
            'data' => $params,
            'lampiranList' => LampiranModel::all()
        ]); // Fixed the array syntax and added correct passing of params and lampiranFields
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            // Validasi data menggunakan request() dan validasi bahasa Indonesia
            $validated = request()->validate([
                "nama_surat" => "required|min:3|max:50",
                "singkatan_surat" => "required|min:3|max:8",
                "gambar" => "required|file|image|max:2024", // Validasi foto (optional)
                "pendukungFields" => "nullable|array",
                "pendukungFields.*" => "nullable|string|min:3|max:50",

                "lampiranFields" => "nullable|array",
                "lampiranFields.*" => "nullable|integer|exists:lampiran,id",
            ]);

            // Menyimpan data Surat
            $dataSurat = [
                'nama_surat' => $validated['nama_surat'],
                'singkatan_nama_surat' => $validated['singkatan_surat'],
                'gambar' => $validated['gambar'],
                'singkata_nama_surat' => implode('', array_map(function ($word) {
                    return ctype_alpha($word[0]) ? strtoupper($word[0]) : '';
                }, explode(' ', $validated['nama_surat']))),
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
                $dataSurat['gambar'] = 'surat/' . $randomName;
            }

            // Menyimpan data Surat
            $surat = SuratModel::create($dataSurat);

            // Menyimpan Data Pendukung
            if (!empty($validated['pendukungFields'])) {
                foreach ($validated['pendukungFields'] as $field) {
                    if (!empty($field)) {
                        Field::create([
                            'id_surat' => $surat->id,
                            'nama_field' => $field,
                        ]);
                    }
                }
            }


            // Menyimpan Data Lampiran
            if (!empty($validated['lampiranFields'])) {
                foreach ($validated['lampiranFields'] as $lampiranId) {
                    if (!empty($lampiranId)) {
                        LampiranSuratModel::create([
                            'id_surat' => $surat->id,
                            'id_lampiran' => $lampiranId,
                        ]);
                    }
                }
            }

            // Redirect kembali ke halaman daftar Surat dengan pesan sukses
            return redirect()->route('surat.index')->with('success', 'Surat berhasil ditambahkan');
        } catch (\Exception $e) {
            log::error($e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
        $surat = SuratModel::with('fields', 'lampiransurat.lampiran')->where('id', $id)->first();
        $lampiranList = LampiranModel::all();
        $gambar = $surat->gambar ? url("/c/private-image?path=$surat->gambar") : asset("assets/image/default-2.png");
        $params = (object) [
            "title" => "Ubah Surat",
            "action_form" => route("surat.update", $id),
            "method" => "PUT",
            "data" => (object) [
                "nama_surat" => $surat->nama_surat,
                "singkatan_surat" => $surat->singkatan_nama_surat,
                "gambar" => $gambar,
                "pendukungFields" => $surat->fields->pluck('nama_field')->toArray(),
                "lampiranFields" => $surat->lampiransurat->map(fn($item) => $item->lampiran->id)->toArray(),


            ]
        ];
        // dd($params);
        return view("admin.surat.form", ['data' => $params, 'lampiranList' => $lampiranList]);
    }

    public function update($id)
    {
        // Validasi input data
        $validated = request()->validate([
            "nama_surat" => "required|min:3|max:50",
            "singkatan_surat" => "required|min:3|max:8",
            "gambar" => "nullable|file|image|max:2024",
            "pendukungFields" => "array", // Validasi array pendukungFields
            "pendukungFields.*" => "nullable|string|max:255", // Validasi setiap field
            "lampiranFields" => "array", // Validasi array lampiranFields
            "lampiranFields.*" => "nullable|integer|exists:lampiran,id", // Validasi ID lampiran yang valid
        ]);

        DB::beginTransaction(); // Mulai transaksi

        try {
            $surat = SuratModel::findOrFail($id); // Mencari Surat berdasarkan ID
            $surat->nama_surat = $validated['nama_surat']; // Update nama_surat
            $surat->singkatan_nama_surat = $validated['singkatan_surat'];
            // Cek jika ada gambar baru, hapus gambar lama dan simpan gambar baru
            if (request()->hasFile('gambar')) {
                if ($surat->gambar && file_exists(storage_path('app/private/' . $surat->gambar))) {
                    unlink(storage_path('app/private/' . $surat->gambar)); // Hapus gambar lama
                }
                $file = request()->file('gambar');
                $randomName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('surat', $randomName, ['disk' => 'private']);
                $surat->gambar = 'surat/' . $randomName; // Update nama gambar
            }
            $surat->singkatan_nama_surat = implode('', array_map(function ($word) {
                return ctype_alpha($word[0]) ? strtoupper($word[0]) : '';
            }, explode(' ', $validated['nama_surat'])));

            $surat->save(); // Simpan perubahan surat

            // 🔁 Hapus field lama lalu insert ulang
            $surat->fields()->delete(); // Hapus semua field lama
            if (isset($validated['pendukungFields'])) {
                foreach ($validated['pendukungFields'] as $field) {
                    if (!empty($field)) {
                        Field::create([ // Simpan field baru yang tidak kosong
                            'id_surat' => $surat->id,
                            'nama_field' => $field,
                        ]);
                    }
                }
            }

            // Hapus lampiran lama dan simpan yang baru
            $surat->lampiransurat()->delete(); // Hapus lampiran lama
            if (isset($validated['lampiranFields'])) {
                foreach ($validated['lampiranFields'] as $lampiranId) {
                    if ($lampiranId) { // Pastikan ID lampiran valid
                        LampiranSuratModel::create([
                            'id_surat' => $surat->id,
                            'id_lampiran' => $lampiranId,
                        ]);
                    }
                }
            }

            DB::commit(); // Commit transaksi jika semuanya berhasil
            return redirect()->route('surat.index')->with('success', 'Surat berhasil diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack(); // Rollback transaksi jika ada error
            Log::error('Error in update surat: ' . $th->getMessage(), ['exception' => $th]);
            return redirect()->back()->with('error', 'Surat gagal diperbarui');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratModel $surat)
    {
        try {

            $oldImagePath = storage_path('app/private/' . $surat->gambar);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Menghapus file gambar lama
            }
            $surat->delete();

            return redirect()->back()->with('success', 'surat berhasil dihapus');
        } catch (QueryException $e) {
            dd($e);
            // Tangani constraint violation (kode 23000)
            if ($e->getCode() === '23000') {
                return redirect()->back()->with('error', 'Gagal menghapus karena data terkait masih digunakan.');
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan tak terduga.');
        }
    }



    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('gambar', function ($surat) {
                $gambarUrl = $surat->gambar
                    ? url("/c/private-image?path=$surat->gambar")
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
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }
}
