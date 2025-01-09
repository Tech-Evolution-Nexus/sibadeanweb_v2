<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranPengajuanModel extends Model
{
    protected $table = "lampiran_pengajuan";
    protected $fillable = ["id_pengajuan", "id_lampiran", "gambar"];
}
