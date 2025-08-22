<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerjadinFormulirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [];
        for ($i = 1; $i <= 1000; $i++) {
            $data[] = [
                'tahun' => 2025,
                'bulan' => ($i % 12) + 1,
                'nama_supervisi' => 'Supervisi ' . $i,
                'link' => 'https://example.com/supervisi-' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('perjadin_formulir')->insert($data);
    }
}
