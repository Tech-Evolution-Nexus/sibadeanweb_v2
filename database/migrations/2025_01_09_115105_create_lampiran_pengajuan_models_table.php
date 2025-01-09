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
        Schema::create('lampiran_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_pengajuan")->references("id")->on("pengajuan_surat")->cascadeOnDelete();
            $table->foreignId("id_lampiran")->references("id")->on("lampiran")->cascadeOnDelete();
            $table->string("gambar");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran_pengajuan');
    }
};
