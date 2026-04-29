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
        Schema::create('module_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('module_name')->comment('Nama modul, misal: posts, products');
            $table->string('module_label')->comment('Label tampilan, misal: Posts, Products');
            $table->json('allowed_roles')->comment('Array role yang boleh akses, misal: ["admin","super_admin","developer"]');
            $table->timestamps();

            $table->unique('module_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_permissions');
    }
};
