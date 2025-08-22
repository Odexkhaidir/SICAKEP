<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Month;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // SatkerSeeder::class,
            // UserSeeder::class,
            // MonthSeeder::class,
            JenisKegiatanSeeder::class,
        ]);
    }
}
