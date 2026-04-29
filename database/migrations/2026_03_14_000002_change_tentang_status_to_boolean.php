<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing string values to 1/0
        DB::table('tentang')->where('tentang_status', 'aktif')->update(['tentang_status' => '1']);
        DB::table('tentang')->where('tentang_status', 'nonaktif')->update(['tentang_status' => '0']);

        Schema::table('tentang', function (Blueprint $table) {
            $table->boolean('tentang_status')->default(1)->change();
        });
    }

    public function down(): void
    {
        Schema::table('tentang', function (Blueprint $table) {
            $table->string('tentang_status')->default('aktif')->change();
        });
    }
};
