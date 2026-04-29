<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("faq", function (Blueprint $table) {
            $table->id("faq_id");
            $table->string("faq_slug")->unique();
            $table->string("faq_pertanyaan");
            $table->text("faq_jawaban")->nullable();
            $table->tinyInteger("faq_status")->default(1);
            $table->integer("faq_urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("faq"); }
};
