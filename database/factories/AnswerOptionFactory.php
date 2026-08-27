<?php

namespace Database\Factories;

use App\Models\AnswerOption;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AnswerOption>
 */
class AnswerOptionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'value' => fake()->unique()->numberBetween(0, 999),
            'label' => [
                'en' => fake()->word(),
                'es' => fake()->word(),
            ],
            'position' => fake()->unique()->numberBetween(0, 999),
        ];
    }
}
