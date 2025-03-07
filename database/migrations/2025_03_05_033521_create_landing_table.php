<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('landing', function (Blueprint $table) {
            $table->id();
            $table->string("hero_title");
            $table->string("hero_description");
            $table->string("hero_img");
            $table->string("about_title");
            $table->string("about_description");
            $table->string("about_img");
            $table->string("demo_url");
            $table->string("mobile_link");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing');
    }
};
