<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ridwan Setiawan',
            'username' => 'ridwanst',
            'email' => 'ridwanst@bps.go.id',
            'password' => Hash::make('password'),
            'satker_id' => 1,
            'role' => 'admin',
        ]);
    }
}
