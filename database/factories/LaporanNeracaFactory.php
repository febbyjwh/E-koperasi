<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LaporanNeracaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tanggal' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'aset' => $this->faker->numberBetween(100_000_000, 500_000_000),
            'kewajiban' => $this->faker->numberBetween(50_000_000, 300_000_000),
            'ekuitas' => $this->faker->numberBetween(50_000_000, 200_000_000),
        ];
    }
}
