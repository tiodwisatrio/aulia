<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("klien", function (Blueprint $table) {
            $table->id("klien_id");
            $table->string("klien_nama");
            $table->string("klien_gambar")->nullable();
            $table->tinyInteger("klien_status")->default(1);
            $table->integer("klien_urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("klien"); }
};
