<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasyarakatModel extends Model
{
    use HasFactory;
    protected $table = "masyarakat";
    protected $primaryKey = 'nik';
    public $incrementing = false;

    protected $fillable = [
        'nik',
        'id_user',
        'no_kk',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
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

    protected function noKk(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => (string)$value,
        );
    }
    protected function nik(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => (string)$value,
        );
    }

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluargaModel::class, "no_kk");
    }
    public function user()
    {
        return $this->belongsTo(User::class, "id_user");
    }
}
