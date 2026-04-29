<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("agenda", function (Blueprint $table) {
            $table->id("agenda_id");
            $table->string("agenda_judul");
            $table->string("agenda_slug")->unique();
            $table->text("agenda_deskripsi")->nullable();
            $table->string("agenda_lokasi");
            $table->dateTime("agenda_tanggal_mulai");
            $table->dateTime("agenda_tanggal_selesai")->nullable();
            $table->string("agenda_gambar")->nullable();
            $table->tinyInteger("agenda_status")->default(1);
            $table->integer("agenda_urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("agenda"); }
};
