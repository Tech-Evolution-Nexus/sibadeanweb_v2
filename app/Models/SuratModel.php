<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratModel extends Model
{
    use HasFactory;
    protected $table = "surat";
    protected $fillable = ["nama_surat", "singkata_nama_surat", "gambar", "format_surat"];


    public function lampiransurat()
    {
        return $this->hasMany(LampiranSuratModel::class, "id_surat");
    }

    // Define a relationship where each Surat can have many Fields
    public function fields()
    {
        return $this->hasMany(Field::class, 'id_surat');
    }
}
