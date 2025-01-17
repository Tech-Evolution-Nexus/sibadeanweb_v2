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
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->char("no_kk", 16)->primary();
            $table->string("alamat", 70);
            $table->tinyInteger("rt"); // Tidak perlu ukuran 2
            $table->tinyInteger("rw"); // Tidak perlu ukuran 2
            $table->string("kk_gambar")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_keluarga');
    }
};
