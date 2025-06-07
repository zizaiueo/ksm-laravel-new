<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id');
            $table->string('periode');
            $table->integer('tarif_per_m3');
            $table->integer('jumlah_tagihan')->default(0);
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->unique(['pelanggan_id', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
