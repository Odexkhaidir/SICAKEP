<?php

namespace Database\Seeders;

use App\Models\Month;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Month::insert([
            [
                'id' => 1,
                'name' => 'Januari',
            ],
            [
                'id' => 2,
                'name' => 'Februari',
            ],
            [
                'id' => 3,
                'name' => 'Maret',
            ],
            [
                'id' => 4,
                'name' => 'April',
            ],
            [
                'id' => 5,
                'name' => 'Mei',
            ],
            [
                'id' => 6,
                'name' => 'Juni',
            ],
            [
                'id' => 7,
                'name' => 'Juli',
            ],
            [
                'id' => 8,
                'name' => 'Agustus',
            ],
            [
                'id' => 9,
                'name' => 'September',
            ],
            [
                'id' => 10,
                'name' => 'Oktober',
            ],
            [
                'id' => 11,
                'name' => 'November',
            ],
            [
                'id' => 12,
                'name' => 'Desember',
            ],
        ]);
    }
}
