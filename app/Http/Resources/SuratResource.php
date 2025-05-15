<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuratResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_surat' => $this->nama_surat,
            'singkatan_nama_surat' => $this->singkatan_nama_surat,
            'gambar' => url("/c/private-image?path=$this->gambar") ?? $this->gambar,
            'field' => $this->field ?? [],
            'lampiransurat' => $this->lampiransurat ?? [],
        ];
    }
}
