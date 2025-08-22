<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Satker;
use App\Models\TargetKinerja;

class TargetKinerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $satkers = Satker::all();

        foreach ($satkers as $satker) {
            for ($i = 1; $i <= 7; $i++) {
                TargetKinerja::create([
                    'satker_id' => $satker->id,
                    'indikator' => "Target Kinerja $i untuk {$satker->name}",
                    // Tambahkan field lain sesuai kebutuhan, misal:
                    'tahun' => 2025,
                    'target' => 90 + $i, // Contoh target, bisa disesuaikan
                    'satuan' => 'Persen', // Satuan target, bisa disesuaikan
                    // 'deskripsi' => "Deskripsi target $i",
                ]);
            }
        }
    }
}
