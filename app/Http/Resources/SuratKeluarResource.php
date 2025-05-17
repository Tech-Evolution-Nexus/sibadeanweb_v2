<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuratKeluarResource extends JsonResource
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
            'title' => $this->title,
            'nama_file' => url("/c/private-image?path=surat_keluar/$this->nama_file") ?? $this->nama_file,
            'exp_date' => $this->exp_date,
        ];
    }
}
