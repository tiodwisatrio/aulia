<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("tim", function (Blueprint $table) {
            $table->id("tim_id");
            $table->string("tim_nama");
            $table->unsignedBigInteger("tim_kategori_id");
            $table->string("tim_gambar")->nullable();
            $table->text("tim_deskripsi")->nullable();
            $table->tinyInteger("tim_status")->default(1);
            $table->timestamps();
            $table->foreign("tim_kategori_id")->references("kategori_id")->on("kategori")->onDelete("cascade");
        });
    }
    public function down(): void { Schema::dropIfExists("tim"); }
};
