<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->integer('produk_ukuran')->nullable()->after('produk_berat');
            $table->string('produk_origin')->nullable()->after('produk_ukuran');
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn(['produk_ukuran', 'produk_origin']);
        });
    }
};
