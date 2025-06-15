<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Landing extends Model
{
    protected $table = "landing";
    protected $fillable = ["hero_title", "hero_description", "hero_img", "about_title", "about_description", "about_img", "demo_url", "mobile_link","app_type"];

    public function fiturUtama()
    {
        return $this->hasMany(FiturUtama::class, "landing_id");
    }
}
