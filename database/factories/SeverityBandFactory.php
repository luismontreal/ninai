<?php

namespace Database\Factories;

use App\Models\SeverityBand;
use App\Models\Subscale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SeverityBand>
 */
class SeverityBandFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subscale_id' => Subscale::factory(),
            'label' => [
                'en' => fake()->word(),
                'es' => fake()->word(),
            ],
            'min_score' => 0,
            'max_score' => 10,
            'position' => fake()->unique()->numberBetween(0, 999),
        ];
    }
}
