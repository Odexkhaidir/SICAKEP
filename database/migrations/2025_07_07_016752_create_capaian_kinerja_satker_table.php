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
        Schema::create('capaian_kinerja_satker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_id')->index();
            $table->foreign('target_id')->references('id')->on('target_kinerja_satker');
            $table->unsignedTinyInteger('bulan')->index()->comment('Month value from 1 to 12');
            $table->float('realisasi')->default(0)->comment('Achievement value, default is 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capaian_kinerja_satker');
    }
};
