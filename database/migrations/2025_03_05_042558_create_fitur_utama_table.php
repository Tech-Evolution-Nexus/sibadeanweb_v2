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
        Schema::create('fitur_utama', function (Blueprint $table) {
            $table->id();
            $table->foreignId("landing_id")->references("id")->on("landing")->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("title", 70);
            $table->string("description", 150);
            $table->string("icon");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitur_utama');
    }
};
