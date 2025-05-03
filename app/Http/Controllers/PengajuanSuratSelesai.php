<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSuratModel;
use Helpers;

class PengajuanSuratSelesai extends Controller
{
    public function index()
    {
        $anggotaKeluarga = PengajuanSuratModel::where("status", "selesai")->orderBy("created_at", "desc")->get();

        $params["data"] = (object)[
            "anggota_keluarga" => $anggotaKeluarga
        ];

        if (request()->ajax()) {
            return $this->dataTable($anggotaKeluarga);
        }
        return view("admin.pengajuan-surat.selesai", $params);
    }
    public function show($id)
    {
        $anggotaKeluarga = PengajuanSuratModel::where("status", "selesai")->where("id", $id)->first();
        if (!$anggotaKeluarga) {
            return abort(404);
        }

        $params["data"] = (object)[
            "title" => "Pengajuan Surat","action_form"=> route("pengajuan-surat.update",$id),
            "pengajuan" => $anggotaKeluarga
        ];

        return view("admin.pengajuan-surat.form", $params);
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
    private function replaceValue(&$html, $data)
    {
        $noSurat = $data->nomor_surat;
        $html = str_replace("{no_surat}", $noSurat ?? "", $html);
        $html = str_replace("{nama}", $data->nama_lengkap ?? "", $html);
        $html = str_replace("{nik}", $data->nik ?? "", $html);
        $html = str_replace("{tempat_lahir}", $data->tempat_lahir ?? "", $html);
        $html = str_replace("{tanggal_lahir}", $data->tgl_lahir ?? "", $html);
        $html = str_replace("{jenis_kelamin}", $data->jenis_kelamin ?? "", $html);
        $html = str_replace("{pekerjaan}", $data->pekerjaan ?? "", $html);
        $html = str_replace("{agama}", $data->agama ?? "", $html);
        $html = str_replace("{status_perkawinan}", $data->status_perkawinan ?? "", $html);
        $html = str_replace("{kewarganegaraan}", $data->kewarganegaraan ?? "", $html);
        $html = str_replace("{pendidikan}", $data->pendidikan ?? "", $html);
        $html = str_replace("{alamat}", $data->alamat ?? "", $html);
        $html = str_replace("{rw}", $data->rw ?? "", $html);

        if ($data->bapak) {
            $html = str_replace("{nama_bapak}", $data->bapak->nama_lengkap ?? "", $html);
            $html = str_replace("{nik_bapak}", $data->bapak->nik ?? "", $html);
            $html = str_replace("{tempat_lahir_bapak}", $data->bapak->tempat_lahir ?? "", $html);
            $html = str_replace("{tanggal_lahir_bapak}", $data->bapak->tgl_lahir ?? "", $html);
            $html = str_replace("{jenis_kelamin_bapak}", $data->bapak->jenis_kelamin ?? "", $html);
            $html = str_replace("{pekerjaan_bapak}", $data->bapak->pekerjaan ?? "", $html);
            $html = str_replace("{agama_bapak}", $data->bapak->agama ?? "", $html);
            $html = str_replace("{status_perkawinan_bapak}", $data->bapak->status_perkawinan ?? "", $html);
            $html = str_replace("{kewarganegaraan_bapak}", $data->bapak->kewarganegaraan ?? "", $html);
            $html = str_replace("{pendidikan_bapak}", $data->bapak->pendidikan ?? "", $html);
            $html = str_replace("{alamat_bapak}", $data->bapak->alamat ?? "", $html);
        }

        if ($data->ibu) {
            $html = str_replace("{nama_ibu}", $data->ibu->nama_lengkap ?? "", $html);
            $html = str_replace("{nik_ibu}", $data->ibu->nik ?? "", $html);
            $html = str_replace("{tempat_lahir_ibu}", $data->ibu->tempat_lahir ?? "", $html);
            $html = str_replace("{tanggal_lahir_ibu}", $data->ibu->tgl_lahir ?? "", $html);
            $html = str_replace("{jenis_kelamin_ibu}", $data->ibu->jenis_kelamin ?? "", $html);
            $html = str_replace("{pekerjaan_ibu}", $data->ibu->pekerjaan ?? "", $html);
            $html = str_replace("{agama_ibu}", $data->ibu->agama ?? "", $html);
            $html = str_replace("{status_perkawinan_ibu}", $data->ibu->status_perkawinan ?? "", $html);
            $html = str_replace("{kewarganegaraan_ibu}", $data->ibu->kewarganegaraan ?? "", $html);
            $html = str_replace("{pendidikan_ibu}", $data->ibu->pendidikan ?? "", $html);
            $html = str_replace("{alamat_ibu}", $data->ibu->alamat ?? "", $html);
        }


        $html = str_replace("{rw}", $data->rw ?? "", $html);
        $html = str_replace("{rt}", $data->rt ?? "", $html);
        $html = str_replace("{kecamatan}", $data->kecamatan ?? "", $html);
        $html = str_replace("{desa}", $data->kelurahan ?? "", $html);
        $html = str_replace("{kabupaten}", $data->kabupaten ?? "", $html);
        $html = str_replace("{tanggal_pengajuan}", formatDate($data->created_at) ?? "", $html);


        foreach ($data->fields as $field) {
            $value = $this->model->fieldValues
                ->where("id_field", "=", $field->id)
                ->where("id_pengajuan", "=", $data->id_pengajuan)
                ->first();
            $namaField = "{field_" . strtolower(str_replace(" ", "_", trim($field->nama_field)) . "}");

            $html = str_replace($namaField,  $value->value ?? "-", $html);
        }
    }
}
