<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LampiranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "nama_lampiran" => $this->nama_lampiran,
            'value' => url("/c/private-image?path=".$this->gambar->pivot->gambar) ?? $this->gambar,
        ];
    }
}
