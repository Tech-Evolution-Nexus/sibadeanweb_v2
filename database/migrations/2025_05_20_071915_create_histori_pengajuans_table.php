<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('histori_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_pengajuan")->references("id")->on("pengajuan_surat");
            $table->char("id_petugas", 16)->nullable();
            $table->foreign("id_petugas")->references("nik")->on("masyarakat");
            $table->string("status_pengajuan", 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_pengajuans');
    }
};
