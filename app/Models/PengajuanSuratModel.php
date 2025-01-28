<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PengajuanSuratModel extends Model
{
    protected $table = "pengajuan_surat";
    protected $fillable = ["nik", "id_surat", "keterangan", "keterangan_ditolak", "status", "nomor_surat", "pengantar_rt"];

    protected function nik(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => (string)$value,
        );
    }

    public function masyarakat()
    {
        return $this->belongsTo(MasyarakatModel::class, "nik", "nik");
    }
    public function surat()
    {
        return $this->belongsTo(SuratModel::class, "id_surat");
    }

    public function lampiran()
    {
        return $this->belongsToMany(LampiranModel::class, "lampiran_pengajuan");
    }
}
