<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranModel extends Model
{
    protected $table = "lampiran";
    protected $fillable = ["nama_lampiran"];
    public function lampiranSurat()
    {
        return $this->hasMany(LampiranSuratModel::class, "id_lampiran");
    }
}
