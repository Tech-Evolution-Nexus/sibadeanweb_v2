<?php

namespace App\Http\Controllers;

use App\Models\lampiran;
use App\Models\LampiranModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LampiranController extends Controller
{
    public function index()
    {

        $lampiran = LampiranModel::all();
        $params["data"] = (object)[
            "lampiran" => $lampiran
        ];

        if (request()->ajax()) {
            return $this->dataTable($lampiran);
        }
        return view("admin.lampiran.lampiran", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $params["data"] = (object)[
            "title" => "Tambah lampiran",
            "action_form" => route("lampiran.store"),
            "method" => "POST",
            "data" => new LampiranModel()
        ];
        return view("admin.lampiran.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // Validasi data menggunakan request() dan validasi bahasa Indonesia
        $validated = request()->validate([
            "nama_lampiran" => "required"
        ]);
        // Menyimpan data kartu keluarga
        LampiranModel::create($validated);

        return redirect()->route('lampiran.index')->with('success', 'lampiran berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(LampiranModel $lampiranModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $lampiran = LampiranModel::find($id);
        $params["data"] = (object)[
            "title" => "Ubah lampiran",
            "action_form" => route("lampiran.update", $id),
            "method" => "PUT",
            "data" => $lampiran
        ];
        return view("admin.lampiran.form", $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {

        $validated = request()->validate(
            [
                "nama_lampiran" => "required",
            ]
        );

        try {
            // Cari data kartu keluarga berdasarkan ID
            LampiranModel::findOrFail($id)->update($validated);

            return redirect()->route('lampiran.index')->with('success', 'lampiran berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'lampiran gagal diperbarui');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lampiranModel = LampiranModel::findOrFail($id);
        $lampiranModel->delete();
        return redirect()->back()->with('success', 'lampiran berhasil dihapus');
    }



    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';
                $btn .= ' <a href="' . route('lampiran.edit', $row->id) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
                $message = "Apakah anda yakin menghapus data {$row->judul}?";
                $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'delete'}), message= '$message', url= '" . route("lampiran.destroy", $row->id) . "'\"><i class='fa fa-trash'></i></button>";
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('answer', function ($row) {
                return \Str::limit($row->answer, 70);
            })
            ->rawColumns(['gambar', 'action', "answer"])
            ->make(true);
    }
}
