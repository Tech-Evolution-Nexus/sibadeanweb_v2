<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanModel extends Model
{
    protected $table = "pengaturan";
    protected $fillable = ["hasRw", "primary_color", "secondary_color", "logo_horizontal", "logo", "kelurahan", "kode_pos", "kabupaten", "kecamatan", "provinsi"];
    protected $primaryKey = "id";
}
