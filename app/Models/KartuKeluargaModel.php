<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluargaModel extends Model
{
    protected $table = "kartu_keluarga";
    protected $fillable = ["alamat", "rt", "rw", "kk_gambar"];


    public function masyarakat()
    {
        return $this->hasMany(MasyarakatModel::class, "no_kk");
    }
}
