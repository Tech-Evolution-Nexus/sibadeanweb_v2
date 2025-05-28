<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengajuanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "nik" => $this->nik,
            "id_surat" => $this->id_surat,
            "keterangan" => $this->keterangan,
            "keterangan_ditolak" => $this->keterangan_ditolak,
            "status" => $this->status,
            "nomor_surat" => $this->nomor_surat,
            "pengantar_rt" => url("/c/private-image?path=$this->pengantar_rt"),
            "created_at" => $this->created_at,
            "masyarakat" => $this->masyarakat,
            "surat" => $this->surat,
            "lampiran" => LampiranResource::collection($this->lampiran),
            "fieldValues" => FieldValuesResource::collection($this->fieldValues),

        ];
    }
}
