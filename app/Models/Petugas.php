<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = "petugas";
    protected $fillable = ["id_user","nama","nip","masa_jabatan_mulai","masa_jabatan_selesai"];
}
