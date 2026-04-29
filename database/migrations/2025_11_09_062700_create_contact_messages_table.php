<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("hubungi_kami", function (Blueprint $table) {
            $table->id("hubungi_kami_id");
            $table->string("hubungi_kami_nama");
            $table->string("hubungi_kami_email");
            $table->string("hubungi_kami_subjek");
            $table->text("hubungi_kami_pesan");
            $table->enum("hubungi_kami_status", ["baru", "dibaca", "dibalas"])->default("baru");
            $table->text("hubungi_kami_balasan_admin")->nullable();
            $table->timestamp("hubungi_kami_dibalas_pada")->nullable();
            $table->string("hubungi_kami_ip_address")->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("hubungi_kami"); }
};
