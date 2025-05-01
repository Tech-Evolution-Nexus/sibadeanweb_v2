<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSuratModel;
use Helpers;
use Yajra\DataTables\DataTables;

class PengajuanSuratRtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggotaKeluarga = PengajuanSuratModel::where("status", "di_terima_rt")->orderBy("created_at", "desc")->get();

        $params["data"] = (object)[
            "anggota_keluarga" => $anggotaKeluarga
        ];

        if (request()->ajax()) {
            return $this->dataTable($anggotaKeluarga);
        }
        return view("admin.pengajuan-surat.pengajuanRt", $params);
    }
    public function show($id)
    {
        $anggotaKeluarga = PengajuanSuratModel::where("status", "di_terima_rw")->where("id", $id)->first();
        if (!$anggotaKeluarga) {
            return abort(404);
            # code...
        }

        $params["data"] = (object)[
            "title" => "Pengajuan Surat","action_form"=> route("pengajuan-surat.update",$id),
            "pengajuan" => $anggotaKeluarga
        ];

        return view("admin.pengajuan-surat.form", $params);
    }
    public function updateStatus($id)
    {
        $pengajuan =     PengajuanSuratModel::find($id);

        if (!$pengajuan) {
            return redirect()->back()->with("error", "data tidak ditemukan");
        }

        $pengajuan->update(["status" => "selesai"]);
        return redirect()->route("pengajuan-surat.index")->with("success", "Pengajuan berhasil disetujui");
    }



    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';
                   $btn .= '<a href="' . route('pengajuan-surat.show', $row->id) . '" class="btn-show"><i class="fa fa-info"></i></a>';
                  // $btn .= ' <a href="' . route('anggota-keluarga.edit', [$row->no_kk, $row->nik]) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
                   $message = "Apakah anda yakin menghapus data $row->nama_lengkap?";
                //    $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'delete'}), message= '$message', url= '" . route("anggota-keluarga.destroy", [$row->no_kk, $row->nik]) . "'\"><i class='fa fa-trash'></i></button>";
                $btn .= '</div>';
                return $btn;
            })

            ->addColumn("nama_surat", function ($row) {
                return $row->surat->nama_surat;
            })

            ->addColumn("nama_masyarakat", function ($row) {
                return $row->masyarakat->nama_lengkap;
            })
            ->addColumn("rw", function ($row) {
                return $row->masyarakat->kartuKeluarga->rw;
            })
            ->addColumn("rt", function ($row) {
                return $row->masyarakat->kartuKeluarga->rt;
            })
            ->addColumn("created_at", function ($row) {
                return Helpers::formatDate($row->created_at,true);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
