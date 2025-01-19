<?php

namespace App\Http\Controllers;

use App\Models\MasyarakatModel;
use App\Models\User;
use Helpers;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RTController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($rw)
    {

        $rt = MasyarakatModel::whereHas("user", function ($qr) {
            $qr->where("role", "rt");
            $qr->where("status", "1");
        })->whereHas("kartuKeluarga", function ($qr) use ($rw) {
            $qr->where("rw", $rw);
        })
            ->orderBy("created_at", "desc")
            ->get();
        $params["data"] = (object)[
            "rt" => $rt,
            "rw" => $rw
        ];


        if (request()->ajax()) {
            return $this->dataTable($rt);
        }
        return view("admin.rw-rt.rt", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rw)
    {
        $masyarakat = MasyarakatModel::with(["user", "kartuKeluarga"])
            ->whereHas("user", function ($qr) {
                $qr->where("role", "masyarakat");
                $qr->where(
                    "status",
                    "1"
                );
            })
            ->whereHas("kartuKeluarga", function ($qr) use ($rw) {
                $qr->where("rw", $rw);
            })
            ->orderBy("nama_lengkap")
            ->get();
        // dd($masyarakat);
        $params["data"] = (object)[
            "title" => "Tambah RT",
            "action_form" => route("rt.store", $rw),
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
    public function store($rw, Request $request)
    {
        request()->validate([
            "nik" => "required|digits:16",
            "masa_jabatan_mulai" => "required|date",
            "masa_jabatan_selesai" => "required|date|after:masa_jabatan_mulai"
        ]);


        $masyarakat = MasyarakatModel::find(request()->nik);
        $hasRw = MasyarakatModel::whereHas("kartuKeluarga", function ($qr) use ($masyarakat, $rw) {
            $qr->where("rw", $rw);
            $qr->where("rt", $masyarakat->kartuKeluarga->rt);
        })->whereHas("user", function ($qr) {
            $qr->where("role", "rt");
        })->count();
        if ($hasRw) {
            return redirect()->back()->withInput(request()->all())->with("error", "Ketua rt {$masyarakat->kartuKeluarga->rt} sudah ada");
        }

        $s = User::whereHas("masyarakat", function ($qr) {
            $qr->where("nik", request()->nik);
        })->first();
        $s->update([
            "role" => "rt",
            "masa_jabatan_mulai" => request()->masa_jabatan_mulai,
            "masa_jabatan_selesai" => request()->masa_jabatan_selesai
        ]);

        return redirect(route("rt.index", $rw))->with("success", "RT berhasil ditambahkan");
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
    public function edit($rw, $id)
    {
        $masyarakat = MasyarakatModel::with(["user", "kartuKeluarga"])
            ->whereHas("user", function ($qr) {
                $qr->where("role", "rt");
                $qr->where(
                    "status",
                    "1"
                );
            })
            ->whereHas("kartuKeluarga", function ($qr) use ($rw) {
                $qr->where("rw", $rw);
            })
            ->orderBy("nama_lengkap")
            ->get();
        $rt = MasyarakatModel::find($id);
        $params["data"] = (object)[
            "title" => "Ubah RT",
            "action_form" => route("rt.update", [$rw, $id]),
            "method" => "PUT",
            "masyarakat" => $masyarakat,
            "data" => (object)[
                "nik" => $id,
                "masa_jabatan_mulai" => $rt->user->masa_jabatan_mulai,
                "masa_jabatan_selesai" => $rt->user->masa_jabatan_selesai,
            ]

        ];
        return view("admin.rw-rt.form", $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($rw, Request $request, $nik)
    {
        request()->validate([
            "masa_jabatan_mulai" => "required|date",
            "masa_jabatan_selesai" => "required|date|after:masa_jabatan_mulai"
        ]);


        $masyarakat = MasyarakatModel::find($nik);
        $hasRw = MasyarakatModel::whereHas("kartuKeluarga", function ($qr) use ($masyarakat, $rw) {
            $qr->where("rw", $rw);
            $qr->where("rt", $masyarakat->kartuKeluarga->rt);
        })->whereHas("user", function ($qr) {
            $qr->where("role", "rt");
        })
            ->whereNot("nik", $nik)->count();
        if ($hasRw) {
            return redirect()->back()->withInput(request()->all())->with("error", "Ketua rT {$masyarakat->kartuKeluarga->rt} sudah ada");
        }

        $s = User::whereHas("masyarakat", function ($qr) use ($nik) {
            $qr->where("nik", $nik);
        })->first();
        $s->update([
            "masa_jabatan_mulai" => request()->masa_jabatan_mulai,
            "masa_jabatan_selesai" => request()->masa_jabatan_selesai
        ]);

        return redirect(route("rt.index", $rw))->with("success", "RT berhasil diubah");
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
        return redirect(route("rt.index", $nik))->with("success", "Status RT berhasil diubah");
    }


    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn("rw", function ($row) {
                return $row->kartuKeluarga->rw;
            })
            ->addColumn("rt", function ($row) {
                return $row->kartuKeluarga->rt;
            })
            ->addColumn("masa_jabatan", function ($row) {
                content:
                $jabatan_mulai = Helpers::formatDate($row->user->masa_jabatan_mulai);
                $jabatan_selesai = Helpers::formatDate($row->user->masa_jabatan_selesai);
                return "{$jabatan_mulai} - {$jabatan_selesai} ";
            })


            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';
                $btn .= ' <a href="' . route('rt.edit', [$row->kartuKeluarga->rw, $row->nik]) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
                $message = "Apakah anda yakin mengubah status ketua rt {$row->nama_lengkap} menjadi masyarakat?";
                $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'updateStatus'}), message= '$message', url= '" . route("rt.destroy", [$row->kartuKeluarga, $row->nik]) . "'\"><i class='fa fa-trash'></i></button>";
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
