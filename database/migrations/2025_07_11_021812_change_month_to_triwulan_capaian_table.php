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
        Schema::table('capaian_kinerja_satker', function (Blueprint $table) {
            $table->renameColumn('realisasi', 'triwulan_1');
        });
        Schema::table('capaian_kinerja_satker', function (Blueprint $table) {
            $table->double('triwulan_2', 8, 2)->after('triwulan_1')->nullable();
            $table->double('triwulan_3', 8, 2)->after('triwulan_2')->nullable();
            $table->double('triwulan_4', 8, 2)->after('triwulan_3')->nullable();
            $table->dropColumn('bulan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('triwulan_capaian', function (Blueprint $table) {
            $table->renameColumn('triwulan_1', 'realisasi');
            $table->dropColumn('triwulan_2');
            $table->dropColumn('triwulan_3');
            $table->dropColumn('triwulan_4');
        });
    }
};