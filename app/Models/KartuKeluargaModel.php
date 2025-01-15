<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class KartuKeluargaModel extends Model
{
    protected $table = "kartu_keluarga";
    protected $primaryKey = "no_kk";
    protected $fillable = ["no_kk", "alamat", "rt", "rw", "kk_gambar"];


    protected function noKk(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => (string)$value,
        );
    }

    public function masyarakat()
    {
        return $this->hasMany(MasyarakatModel::class, "no_kk", "no_kk");
    }
    public function kepalaKeluarga()
    {
        return $this->hasOne(MasyarakatModel::class, "no_kk", "no_kk")->where("status_keluarga", "kk");
    }
}
