<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = "fields";
    protected $fillable = ["id_surat", "nama_field"];
    public function surat()
    {
        return $this->belongsTo(SuratModel::class, 'id_surat');
    }

    public function fieldValues()
    {
        return $this->hasMany(FieldValue::class, 'id_field');
    }
}
