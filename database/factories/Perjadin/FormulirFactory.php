<?php

namespace Database\Factories\Perjadin;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Perjadin\Formulir>
 */
class FormulirFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'satker_id' => \Illuminate\Support\Facades\DB::table('satkers')->inRandomOrder()->first()->id ?? 1, // Assuming satker_id is a foreign key
            'tahun' => $this->faker->year(),
            'bulan' => $this->faker->month(),
            'nama_supervisi' => $this->faker->name(),
            'link' => $this->faker->url(),
            // 'tanggal_pengajuan' => $this->faker->dateTimeThisYear(),
            // 'status' => $this->faker->randomElement(['draft', 'submitted', 'approved', 'rejected']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
