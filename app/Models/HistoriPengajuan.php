<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriPengajuan extends Model
{
    protected $table = "histori_pengajuan";
    protected $fillable = ["id_pengajuan", "id_petugas", "status_pengajuan"];


    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSuratModel::class, "id_pengajuan");
    }
    public function petugas()
    {
        return $this->belongsTo(MasyarakatModel::class, "id_petugas");
    }
}
