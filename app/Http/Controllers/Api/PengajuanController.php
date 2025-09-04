<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengajuanResource;
use App\Models\LampiranSuratModel;
use App\Models\PengajuanSuratModel;
use App\Models\SuratModel;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Helpers;
use ResponseHelper;

class PengajuanController extends Controller
{
    public function getRiwayat()
    {
        $nikLogin = auth()->user()->masyarakat->nik;
        $baseQuery = function ($statusFilter) use ($nikLogin) {
            return PengajuanSuratModel::where(function ($query) use ($nikLogin) {
                $query->where('nik_pengaju', $nikLogin)
                    ->orWhereRaw('FIND_IN_SET(?, nik)', [$nikLogin]);
            })
                ->where($statusFilter)
                ->with(['masyarakat', 'surat', 'lampiran'])
                ->orderBy('id', 'desc')
                ->get();
        };

        $pengajuan = $baseQuery(function ($query) {
            $query->where('status', 'pending');
        });

        $pengajuanProses = $baseQuery(function ($query) {
            $query->whereIn('status', ['di_terima_rt', 'di_terima_rw']);
        });

        $pengajuanSelesai = $baseQuery(function ($query) {
            $query->where('status', 'selesai');
        });

        $pengajuanTolak = $baseQuery(function ($query) {
            $query->whereIn('status', ['di_tolak_rt', 'di_tolak_rw', 'di_tolak_lurah']);
        });

        $pengajuanBatal = $baseQuery(function ($query) {
            $query->where('status', 'dibatalkan');
        });

        return ResponseHelper::success([
            'pengajuanMenunggu' => PengajuanResource::collection($pengajuan),
            'pengajuanProses' => PengajuanResource::collection($pengajuanProses),
            'pengajuanSelesai' => PengajuanResource::collection($pengajuanSelesai),
            'pengajuanTolak' => PengajuanResource::collection($pengajuanTolak),
            'pengajuanBatal' => PengajuanResource::collection($pengajuanBatal),
        ]);
    }
    public function getRiwayatDetail($idPengajuan)
    {
        $pengajuanRaw = PengajuanSuratModel::where("id", $idPengajuan)
            ->with(["masyarakat", "surat", "lampiran", "fieldValues"])
            ->orderBy("id", "desc")
            ->first();
        $pengajuan = new PengajuanResource($pengajuanRaw);
        return ResponseHelper::success(
            $pengajuan,
        );
    }
    public function getDetailPengajuan($id)
    {
        $lampiran = SuratModel::where("id", $id)
            ->with(["lampiransurat.lampiran", "fields"])
            // ->where("status", "pending")
            ->first();


        return ResponseHelper::success([
            "surat" => $lampiran,
        ]);
    }

    public function download($id)
    {
        $data = PengajuanSuratModel::find($id);
        $html = "<style>
        @page { margin:10px 50px; }
        img{
            height:auto;
            max-width:100%;
        }
        .image-style-align-left{
            float:left;
        }
        .image-style-align-right{
            float:right;
        }
        .image-style-block-align-right{
            margin-left: auto;
            margin-right: 0;
        }
        .image-style-block-align-left{
            margin-left: 0;
            margin-right: auto;
        }
        </style>";

        $html .= $data->surat->format_surat;
        $this->replaceValue($html, $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $options = $dompdf->getOptions();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->render();
        $dompdf->stream($data->surat->nama_surat . "-" . $data->masyarakat->nama_lengkap . ".pdf", [
            "Attachment" => true // Ubah ke false jika ingin ditampilkan di browser
        ]);
    }
    private function replaceValue(&$html, $data)
    {
        $noSurat = $data->nomor_surat;
        $html = str_replace("{no_surat}", $noSurat ?? "", $html);
        $html = str_replace("{nama_surat}", $data->surat->nama_surat ?? "", $html);
        $html = str_replace("{nama}", $data->masyarakat->nama_lengkap ?? "", $html);
        $html = str_replace("{nik}", $data->masyarakat->nik ?? "", $html);
        $html = str_replace("{tempat_lahir}", $data->masyarakat->tempat_lahir ?? "", $html);
        $html = str_replace("{tanggal_lahir}", Helpers::formatDate($data->masyarakat->tanggal_lahir) ?? "", $html);
        $html = str_replace("{jenis_kelamin}", $data->masyarakat->jenis_kelamin ?? "", $html);
        $html = str_replace("{pekerjaan}", $data->masyarakat->pekerjaan ?? "", $html);
        $html = str_replace("{agama}", $data->masyarakat->agama ?? "", $html);
        $html = str_replace("{status_perkawinan}", $data->masyarakat->status_perkawinan ?? "", $html);
        $html = str_replace("{kewarganegaraan}", $data->masyarakat->kewarganegaraan ?? "", $html);
        $html = str_replace("{pendidikan}", $data->masyarakat->pendidikan ?? "", $html);
        $html = str_replace("{alamat}", $data->masyarakat->kartuKeluarga->alamat ?? "", $html);
        $html = str_replace("{rw}", $data->masyarakat->kartuKeluarga->rw ?? "", $html);
        $html = str_replace("{rt}", $data->masyarakat->kartuKeluarga->rt ?? "", $html);

        // pengaju
        $html = str_replace("{pengaju_nama}", $data->pengaju->nama_lengkap ?? "", $html);
        $html = str_replace("{pengaju_nik}", $data->pengaju->nik ?? "", $html);
        $html = str_replace("{pengaju_tempat_lahir}", $data->pengaju->tempat_lahir ?? "", $html);
        $html = str_replace("{pengaju_tanggal_lahir}", Helpers::formatDate($data->pengaju->tanggal_lahir) ?? "", $html);
        $html = str_replace("{pengaju_jenis_kelamin}", $data->pengaju->jenis_kelamin ?? "", $html);
        $html = str_replace("{pengaju_pekerjaan}", $data->pengaju->pekerjaan ?? "", $html);
        $html = str_replace("{pengaju_agama}", $data->pengaju->agama ?? "", $html);
        $html = str_replace("{pengaju_status_perkawinan}", $data->pengaju->status_perkawinan ?? "", $html);
        $html = str_replace("{pengaju_kewarganegaraan}", $data->pengaju->kewarganegaraan ?? "", $html);
        $html = str_replace("{pengaju_pendidikan}", $data->pengaju->pendidikan ?? "", $html);
        $html = str_replace("{pengaju_alamat}", $data->pengaju->kartuKeluarga->alamat ?? "", $html);
        $html = str_replace("{pengaju_rw}", $data->pengaju->kartuKeluarga->rw ?? "", $html);
        $html = str_replace("{pengaju_rt}", $data->pengaju->kartuKeluarga->rt ?? "", $html);

        if ($data->masyarakat->bapak()) {
            $html = str_replace("{nama_bapak}", $data->masyarakat->bapak()->nama_lengkap ?? "", $html);
            $html = str_replace("{nik_bapak}", $data->masyarakat->bapak()->nik ?? "", $html);
            $html = str_replace("{tempat_lahir_bapak}", $data->masyarakat->bapak()->tempat_lahir ?? "", $html);
            $html = str_replace("{tanggal_lahir_bapak}", Helpers::formatDate($data->masyarakat->bapak()->tanggal_lahir) ?? "", $html);
            $html = str_replace("{jenis_kelamin_bapak}", $data->masyarakat->bapak()->jenis_kelamin ?? "", $html);
            $html = str_replace("{pekerjaan_bapak}", $data->masyarakat->bapak()->pekerjaan ?? "", $html);
            $html = str_replace("{agama_bapak}", $data->masyarakat->bapak()->agama ?? "", $html);
            $html = str_replace("{status_perkawinan_bapak}", $data->masyarakat->bapak()->status_perkawinan ?? "", $html);
            $html = str_replace("{kewarganegaraan_bapak}", $data->masyarakat->bapak()->kewarganegaraan ?? "", $html);
            $html = str_replace("{pendidikan_bapak}", $data->masyarakat->bapak()->pendidikan ?? "", $html);
            $html = str_replace("{alamat_bapak}", $data->masyarakat->bapak()->alamat ?? "", $html);
        }

        if ($data->masyarakat->ibu()) {
            $html = str_replace("{nama_ibu}", $data->masyarakat->ibu()->nama_lengkap ?? "", $html);
            $html = str_replace("{nik_ibu}", $data->masyarakat->ibu()->nik ?? "", $html);
            $html = str_replace("{tempat_lahir_ibu}", $data->masyarakat->ibu()->tempat_lahir ?? "", $html);
            $html = str_replace("{tanggal_lahir_ibu}", Helpers::formatDate($data->masyarakat->ibu()->tanggal_lahir) ?? "", $html);
            $html = str_replace("{jenis_kelamin_ibu}", $data->masyarakat->ibu()->jenis_kelamin ?? "", $html);
            $html = str_replace("{pekerjaan_ibu}", $data->masyarakat->ibu()->pekerjaan ?? "", $html);
            $html = str_replace("{agama_ibu}", $data->masyarakat->ibu()->agama ?? "", $html);
            $html = str_replace("{status_perkawinan_ibu}", $data->masyarakat->ibu()->status_perkawinan ?? "", $html);
            $html = str_replace("{kewarganegaraan_ibu}", $data->masyarakat->ibu()->kewarganegaraan ?? "", $html);
            $html = str_replace("{pendidikan_ibu}", $data->masyarakat->ibu()->pendidikan ?? "", $html);
            $html = str_replace("{alamat_ibu}", $data->masyarakat->ibu()->alamat ?? "", $html);
        }

        $html = str_replace("{rw}", $data->masyarakat->kartuKeluarga->rw ?? "", $html);
        $html = str_replace("{rt}", $data->masyarakat->kartuKeluarga->rt ?? "", $html);
        $html = str_replace("{kecamatan}", Helpers::pengaturan()->kecamatan ?? "", $html);
        $html = str_replace("{desa}", Helpers::pengaturan()->kelurahan ?? "", $html);
        $html = str_replace("{kabupaten}", Helpers::pengaturan()->kabupaten ?? "", $html);
        $html = str_replace("{tanggal_pengajuan}", Helpers::formatDate($data->created_at) ?? "", $html);


        $lurah = User::where("role", "lurah")->where("status", 1)->whereNotNull("masa_jabatan_mulai")->first();
        // lurah
        $html = str_replace("{nama_lurah}", $lurah->petugas->nama ?? "", $html);
        $html = str_replace("{nip_lurah}", $lurah->petugas->nip ?? "", $html);
        $html = str_replace("{jabatan_lurah}", "Lurah" ?? "", $html);
        $html = str_replace("{ttd_lurah}", "<figure class='image image_resized image-style-block-align-right' style='width:21.16%;'><img style='aspect-ratio:3264/1707;' src='" . route("private.image", ["path" => $lurah->ttd]) . "'></figure>" ?? "", $html);



        foreach ($data->fields as $field) {
            $value = $this->model->fieldValues
                ->where("id_field", "=", $field->id)
                ->where("id_pengajuan", "=", $data->id_pengajuan)
                ->first();
            $namaField = "{field_" . strtolower(str_replace(" ", "_", trim($field->nama_field)) . "}");

            $html = str_replace($namaField, $value->value ?? "-", $html);
        }
    }
}
