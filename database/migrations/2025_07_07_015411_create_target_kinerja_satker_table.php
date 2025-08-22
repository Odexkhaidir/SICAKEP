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
        Schema::create('target_kinerja_satker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('satker_id')->index();
            $table->foreign('satker_id')->references('id')->on('satkers');
            $table->smallInteger('tahun')->index();
            $table->text('indikator');
            $table->float('target')->default(0);
            $table->string('satuan')->default('Persen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_kinerja_satker');
    }
};
