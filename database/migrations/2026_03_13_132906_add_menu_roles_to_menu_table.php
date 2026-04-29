<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->json('menu_roles')->nullable()->after('menu_status');
        });

        // Default: semua role bisa melihat semua menu yang sudah ada
        DB::table('menu')->update([
            'menu_roles' => json_encode(['admin', 'super_admin', 'developer']),
        ]);
    }

    public function down(): void
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropColumn('menu_roles');
        });
    }
};
