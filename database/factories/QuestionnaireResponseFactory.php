<?php

namespace Database\Factories;

use App\Enums\ResponseStatus;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionnaireResponse>
 */
class QuestionnaireResponseFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'questionnaire_id' => Questionnaire::factory(),
            'user_id' => User::factory(),
            'administered_by' => null,
            'status' => ResponseStatus::InProgress,
            'started_at' => now(),
            'completed_at' => null,
            'notes' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ResponseStatus::Completed,
            'completed_at' => now(),
        ]);
    }
}
