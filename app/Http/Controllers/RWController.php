<?php

namespace App\Http\Controllers;

use App\Models\MasyarakatModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RWController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $rw = MasyarakatModel::whereHas("user", function ($qr) {
            $qr->where("role", "rw");
        })->orderBy("created_at", "desc")->get();

        // dd($rw);
        $params["data"] = (object)[
            "rw" => $rw
        ];


        if (request()->ajax()) {
            return $this->dataTable($rw);
        }
        return view("admin.rw-rt.rw", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $masyarakat = MasyarakatModel::with(["user", "kartuKeluarga"])
            // ->whereHas("user", function ($qr) {
            //     $qr->where("role", "masyarakat");
            // })

            ->orderBy("nama_lengkap")
            ->get();
        // dd($masyarakat);
        $params["data"] = (object)[
            "title" => "Tambah RW",
            "action_form" => route("rw.store"),
            "method" => "POST",
            "masyarakat" => $masyarakat,
            "data" => (object)[
                "nik" => ""
            ]

        ];
        return view("admin.rw-rt.form", $params);
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
    public function show(MasyarakatModel $masyarakatModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasyarakatModel $masyarakatModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasyarakatModel $masyarakatModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasyarakatModel $masyarakatModel)
    {
        //
    }


    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn("rw", function ($row) {
                return $row->kartuKeluarga->rw;
            })

            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';
                $btn .= ' <a href="' . route('kartu-keluarga.edit', $row->nik) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
                $message = "Apakah anda yakin menghapus data {$row->nama_lengkap}?";
                $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'delete'}), message= '$message', url= '" . route("rw.destroy", $row->nik) . "'\"><i class='fa fa-trash'></i></button>";
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
