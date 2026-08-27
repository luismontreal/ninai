<?php

namespace Database\Seeders;

use App\Enums\AggregationMethod;
use App\Enums\QuestionnaireStatus;
use App\Enums\QuestionType;
use App\Enums\ResponseStatus;
use App\Models\AnswerOption;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponse;
use App\Models\QuestionResponse;
use App\Models\SeverityBand;
use App\Models\Subscale;
use App\Models\User;
use App\Services\SubscaleScoringService;
use Illuminate\Database\Seeder;

/**
 * Recreates the design doc's worked example: a 3-item scale with one
 * reverse-scored item, scoring to 2 + reverse(1 on a 0-3 scale) + 1 = 5.
 */
class QuestionnaireSeeder extends Seeder
{
    public function run(): void
    {
        $questionnaire = Questionnaire::create([
            'code' => 'demo-scale',
            'version' => 1,
            'title' => [
                'en' => 'Demo Wellbeing Scale',
                'es' => 'Escala de Bienestar Demo',
            ],
            'description' => [
                'en' => 'A minimal 3-item scale demonstrating subscale scoring with one reverse-scored item.',
                'es' => 'Una escala mínima de 3 ítems que demuestra la puntuación de subescalas con un ítem de puntuación inversa.',
            ],
            'source_citation' => 'Ninai internal worked example',
            'status' => QuestionnaireStatus::Published,
            'published_at' => now(),
        ]);

        $subscale = Subscale::create([
            'questionnaire_id' => $questionnaire->id,
            'code' => 'total',
            'name' => ['en' => 'Total', 'es' => 'Total'],
            'aggregation_method' => AggregationMethod::Sum,
            'score_multiplier' => 1,
        ]);

        SeverityBand::create(['subscale_id' => $subscale->id, 'label' => ['en' => 'Normal', 'es' => 'Normal'], 'min_score' => 0, 'max_score' => 3, 'position' => 1]);
        SeverityBand::create(['subscale_id' => $subscale->id, 'label' => ['en' => 'Moderate', 'es' => 'Moderado'], 'min_score' => 4, 'max_score' => 6, 'position' => 2]);
        SeverityBand::create(['subscale_id' => $subscale->id, 'label' => ['en' => 'Severe', 'es' => 'Severo'], 'min_score' => 7, 'max_score' => 9, 'position' => 3]);

        $optionLabels = [
            0 => ['en' => 'Never', 'es' => 'Nunca'],
            1 => ['en' => 'Rarely', 'es' => 'Rara vez'],
            2 => ['en' => 'Often', 'es' => 'A menudo'],
            3 => ['en' => 'Always', 'es' => 'Siempre'],
        ];

        $items = [
            ['code' => 'demo-item-1', 'prompt' => ['en' => 'I feel supported by people around me.', 'es' => 'Me siento apoyado por las personas a mi alrededor.'], 'reverse' => false, 'answer' => 2],
            ['code' => 'demo-item-2', 'prompt' => ['en' => 'I feel isolated from others.', 'es' => 'Me siento aislado de los demás.'], 'reverse' => true, 'answer' => 1],
            ['code' => 'demo-item-3', 'prompt' => ['en' => 'I sleep well most nights.', 'es' => 'Duermo bien la mayoría de las noches.'], 'reverse' => false, 'answer' => 1],
        ];

        $respondent = User::factory()->create([
            'name' => 'Demo Respondent',
            'email' => 'demo-respondent@example.com',
        ]);

        $response = QuestionnaireResponse::create([
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $respondent->id,
            'administered_by' => null,
            'status' => ResponseStatus::Completed,
            'started_at' => now(),
            'completed_at' => now(),
        ]);

        foreach ($items as $index => $item) {
            $question = Question::create([
                'code' => $item['code'],
                'prompt' => $item['prompt'],
                'question_type' => QuestionType::Scale,
            ]);

            $options = [];
            foreach ($optionLabels as $value => $label) {
                $options[$value] = AnswerOption::create([
                    'question_id' => $question->id,
                    'value' => $value,
                    'label' => $label,
                    'position' => $value,
                ]);
            }

            $placement = QuestionnaireQuestion::create([
                'questionnaire_id' => $questionnaire->id,
                'question_id' => $question->id,
                'position' => $index + 1,
                'is_required' => true,
                'reverse_scored' => $item['reverse'],
                'weight' => 1,
                'subscale_id' => $subscale->id,
            ]);

            QuestionResponse::create([
                'questionnaire_response_id' => $response->id,
                'questionnaire_question_id' => $placement->id,
                'selected_option_id' => $options[$item['answer']]->id,
                'value_numeric' => $item['answer'],
                'answered_at' => now(),
            ]);
        }

        app(SubscaleScoringService::class)->scoreAndPersist($response, $subscale);
    }
}
