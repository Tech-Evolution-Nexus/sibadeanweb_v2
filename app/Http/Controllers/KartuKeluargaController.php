<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluargaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KartuKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $kartuKeluarga = KartuKeluargaModel::orderBy("created_at", "desc")->get();
        $params["data"] = (object)[
            "kartu_keluarga" => $kartuKeluarga
        ];



        if (request()->ajax()) {
            return $this->dataTable($kartuKeluarga);
        }
        return view("admin.kartu-keluarga.index", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengaturan = auth()->user()->pengaturan();
        $params["data"] = (object)[
            "title" => "Tambah Kartu Keluarga",
            "action_form" => route("kartu-keluarga.store"),
            "data" => (object)[
                "no_kk" => "",
                "tanggal_kk" => "",
                "nik" => "",
                "nama" => "",
                "alamat" => "",
                "rt" => "",
                "rw" => "",
                "foto_kartu_keluarga" => "",
                "kode_pos" => $pengaturan->kode_pos,
                "kelurahan" => $pengaturan->kelurahan,
                "kecamatan" => $pengaturan->kecamatan,
                "kabupaten" => $pengaturan->kabupaten,
                "provinsi" => $pengaturan->provinsi,
            ]
        ];
        return view("admin.kartu-keluarga.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(KartuKeluargaModel $kartuKeluargaModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KartuKeluargaModel $kartuKeluargaModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KartuKeluargaModel $kartuKeluargaModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KartuKeluargaModel $kartuKeluargaModel)
    {
        //
    }



    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addColumn('kepala_keluarga', function ($row) {
                return $row->masyarakat->where("role", "=", "kk ")->pluck('name')->first();
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('kartu-keluarga.show', $row->id) . '" class="btn btn-info btn-sm">Detail</a>';
                $btn .= ' <a href="' . route('kartu-keluarga.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                $btn .= ' <form action="' . route('kartu-keluarga.destroy', $row->id) . '" method="POST" style="display: inline;">';
                $btn .= csrf_field() . method_field('DELETE');
                $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Hapus</button>';
                $btn .= '</form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
