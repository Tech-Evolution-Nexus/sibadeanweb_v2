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
        Schema::create('masyarakat', function (Blueprint $table) {
            $table->string("nik", 16)->primary();
            $table->foreignId("id_user")->references("id")->on("users")->cascadeOnDelete();
            $table->string("no_kk", 16);
            $table->foreign("no_kk")->references("no_kk")->on("kartu_keluarga")->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("nama_lengkap", 50);
            $table->enum("jenis_kelamin", ["laki-laki", "perempuan"])->nullable();
            $table->string("tempat_lahir", 50)->nullable();
            $table->enum("agama", ["islam", "kristen_protestan", "kristen_katolik",  "hindu", "buddha", "konghucu", "lainnya"])->nullable();
            $table->string("pendidikan", 30)->nullable();
            $table->string("pekerjaan", 30)->nullable();
            $table->enum("golongan_darah", ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"])->nullable();
            $table->enum("status_perkawinan", ["belum_menikah", "menikah", "cerai_hidup", "cerai_mati", "duda", "janda"])->nullable();
            $table->date("tanggal_perkawinan")->nullable();
            $table->enum("status_keluarga", ["kk", "istri", "anak", "wali"])->nullable();
            $table->enum("kewarganegaraan", ["WNI", "WNA"])->nullable();
            $table->string("no_paspor", 16)->nullable();
            $table->string("no_kitap", 11)->nullable();
            $table->string("nama_ayah", 50)->nullable();
            $table->string("nama_ibu", 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masyarakat');
    }
};
