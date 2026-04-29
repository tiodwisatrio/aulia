<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("layanan", function (Blueprint $table) {
            $table->id("layanan_id");
            $table->string("layanan_nama");
            $table->text("layanan_deskripsi")->nullable();
            $table->string("layanan_gambar")->nullable();
            $table->tinyInteger("layanan_status")->default(1);
            $table->integer("layanan_urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("layanan"); }
};
