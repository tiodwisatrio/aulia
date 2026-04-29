<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("tentang", function (Blueprint $table) {
            $table->id("tentang_id");
            $table->string("tentang_judul");
            $table->text("tentang_konten");
            $table->string("tentang_gambar")->nullable();
            $table->string("tentang_status")->default("aktif");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("tentang");
    }
};
