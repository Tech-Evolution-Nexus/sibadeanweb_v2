<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratModel extends Model
{
    protected $table = "surat";
    protected $fillable = ["nama_surat", "gambar", "format_surat"];


    public function lampiran()
    {
        return $this->belongsToMany(LampiranModel::class, "lampiran_surat");
    }
}
