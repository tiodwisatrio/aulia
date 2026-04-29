<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tentang', function (Blueprint $table) {
            $table->string('tentang_jumlah_origin')->nullable()->after('tentang_gambar');
            $table->string('tentang_jumlah_pelanggan')->nullable()->after('tentang_jumlah_origin');
            $table->string('tentang_jumlah_fresh_roast')->nullable()->after('tentang_jumlah_pelanggan');
            $table->string('tentang_tahun_berdiri')->nullable()->after('tentang_jumlah_fresh_roast');
        });
    }

    public function down(): void
    {
        Schema::table('tentang', function (Blueprint $table) {
            $table->dropColumn([
                'tentang_jumlah_origin',
                'tentang_jumlah_pelanggan',
                'tentang_jumlah_fresh_roast',
                'tentang_tahun_berdiri',
            ]);
        });
    }
};
