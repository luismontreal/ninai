<?php

namespace Database\Factories;

use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponse;
use App\Models\QuestionResponse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionResponse>
 */
class QuestionResponseFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'questionnaire_response_id' => QuestionnaireResponse::factory(),
            'questionnaire_question_id' => QuestionnaireQuestion::factory(),
            'selected_option_id' => null,
            'value_numeric' => fake()->numberBetween(0, 3),
            'answered_at' => now(),
        ];
    }
}
