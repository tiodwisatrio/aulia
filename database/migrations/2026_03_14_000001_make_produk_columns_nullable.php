<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->decimal('produk_harga', 10, 2)->nullable()->change();
            $table->integer('produk_stok')->nullable()->default(null)->change();
            $table->integer('produk_stok_minimum')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->decimal('produk_harga', 10, 2)->nullable(false)->change();
            $table->integer('produk_stok')->nullable(false)->default(0)->change();
            $table->integer('produk_stok_minimum')->nullable(false)->default(0)->change();
        });
    }
};
