<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('produk_id');
            $table->string('produk_nama');
            $table->string('produk_slug')->unique();
            $table->text('produk_deskripsi')->nullable();
            $table->decimal('produk_harga', 10, 2);
            $table->decimal('produk_harga_diskon', 10, 2)->nullable();
            $table->string('produk_sku')->unique();
            $table->integer('produk_stok')->default(0);
            $table->integer('produk_stok_minimum')->default(0);
            $table->string('produk_status')->default('aktif'); // aktif, nonaktif, habis
            $table->string('produk_gambar_utama')->nullable();
            $table->json('produk_galeri')->nullable();
            $table->json('produk_spesifikasi')->nullable();
            $table->decimal('produk_berat', 8, 2)->nullable();
            $table->string('produk_dimensi')->nullable();
            $table->boolean('produk_unggulan')->default(false);
            $table->boolean('produk_pantau_stok')->default(true);
            $table->text('produk_meta_deskripsi')->nullable();
            $table->string('produk_meta_kata_kunci')->nullable();
            $table->integer('produk_jumlah_lihat')->default(0);
            $table->integer('produk_jumlah_order')->default(0);
            $table->unsignedBigInteger('produk_kategori_id');
            $table->unsignedBigInteger('produk_pengguna_id');
            $table->timestamps();

            $table->foreign('produk_kategori_id')->references('kategori_id')->on('kategori')->onDelete('cascade');
            $table->foreign('produk_pengguna_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['produk_status', 'produk_unggulan']);
            $table->index('produk_kategori_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
