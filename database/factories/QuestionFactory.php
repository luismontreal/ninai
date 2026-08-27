<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->slug(3),
            'prompt' => [
                'en' => fake()->sentence(6),
                'es' => fake()->sentence(6),
            ],
            'question_type' => QuestionType::Scale,
        ];
    }
}
