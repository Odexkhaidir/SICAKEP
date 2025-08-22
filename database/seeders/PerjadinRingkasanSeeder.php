<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerjadinRingkasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formulirs = DB::table('perjadin_formulir')->get();
        $data = [];
        $faker = \Faker\Factory::create('id_ID');
        foreach ($formulirs as $formulir) {
            $data[] = [
                'formulir_id' => $formulir->id,
                'tanggal_mulai' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'tanggal_selesai' => $faker->dateTimeBetween($data ? end($data)['tanggal_mulai'] : '-1 year', 'now')->format('Y-m-d'),
                'tujuan_supervisi' => $faker->randomElement(['Evaluasi kinerja', 'Peningkatan mutu', 'Audit internal', 'Supervisi rutin']),
                'fungsi' => $faker->randomElement(['Pengawasan', 'Pembinaan', 'Evaluasi', 'Monitoring']),
                'temuan' => $faker->sentence(8),
                'rekomendasi' => $faker->sentence(10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('perjadin_ringkasan')->insert($data);
        DB::table('perjadin_ringkasan')->insert($data);
    }
}
