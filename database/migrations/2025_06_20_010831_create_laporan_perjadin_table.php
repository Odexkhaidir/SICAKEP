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
        Schema::create('perjadin_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulir_id')->constrained('perjadin_formulir')->onDelete('cascade');
            $table->string('file_path')->nullable()->comment('Path to the uploaded report file');
            $table->string('file_name')->nullable()->comment('Original file name');
            $table->string('file_type')->nullable()->comment('MIME type of the uploaded file');
            $table->unsignedBigInteger('file_size')->nullable()->comment('Size of the uploaded file in bytes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_perjadin');
    }
};
