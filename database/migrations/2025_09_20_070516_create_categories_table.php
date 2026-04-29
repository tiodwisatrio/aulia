<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('kategori_id');
            $table->string('kategori_nama');
            $table->string('kategori_tipe')->default('post');
            $table->string('kategori_slug')->unique();
            $table->text('kategori_deskripsi')->nullable();
            $table->string('kategori_warna', 7)->default('#3B82F6');
            $table->string('kategori_ikon')->nullable();
            $table->boolean('kategori_aktif')->default(true);
            $table->integer('kategori_urutan')->default(0);
            $table->timestamps();

            $table->index(['kategori_aktif', 'kategori_urutan']);
            $table->index('kategori_tipe');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
