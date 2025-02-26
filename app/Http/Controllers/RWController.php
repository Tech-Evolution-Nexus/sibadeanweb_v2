<?php

namespace App\Http\Controllers;

use App\Models\MasyarakatModel;
use App\Models\User;
use Helpers;
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
            $qr->where("status", "1");
        })->orderBy("created_at", "desc")
            ->get();
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
            ->whereHas("user", function ($qr) {
                $qr->where("role", "masyarakat");
                $qr->where(
                    "status",
                    "1"
                );
            })
            ->orderBy("nama_lengkap")
            ->get();
        // dd($masyarakat);
        $params["data"] = (object)[
            "title" => "Tambah RW",
            "action_form" => route("rw.store"),
            "method" => "POST",
            "masyarakat" => $masyarakat,
            "data" => (object)[
                "nik" => "",
                "masa_jabatan_mulai" => "",
                "masa_jabatan_selesai" => "",
            ]

        ];
        return view("admin.rw-rt.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            "nik" => "required|digits:16",
            "masa_jabatan_mulai" => "required|date",
            "masa_jabatan_selesai" => "required|date|after:masa_jabatan_mulai"
        ]);


        $masyarakat = MasyarakatModel::find(request()->nik);
        $hasRw = MasyarakatModel::whereHas("kartuKeluarga", function ($qr) use ($masyarakat) {
            $qr->where("rw", $masyarakat->kartuKeluarga->rw);
        })->whereHas("user", function ($qr) {
            $qr->where("role", "rw");
        })->count();
        if ($hasRw) {
            return redirect()->back()->withInput(request()->all())->with("error", "Ketua rw {$masyarakat->kartuKeluarga->rw} sudah ada");
        }

        $s = User::whereHas("masyarakat", function ($qr) {
            $qr->where("nik", request()->nik);
        })->first();
        $s->update([
            "role" => "rw",
            "masa_jabatan_mulai" => request()->masa_jabatan_mulai,
            "masa_jabatan_selesai" => request()->masa_jabatan_selesai
        ]);

        return redirect(route("rw.index"))->with("success", "RW berhasil ditambahkan");
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
    public function edit($id)
    {
        $masyarakat = MasyarakatModel::with(["user", "kartuKeluarga"])
            ->whereHas("user", function ($qr) {
                $qr->where("role", "rw");
                $qr->where(
                    "status",
                    "1"
                );
            })
            ->orderBy("nama_lengkap")
            ->get();
        $rw = MasyarakatModel::find($id);
        $params["data"] = (object)[
            "title" => "Ubah RW",
            "action_form" => route("rw.update", $id),
            "method" => "PUT",
            "masyarakat" => $masyarakat,
            "data" => (object)[
                "nik" => $id,
                "masa_jabatan_mulai" => $rw->user->masa_jabatan_mulai,
                "masa_jabatan_selesai" => $rw->user->masa_jabatan_selesai,
            ]

        ];
        return view("admin.rw-rt.form", $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nik)
    {
        request()->validate([
            "masa_jabatan_mulai" => "required|date",
            "masa_jabatan_selesai" => "required|date|after:masa_jabatan_mulai"
        ]);


        $masyarakat = MasyarakatModel::find($nik);
        $hasRw = MasyarakatModel::whereHas("kartuKeluarga", function ($qr) use ($masyarakat) {
            $qr->where("rw", $masyarakat->kartuKeluarga->rw);
        })->whereHas("user", function ($qr) {
            $qr->where("role", "rw");
        })
            ->whereNot("nik", $nik)->count();
        if ($hasRw) {
            return redirect()->back()->withInput(request()->all())->with("error", "Ketua rw {$masyarakat->kartuKeluarga->rw} sudah ada");
        }

        $s = User::whereHas("masyarakat", function ($qr) use ($nik) {
            $qr->where("nik", $nik);
        })->first();
        $s->update([
            "masa_jabatan_mulai" => request()->masa_jabatan_mulai,
            "masa_jabatan_selesai" => request()->masa_jabatan_selesai
        ]);

        return redirect(route("rw.index"))->with("success", "RW berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nik)
    {
        $s = User::whereHas("masyarakat", function ($qr) use ($nik) {
            $qr->where("nik", $nik);
        })->first();
        $s->update([
            "role" => "masyarakat",
            "masa_jabatan_mulai" => null,
            "masa_jabatan_selesai" => null
        ]);
        return redirect(route("rw.index"))->with("success", "Status RW berhasil diubah");
    }


    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn("rw", function ($row) {
                return $row->kartuKeluarga->rw;
            })
            ->addColumn("masa_jabatan", function ($row) {
                content:
                $jabatan_mulai = Helpers::formatDate($row->user->masa_jabatan_mulai);
                $jabatan_selesai = Helpers::formatDate($row->user->masa_jabatan_selesai);
                return "{$jabatan_mulai} - {$jabatan_selesai} ";
            })


            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';
                $btn .= ' <a href="' . route('rt.index', $row->kartuKeluarga->rw) . '" class="btn-show"><i class="fa fa-info"></i></a>';
                $btn .= ' <a href="' . route('rw.edit', $row->nik) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
                $message = "Apakah anda yakin mengubah status ketua rw {$row->nama_lengkap} menjadi masyarakat?";
                $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'updateStatus'}), message= '$message', url= '" . route("rw.destroy", $row->nik) . "'\"><i class='fa fa-trash'></i></button>";
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
