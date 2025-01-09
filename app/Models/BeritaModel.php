<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaModel extends Model
{
    protected $table = "berita";
    protected $fillable = ["judul", "slug", "keterangan", "konten", "gambar"];
}
