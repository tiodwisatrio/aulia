<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reels', function (Blueprint $table) {
            $table->id('reel_id');
            $table->string('reel_judul')->nullable();
            $table->string('reel_url');
            $table->integer('reel_urutan')->default(0);
            $table->boolean('reel_status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reels');
    }
};
