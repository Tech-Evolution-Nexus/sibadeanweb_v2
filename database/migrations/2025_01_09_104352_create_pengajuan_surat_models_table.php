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
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->char("nik", 16);
            $table->foreign("nik")->references("nik")->on("masyarakat")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("id_surat")->references("id")->on("surat")->restrictOnDelete();
            $table->string("nomor_surat", 50)->nullable();
            $table->enum("status", ["di_terima_rt", "di_terima_rw", "di_tolak_rt", "di_tolak_rw", "selesai", "pending", "dibatalkan"])->default("pending");
            $table->string("pengantar_rt")->nullable();
            $table->string("keterangan", 70)->nullable();
            $table->string("keterangan_ditolak", 70)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};
