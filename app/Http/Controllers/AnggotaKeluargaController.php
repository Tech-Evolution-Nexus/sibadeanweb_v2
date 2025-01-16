<?php

namespace App\Http\Controllers;

use App\Models\MasyarakatModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnggotaKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($no_kk)
    {
        $anggotaKeluarga = MasyarakatModel::where("no_kk", $no_kk)->orderBy("created_at", "desc")->get();

        $params["data"] = (object)[
            "anggota_keluarga" => $anggotaKeluarga,
            "no_kk" => $no_kk
        ];


        if (request()->ajax()) {
            return $this->dataTable($anggotaKeluarga);
        }
        return view("admin.kartu-keluarga.anggota-keluarga.anggota-keluarga", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($no_kk)
    {
        $ayah = MasyarakatModel::where("no_kk", $no_kk)->where("status_keluarga", "kk")->first();
        $ibu = MasyarakatModel::where("no_kk", $no_kk)->where("status_keluarga", "istri")->first();
        $data = (object)[
            "nik" => "",
            "nama_lengkap" => "",
            "jenis_kelamin" => "",
            "tempat_lahir" => "",
            "tanggal_lahir" => "",
            "agama" => "",
            "pendidikan" => "",
            "pekerjaan" => "",
            "golongan_darah" => "",
            "status_perkawinan" => "",
            "tanggal_perkawinan" => "",
            "status_keluarga" => "",
            "kewarganegaraan" => "",
            "no_paspor" => "",
            "no_kitap" => "",
            "nama_ayah" => $ayah->nama_lengkap ?? "",
            "nama_ibu" => $ibu->nama_lengkap ?? "",
            "hasKK" => isset($ayah)
        ];
        $params["data"] = (object)[
            "title" => "Tambah Anggota Keluarga",
            "method" => "POST",
            "action_form" => route("anggota-keluarga.store", $no_kk),
            "data" => $data,
            "no_kk" => $no_kk
        ];

        return view("admin.kartu-keluarga.anggota-keluarga.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($no_kk, Request $request)
    {
        $result =  request()->validate([
            'nik' => "required|string|min:16|max:16|unique:masyarakat,nik",
            'nama_lengkap' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tempat_lahir' => 'required|string|max:70',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'golongan_darah' => 'nullable|in:A+, A-, B+, B-, AB+, AB-, O+, O-',
            'status_perkawinan' => 'required|string|in:belum_menikah, menikah, cerai_hidup, cerai_mati, duda, janda',
            'tanggal_perkawinan' => 'nullable|date',
            'status_keluarga' => 'required|string|in:kk, istri, anak, wali',
            'kewarganegaraan' => 'required|string|in:WNI,WNA',
            'no_paspor' => 'nullable|string|max:20',
            'no_kitap' => 'nullable|string|max:20',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
        ]);

        $result["no_kk"] = $no_kk;
        try {
            MasyarakatModel::create($result);
            return redirect()->route('anggota-keluarga.index', $no_kk)->with('success', 'Anggota keluarga berhasil ditambah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('success', 'Anggota keluarga gagal ditambah');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($no_kk, string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($no_kk, string $id)
    {
        $kk = MasyarakatModel::where("no_kk", $no_kk)
            ->where("status_keluarga", "kk")
            ->whereNot("nik", $id)
            ->first();

        $masyarakat = MasyarakatModel::find($id);
        $data = (object)[
            "nik" => $id,
            "nama_lengkap" => $masyarakat->nama_lengkap,
            "jenis_kelamin" => $masyarakat->jenis_kelamin,
            "tempat_lahir" => $masyarakat->tempat_lahir,
            "tanggal_lahir" => $masyarakat->tanggal_lahir,
            "agama" => $masyarakat->agama,
            "pendidikan" => $masyarakat->pendidikan,
            "pekerjaan" => $masyarakat->pekerjaan,
            "golongan_darah" => $masyarakat->golongan_darah,
            "status_perkawinan" => $masyarakat->status_perkawinan,
            "tanggal_perkawinan" => $masyarakat->tanggal_perkawinan,
            "status_keluarga" => $masyarakat->status_keluarga,
            "kewarganegaraan" => $masyarakat->Kewarganegaraan,
            "no_paspor" => $masyarakat->no_paspor,
            "no_kitap" => $masyarakat->no_kitap,
            "nama_ayah" => $masyarakat->nama_ayah,
            "nama_ibu" => $masyarakat->nama_ibu,
            "hasKK" => isset($kk)
        ];
        $params["data"] = (object)[
            "title" => "Ubah Anggota Keluarga",
            "method" => "PUT",
            "action_form" => route("anggota-keluarga.update", [$no_kk, $id]),
            "data" => $data,
            "no_kk" => $no_kk
        ];

        return view("admin.kartu-keluarga.anggota-keluarga.form", $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($no_kk, Request $request, string $id)
    {
        $result =  request()->validate([
            'nik' => "required|string|min:16|max:16|unique:masyarakat,nik," . $id . ",nik",
            'nama_lengkap' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tempat_lahir' => 'required|string|max:70',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'golongan_darah' => 'nullable|in:A+, A-, B+, B-, AB+, AB-, O+, O-',
            'status_perkawinan' => 'required|string|in:belum_menikah, menikah, cerai_hidup, cerai_mati, duda, janda',
            'tanggal_perkawinan' => 'nullable|date',
            'status_keluarga' => 'required|string|in:kk, istri, anak, wali',
            'kewarganegaraan' => 'required|string|in:WNI,WNA',
            'no_paspor' => 'nullable|string|max:20',
            'no_kitap' => 'nullable|string|max:20',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
        ]);

        try {
            MasyarakatModel::find($id)->update($result);
            return redirect()->route('anggota-keluarga.index', $no_kk)->with('success', 'Anggota keluarga berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('success', 'Anggota keluarga gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($no_kk, string $id)
    {
        //
    }

    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';
                $btn .= '<a href="' . route('anggota-keluarga.show', [$row->no_kk, $row->nik]) . '" class="btn-show"><i class="fa fa-info"></i></a>';
                $btn .= ' <a href="' . route('anggota-keluarga.edit', [$row->no_kk, $row->nik]) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
                $message = "Apakah anda yakin menghapus data $row->nama_lengkap?";
                $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'delete'}), message= '$message', url= '" . route("anggota-keluarga.destroy", [$row->no_kk, $row->nik]) . "'\"><i class='fa fa-trash'></i></button>";
                $btn .= '</div>';
                return $btn;
            })

            ->addColumn("jenis_kelamin", function ($row) {
                return $row->jenis_kelamin ?? "-";
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
