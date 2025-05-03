<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranSuratModel extends Model
{
    protected $table = "lampiran_surat";
    protected $fillable = ["id_surat", "id_lampiran"];
    public function lampiran()
    {
        return $this->belongsTo(LampiranModel::class, "id_lampiran");
    }

    // Define a relationship where each LampiranSurat belongs to one Surat
    public function surat()
    {
        return $this->belongsTo(SuratModel::class, "id_surat");
    }
}
