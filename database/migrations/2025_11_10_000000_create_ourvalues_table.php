<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("nilai_kami", function (Blueprint $table) {
            $table->id("nilai_kami_id");
            $table->string("nilai_kami_nama");
            $table->text("nilai_kami_deskripsi")->nullable();
            $table->string("nilai_kami_gambar")->nullable();
            $table->tinyInteger("nilai_kami_status")->default(1);
            $table->integer("nilai_kami_urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("nilai_kami"); }
};
