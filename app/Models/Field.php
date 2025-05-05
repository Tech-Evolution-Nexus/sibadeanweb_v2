<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = "fields";
    protected $fillable = ["id_surat","nama_field"];
}
