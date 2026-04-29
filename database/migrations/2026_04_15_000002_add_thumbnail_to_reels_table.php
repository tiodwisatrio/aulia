<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reels', function (Blueprint $table) {
            $table->string('reel_thumbnail')->nullable()->after('reel_url');
        });
    }

    public function down(): void
    {
        Schema::table('reels', function (Blueprint $table) {
            $table->dropColumn('reel_thumbnail');
        });
    }
};
