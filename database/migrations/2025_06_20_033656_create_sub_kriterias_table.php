<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_kriterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->integer('batas_awal');
            $table->integer('batas_akhir')->nullable(); // nullable untuk Tahun Terbit
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_kriterias');
    }
};
