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
        Schema::table('fields', function (Blueprint $table) {
            if (!Schema::hasColumn('fields', 'id_surat')) {
                $table->foreignId('id_surat')->nullable()->constrained('surat')->onDelete('cascade');
            } else {
                // Jika sudah ada kolom, baru tambahkan foreign key
                $table->foreign('id_surat')->references('id')->on('surat')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fields', function (Blueprint $table) {
            //
        });
    }
};
