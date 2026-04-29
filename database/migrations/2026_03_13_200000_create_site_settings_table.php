<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            // Identitas
            $table->string('site_name')->nullable();
            $table->string('site_name_alt')->nullable();
            $table->text('site_address')->nullable();
            // Kontak
            $table->string('site_phone')->nullable();
            $table->string('site_fax')->nullable();
            $table->string('site_mobile')->nullable();
            $table->string('site_email')->nullable();
            $table->string('site_whatsapp')->nullable();
            // Media Sosial
            $table->string('site_instagram')->nullable();
            $table->string('site_youtube')->nullable();
            $table->string('site_tiktok')->nullable();
            $table->string('site_twitter')->nullable();
            // Lainnya
            $table->text('site_map')->nullable();
            $table->text('site_description')->nullable();
            // File / Gambar
            $table->string('site_logo')->nullable();       // logo_atas
            $table->string('site_logo_dark')->nullable();  // logo_bawah
            $table->string('site_icon')->nullable();       // favicon
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
