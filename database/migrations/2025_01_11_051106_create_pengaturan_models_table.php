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
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->boolean("hasRw");
            $table->string("primary_color", 10);
            $table->string("secondary_color", 10);
            $table->string("logo_horizontal");
            $table->string("logo");
            $table->string("kelurahan", 50);
            $table->string("kode_pos", 5);
            $table->string("kabupaten", 50);
            $table->string("kecamatan", 50);
            $table->string("provinsi", 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
