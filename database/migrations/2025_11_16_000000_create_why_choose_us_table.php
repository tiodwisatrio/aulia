<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("mengapa_kami", function (Blueprint $table) {
            $table->id("mengapa_kami_id");
            $table->string("mengapa_kami_judul");
            $table->text("mengapa_kami_deskripsi")->nullable();
            $table->string("mengapa_kami_gambar")->nullable();
            $table->tinyInteger("mengapa_kami_status")->default(1);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("mengapa_kami"); }
};
