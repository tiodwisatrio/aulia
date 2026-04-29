<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'produk_process')) {
                $table->string('produk_process', 100)->nullable()->after('produk_varietas');
            }
            if (!Schema::hasColumn('produk', 'produk_roast_date')) {
                $table->date('produk_roast_date')->nullable()->after('produk_process');
            }
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn(['produk_process', 'produk_roast_date']);
        });
    }
};
