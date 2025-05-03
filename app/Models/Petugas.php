<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = "petugas";
    protected $fillable = ["id_user", "nama", "nip"];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
