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
        Schema::create('hasil_vikors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alternatif_id'); // Tanpa foreign key dulu
            $table->string('judul');
            $table->float('S');
            $table->float('R');
            $table->float('Q');
            $table->integer('rank');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_vikors');
    }
};
