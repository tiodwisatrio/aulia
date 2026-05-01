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
        Schema::table('menus', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_kategori_id')->nullable()->after('menu_deskripsi');

            $table->foreign('menu_kategori_id')
                  ->references('kategori_id')
                  ->on('kategori')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['menu_kategori_id']);
            $table->dropColumn('menu_kategori_id');
        });
    }
};
