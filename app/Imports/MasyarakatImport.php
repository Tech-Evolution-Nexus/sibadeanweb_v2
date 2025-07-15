<?php

namespace App\Imports;

use App\Models\KartuKeluargaModel;
use App\Models\MasyarakatModel;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MasyarakatImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $data)
    {
        // Ubah ke lowercase untuk field tertentu agar cocok dengan Rule::in() case-insensitive
        $data['jenis_kelamin'] = strtolower($data['jenis_kelamin'] ?? '');
        $data['nik'] = strtolower($data['nik'] ?? '');
        $data['status_keluarga'] = strtolower($data['status_keluarga'] ?? '');
        $data['status_perkawinan'] = str_replace(" ", "_", strtolower($data['status_perkawinan'] ?? ''));
        $data['kewarganegaraan'] = strtolower($data['kewarganegaraan'] ?? ''); // WNI/WNA diseragamkan ke UPPERCASE
        if (isset($data['tanggal_lahir']) && is_numeric($data['tanggal_lahir'])) {
            $data['tanggal_lahir'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['tanggal_lahir'])->format('Y-m-d');
        }

        if (isset($data['tanggal_perkawinan']) && is_numeric($data['tanggal_perkawinan'])) {
            $data['tanggal_perkawinan'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['tanggal_perkawinan'])->format('Y-m-d');
        }

        // Validasi manual
        $validator = Validator::make($data, [
            'nik' => [
                'required',
                'string',
                'size:16',
                // Rule::unique('masyarakat', 'nik')
            ],
            'nama_lengkap' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tempat_lahir' => 'required|string|max:70',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'golongan_darah' => 'nullable',
            'status_perkawinan' => 'required|in:belum_menikah,menikah,cerai_hidup,cerai_mati,duda,janda',
            'tanggal_perkawinan' => 'nullable|date',
            'status_keluarga' => 'required|in:kk,istri,anak,wali',
            'kewarganegaraan' => 'required|in:wni,wna',
            'no_paspor' => 'nullable|string|max:20',
            'no_kitap' => 'nullable|string|max:20',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorList = "<ul class='list-decimal ms-4'><li>" . implode("</li><li>", $errors) . "</li></ul>";

            // throw new \Exception("Validasi gagal untuk NIK {$data['nik']}: {$errorList} ");

        }

        // Logika sebelumnya tetap
        try {
            $kkModel = new KartuKeluargaModel();
            $kkExist = $kkModel->where("no_kk", $data["no_kk"])->first();
            if (!$kkExist) {
                $kkModel = KartuKeluargaModel::create([
                    "no_kk" => $data["no_kk"],
                    "alamat" => $data["alamat"],
                    "rt" => $data["rt"],
                    "rw" => $data["rw"],
                ]);
            }

            $masyarakatData = $validator->validated();
            $masyarakatData["no_kk"] = $data["no_kk"];
            $masyarakatExist = MasyarakatModel::find($data["nik"]);
            if ($masyarakatExist) {
                return $masyarakatExist->update($masyarakatData);
            } else {
                return MasyarakatModel::create($masyarakatData);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
