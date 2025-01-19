<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaModel extends Model
{
    use HasFactory;
    protected $table = "berita";
    protected $fillable = ["judul", "slug", "keterangan", "konten", "gambar"];
}
