<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiturUtama extends Model
{
    protected $table = "fitur_utama";
    protected $fillable = ["landing_id", "title", "description", "icon"];
}
