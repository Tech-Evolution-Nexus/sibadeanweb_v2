<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldValue extends Model
{
    protected $table = "field_values";
    protected $fillable = ["id_field", "id_pengajuan", "value"];

     public function field()
    {
        return $this->belongsTo(Field::class, 'id_field');
    }
}
