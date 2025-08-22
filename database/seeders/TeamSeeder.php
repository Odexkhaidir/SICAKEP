<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'id',
                'name',
                'satker_id',
                'leader_id',
                'year'
            ],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
