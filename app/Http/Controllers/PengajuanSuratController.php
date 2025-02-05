<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSuratModel;
use Illuminate\Http\Request;

class PengajuanSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggotaKeluarga = PengajuanSuratModel::where("status", "diterima RW")->orderBy("created_at", "desc")->get();

        $params["data"] = (object)[
            "anggota_keluarga" => $anggotaKeluarga
        ];


        if (request()->ajax()) {
            return $this->dataTable($anggotaKeluarga);
        }
        return view("admin.pengajuan-surat.pengajuan", $params);

    }
public function updateStatus($id){
$pengajuan =     PengajuanSuratModel::find($id);

        if(!$pengajuan){
        return redirect()->back()->with("error","data tidak ditemukan");
    }

    $pengajuan->update(["status"=>"selesai"]);
    return redirect()->back()->with("success","Pengajuan berhasil disetujui");



}



   public function dataTable($data)
   {
       return DataTables::of($data)
           ->addIndexColumn()
           ->addColumn('action', function ($row) {
               $btn = '<div class="row flex">';
            //    $btn .= '<a href="' . route('pengajuan-surat.edit.show', [$row->no_kk, $row->nik]) . '" class="btn-show"><i class="fa fa-info"></i></a>';
            //    $btn .= ' <a href="' . route('anggota-keluarga.edit', [$row->no_kk, $row->nik]) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
            //    $message = "Apakah anda yakin menghapus data $row->nama_lengkap?";
            //    $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'delete'}), message= '$message', url= '" . route("anggota-keluarga.destroy", [$row->no_kk, $row->nik]) . "'\"><i class='fa fa-trash'></i></button>";
            //    $btn .= '</div>';
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
           ->rawColumns(['action'])
           ->make(true);
   }
}
