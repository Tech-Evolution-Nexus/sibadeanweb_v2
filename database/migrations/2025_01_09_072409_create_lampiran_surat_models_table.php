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
        Schema::create('lampiran_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_surat")->references("id")->on("surat")->onDelete("cascade");
            $table->foreignId("id_lampiran")->references("id")->on("lampiran")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran_surat');
    }
};
