<?php

namespace Database\Factories;

use App\Enums\QuestionnaireStatus;
use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Questionnaire>
 */
class QuestionnaireFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->slug(2),
            'version' => 1,
            'title' => [
                'en' => fake()->sentence(3),
                'es' => fake()->sentence(3),
            ],
            'description' => [
                'en' => fake()->sentence(8),
                'es' => fake()->sentence(8),
            ],
            'source_citation' => fake()->sentence(6),
            'status' => QuestionnaireStatus::Draft,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => QuestionnaireStatus::Published,
            'published_at' => now(),
        ]);
    }
}
