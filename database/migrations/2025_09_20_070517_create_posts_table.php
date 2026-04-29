<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id('posts_id');
            $table->string('posts_judul');
            $table->string('posts_slug')->unique();
            $table->longText('posts_konten');
            $table->longText('posts_deskripsi')->nullable();
            $table->unsignedBigInteger('posts_kategori_id')->nullable();
            $table->string('posts_gambar_utama')->nullable();
            $table->json('posts_dokumen')->nullable();
            $table->decimal('posts_harga', 12, 2)->nullable();
            $table->enum('posts_status', ['aktif', 'nonaktif'])->default('aktif');
            $table->date('posts_tanggal_publish')->nullable();
            $table->datetime('posts_tanggal_acara')->nullable();
            $table->datetime('posts_batas_waktu')->nullable();
            $table->integer('posts_jumlah_lihat')->default(0);
            $table->boolean('posts_unggulan')->default(false);
            $table->unsignedBigInteger('posts_pengguna_id');
            $table->timestamps();

            $table->foreign('posts_kategori_id')->references('kategori_id')->on('kategori')->onDelete('set null');
            $table->foreign('posts_pengguna_id')->references('id')->on('users')->onDelete('cascade');

            $table->index('posts_slug');
            $table->index(['posts_status', 'posts_tanggal_publish']);
            $table->index(['posts_kategori_id', 'posts_status']);
            $table->index('posts_unggulan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
