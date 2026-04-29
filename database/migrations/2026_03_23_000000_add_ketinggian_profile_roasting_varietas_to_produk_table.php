<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->string('produk_ketinggian')->nullable()->after('produk_origin');
            $table->string('produk_profile_roasting')->nullable()->after('produk_ketinggian');
            $table->string('produk_varietas')->nullable()->after('produk_profile_roasting');
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn(['produk_ketinggian', 'produk_profile_roasting', 'produk_varietas']);
        });
    }
};
