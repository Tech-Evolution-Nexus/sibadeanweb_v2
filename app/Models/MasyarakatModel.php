<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasyarakatModel extends Model
{
    protected $table = "masyarakat";
    protected $fillable = [
        'nik',
        'id_user',
        'no_kk',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'agama',
        'pendidikan',
        'pekerjaan',
        'golongan_darah',
        'status_perkawinan',
        'tanggal_perkawinan',
        'status_keluarga',
        'kewarganegaraan',
        'no_paspor',
        'no_kitap',
        'nama_ayah',
        'nama_ibu',
    ];


    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluargaModel::class, "no_kk");
    }
    public function user()
    {
        return $this->belongsTo(User::class, "id_user");
    }
}
