<?php

namespace App\Http\Controllers;

use App\Models\HistoriPengajuan;
use App\Models\PengajuanSuratModel;
use App\Models\User;
use Dompdf\Dompdf;
use Helpers;
use TCPDF;
use Yajra\DataTables\DataTables;

class PengajuanSuratController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = match (request()->status ?? "menunggu") {
            "selesai" => "selesai",
            "menunggu" => "di_terima_rw",
            "di_terima_rt" => "di_terima_rt",
        };
        $anggotaKeluarga = PengajuanSuratModel::where("status", $status)->orderBy("created_at", "desc")->get();

        $params["data"] = (object) [
            "anggota_keluarga" => $anggotaKeluarga
        ];

        if (request()->ajax()) {
            return $this->dataTable($anggotaKeluarga, $status);
        }
        return view("admin.pengajuan-surat.pengajuan", $params);
    }
    public function show($id)
    {
        $pengajuan = PengajuanSuratModel::find($id);
        if (!$pengajuan) {
            return abort(404);
        }

        $html = $pengajuan->surat->format_surat;
        // dd($data->surat);
        $this->replaceValue($html, $pengajuan);
        $pengajuan->surat->format_surat = $html;

        $params["data"] = (object) [
            "title" => "Pengajuan Surat",
            "action_form" => route("pengajuan-surat.update", $id),
            "pengajuan" => $pengajuan
        ];

        return view("admin.pengajuan-surat.form", $params);
    }
    public function updateStatus($id)
    {
        $pengajuan = PengajuanSuratModel::find($id);

        if (!$pengajuan) {
            return redirect()->back()->with("error", "data tidak ditemukan");
        }

        $pengajuan->update(["status" => "selesai"]);
        HistoriPengajuan::create([
            "id_pengajuan" => $id,
            // "id_petugas" => auth()->user()->masyarakat->nik,
            "status_pengajuan" => "selesai"
        ]);

        return redirect()->route("pengajuan-surat.index")->with("success", "Pengajuan berhasil disetujui");
    }

    // public function download($id)
    // {
    //     $data = PengajuanSuratModel::find($id);
    //     $html = "<style>
    //     @page { margin:10px 50px; }
    //     img{
    //         height:auto;
    //         max-width:100%;
    //     }
    //     .image-style-align-left{
    //         float:left;
    //     }
    //     .image-style-align-right{
    //         float:right;
    //     }
    //     .image-style-block-align-right{
    //         margin-left: auto;
    //         margin-right: 0;
    //     }
    //     .image-style-block-align-left{
    //         margin-left: 0;
    //         margin-right: auto;
    //     }
    //     </style>";

    //     $html .= $data->surat->format_surat;
    //     // dd($data->surat);
    //     $this->replaceValue($html, $data);
    //     $dompdf = new Dompdf();
    //     // $html = preg_replace(
    //     //     '/src="[^"]*assets\/images\//',
    //     //     'src="' . asset('assets/images') . '/',
    //     //     $html
    //     // );

    //     // echo "<pre>";
    //     // print_r($html);
    //     // echo "</pre>";
    //     // exit;
    //     $options = $dompdf->getOptions();
    //     $options->set('isHtml5ParserEnabled', true);
    //     $options->set('isRemoteEnabled', true);
    //     $dompdf->getOptions()->setChroot(public_path("assets/images"));
    //     $dompdf->setOptions($options);
    //     $dompdf->loadHtml($html);
    //     $dompdf->setPaper('A4', 'portrait');
    //     $dompdf->render();

    //     $dompdf->stream($data->surat->nama_surat . ".pdf", [
    //         "Attachment" => false // Ubah ke false jika ingin ditampilkan di browser
    //     ]);
    // }

    public function download($id)
    {
        $data = PengajuanSuratModel::find($id);

        // Siapkan HTML (pastikan gambar sudah absolute path/public URL)
        $html = '
        <style>
            img {
                height: auto;
                max-width: 100%;
            }
            .image-style-align-left { float: left; }
            .image-style-align-right { float: right; }
            .image-style-block-align-right { margin-left: auto; margin-right: 0; }
            .image-style-block-align-left { margin-left: 0; margin-right: auto; }
        </style>
    ';

        $html .= $data->surat->format_surat;

        $this->replaceValue($html, $data);

        // Replace src path agar sesuai domain atau path lokal publik
        $html = preg_replace_callback('/src="([^"]+)"/', function ($matches) {
            $src = $matches[1];

            if (strpos($src, '/assets/images/') !== false) {
                $filename = basename($src);
                $fullPath = ("assets/images/{$filename}");

                if (file_exists($fullPath)) {
                    return 'src="' . url($fullPath) . '"';
                } else {
                    logger("Gambar tidak ditemukan: " . $fullPath);
                    return ''; // hapus gambar jika tidak ditemukan
                }
            }

            return 'src="' . $src . '"';
        }, $html);
        // dd($html);

        // Inisialisasi TCPDF
        $pdf = new TCPDF();
        $pdf->SetCreator('Laravel');
        $pdf->SetAuthor('Sistem');
        $pdf->SetTitle('Surat');
        $pdf->SetMargins(15, 10, 15);
        $pdf->AddPage();

        // Write HTML
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF
        $pdf->Output($data->surat->nama_surat . '.pdf', 'I'); // 'I' = inline, 'D' = download
    }
    private function replaceValue(&$html, $data)
    {
        $noSurat = $data->nomor_surat;
        $html = str_replace("{no_surat}", $noSurat ?? "", $html);
        $html = str_replace("{nama_surat}", $data->surat->nama_surat ?? "", $html);
        $html = str_replace("{nama}", $data->masyarakat->nama_lengkap ?? "", $html);
        $html = str_replace("{nik}", $data->masyarakat->nik ?? "", $html);
        $html = str_replace("{tempat_lahir}", $data->masyarakat->tempat_lahir ?? "", $html);
        $html = str_replace("{tanggal_lahir}", $data->masyarakat->tgl_lahir ?? "", $html);
        $html = str_replace("{jenis_kelamin}", $data->masyarakat->jenis_kelamin ?? "", $html);
        $html = str_replace("{pekerjaan}", $data->masyarakat->pekerjaan ?? "", $html);
        $html = str_replace("{agama}", $data->masyarakat->agama ?? "", $html);
        $html = str_replace("{status_perkawinan}", $data->masyarakat->status_perkawinan ?? "", $html);
        $html = str_replace("{kewarganegaraan}", $data->masyarakat->kewarganegaraan ?? "", $html);
        $html = str_replace("{pendidikan}", $data->masyarakat->pendidikan ?? "", $html);
        $html = str_replace("{alamat}", $data->masyarakat->kartuKeluarga->alamat ?? "", $html);
        $html = str_replace("{rw}", $data->masyarakat->kartuKeluarga->rw ?? "", $html);

        if ($data->masyarakat->bapak()) {
            $html = str_replace("{nama_bapak}", $data->masyarakat->bapak()->nama_lengkap ?? "", $html);
            $html = str_replace("{nik_bapak}", $data->masyarakat->bapak()->nik ?? "", $html);
            $html = str_replace("{tempat_lahir_bapak}", $data->masyarakat->bapak()->tempat_lahir ?? "", $html);
            $html = str_replace("{tanggal_lahir_bapak}", $data->masyarakat->bapak()->tgl_lahir ?? "", $html);
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
            $html = str_replace("{tanggal_lahir_ibu}", $data->masyarakat->ibu()->tgl_lahir ?? "", $html);
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


        foreach ($data->fieldValues as $field) {
            $value = $field->value;
            $namaField = "{" . $field->fields->nama_field . "}";
            // $namaField = "{field_" . strtolower(str_replace(" ", "_", trim($field->nama_field)) . "}");

            $html = str_replace($namaField, $value->value ?? "-", $html);
        }
    }

    public function dataTable($data, $status)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($status) {
                $btn = '<div class="row flex">';
                $btn .= '<a href="' . route('pengajuan-surat.show', $row->id) . '" class="btn-show ' . ($status == 'selesai' ? '' : 'rounded-md') . '"><i class="fa fa-info"></i></a>';

                if ($status === "selesai") {
                    $btn .= ' <a href="' . route('pengajuan-surat.download', $row->id) . '" class="btn-edit rounded-md rounded-s-none"><i class="fa fa-download"></i></a>';
                }
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
                return Helpers::formatDate($row->created_at, true);
            })
            ->addColumn("status", function ($row) {
                $classStatus = str_contains("tolak", $row->status) ? "bg-red-500 text-white" : "bg-green-500 text-white";
                $status = match ($row->status) {
                    "di_terima_rw" => "Disetujui Rw",
                    "di_terima_rt" => "Disetujui Rt",
                    "selesai" => "Selesai",
                    "di_tolak_rw" => "Ditolak Rw",
                    "di_tolak_rt" => "Ditolak Rt",
                    "dibatalkan" => "Dibatalkan",
                };
                return "<span class='px-2 py-1 rounded-full {$classStatus}'>{$status}</span>";
            })
            ->rawColumns(['action', "status"])
            ->make(true);
    }
}
