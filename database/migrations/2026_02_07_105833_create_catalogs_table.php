<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("katalog", function (Blueprint $table) {
            $table->id("katalog_id");
            $table->string("katalog_slug")->unique();
            $table->string("katalog_judul");
            $table->text("katalog_deskripsi")->nullable();
            $table->string("katalog_gambar")->nullable();
            $table->tinyInteger("katalog_status")->default(1);
            $table->integer("katalog_urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("katalog"); }
};
