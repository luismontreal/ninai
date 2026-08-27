<?php

namespace Database\Factories;

use App\Enums\AggregationMethod;
use App\Models\Questionnaire;
use App\Models\Subscale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscale>
 */
class SubscaleFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'questionnaire_id' => Questionnaire::factory(),
            'code' => fake()->unique()->slug(2),
            'name' => [
                'en' => fake()->word(),
                'es' => fake()->word(),
            ],
            'aggregation_method' => AggregationMethod::Sum,
            'score_multiplier' => 1,
        ];
    }
}
