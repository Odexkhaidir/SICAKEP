<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisKegiatan;
class JeniskegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenis_kegiatans = [
            "Pelatihan",
            "Workshop/Ratek/Rakor/FGD",
            "MySDI/JBBP/Bacirita",
            "Rapat",
            "Lainnya",
        ];

        foreach ($jenis_kegiatans as $jenis_kegiatan) {
            JenisKegiatan::create([
                'name' => $jenis_kegiatan,
            ]);
        }
    }
}
