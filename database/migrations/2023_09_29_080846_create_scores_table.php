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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id');
            $table->foreignId('satker_id');
            $table->foreignId('month_id');
            $table->year('year');
            $table->decimal('realization_score')->nullable(true);
            $table->decimal('time_score')->nullable(true);
            $table->decimal('quality_score')->nullable(true);
            $table->string('note')->nullable(true);
            $table->timestamps();
            $table->string('created_by');
            $table->string('edited_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
