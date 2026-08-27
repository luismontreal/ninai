<?php

namespace Database\Factories;

use App\Models\QuestionnaireResponse;
use App\Models\Subscale;
use App\Models\SubscaleScore;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SubscaleScore>
 */
class SubscaleScoreFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'questionnaire_response_id' => QuestionnaireResponse::factory(),
            'subscale_id' => Subscale::factory(),
            'raw_score' => fake()->randomFloat(3, 0, 10),
            'severity_band_id' => null,
            'computed_at' => now(),
        ];
    }
}
