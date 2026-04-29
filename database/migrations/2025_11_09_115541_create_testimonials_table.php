<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("testimoni", function (Blueprint $table) {
            $table->id("testimoni_id");
            $table->string("testimoni_nama");
            $table->text("testimoni_isi");
            $table->string("testimoni_gambar")->nullable();
            $table->tinyInteger("testimoni_status")->default(1);
            $table->integer("testimoni_urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("testimoni"); }
};
