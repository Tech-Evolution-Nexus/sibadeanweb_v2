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
        Schema::table('histori_pengajuan', function (Blueprint $table) {
            $table->dropForeign(['id_pengajuan']);
            $table->foreignId("id_pengajuan")->references("id")->on("pengajuan_surat")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lampiran_surat', function (Blueprint $table) {
            //
        });
    }
};
