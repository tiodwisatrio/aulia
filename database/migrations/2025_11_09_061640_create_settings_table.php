<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("pengaturan", function (Blueprint $table) {
            $table->id("pengaturan_id");
            $table->string("pengaturan_kunci")->unique();
            $table->text("pengaturan_nilai")->nullable();
            $table->string("pengaturan_tipe")->default("text");
            $table->string("pengaturan_grup")->default("umum");
            $table->string("pengaturan_label")->nullable();
            $table->text("pengaturan_deskripsi")->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("pengaturan"); }
};
