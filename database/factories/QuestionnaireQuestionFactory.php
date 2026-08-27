<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionnaireQuestion>
 */
class QuestionnaireQuestionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'questionnaire_id' => Questionnaire::factory(),
            'question_id' => Question::factory(),
            'position' => fake()->unique()->numberBetween(0, 999),
            'is_required' => true,
            'reverse_scored' => false,
            'weight' => 1,
            'subscale_id' => null,
        ];
    }

    public function reverseScored(): static
    {
        return $this->state(fn (array $attributes) => [
            'reverse_scored' => true,
        ]);
    }
}
