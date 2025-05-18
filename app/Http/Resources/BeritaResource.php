<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeritaResource extends JsonResource
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
            'judul' => $this->judul,
            'keterangan' => $this->keterangan,
            'konten' => $this->konten,
            'gambar' => url("/c/private-image?path=$this->gambar") ?? 'https://dummyimage.com/80x80/f2f2f2/555555&text=No+Image',
            "created_at" => $this->created_at
        ];
    }
}
