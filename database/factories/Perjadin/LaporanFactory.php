<?php

namespace Database\Factories\Perjadin;

use Illuminate\Database\Eloquent\Factories\Factory;
// use App\Models\Formulir;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'formulir_id' => Formulir::inRandomOrder()->value('id'),
            'formulir_id' => \App\Models\Perjadin\Formulir::inRandomOrder()->value('id'),
            'user_id' => \App\Models\User::whereDoesntHave('laporans', function ($query) {
                $query->where('formulir_id', $this->faker->randomElement(\App\Models\Perjadin\Formulir::pluck('id')));
            })->inRandomOrder()->value('id'),
            'file_path' => $this->faker->filePath(),
            'file_name' => $this->faker->word . '.pdf',
            'file_type' => 'application/pdf',
            'file_size' => $this->faker->numberBetween(1000, 5000000), // Size in bytes
        ];
    }
}
