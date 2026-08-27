<?php

use App\Enums\AggregationMethod;
use App\Models\AnswerOption;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponse;
use App\Models\QuestionResponse;
use App\Models\Subscale;
use App\Services\SubscaleScoringService;

test('it computes a weighted, reverse-scored subscale total matching the worked example', function () {
    // 2 + reverse(1 on a 0-3 scale) + 1 = 5
    $questionnaire = Questionnaire::factory()->create();
    $subscale = Subscale::factory()->for($questionnaire)->create([
        'aggregation_method' => AggregationMethod::Sum,
        'score_multiplier' => 1,
    ]);
    $response = QuestionnaireResponse::factory()->for($questionnaire)->create();

    $answers = [2, 1, 1];
    $reverseScoredIndex = 1;

    foreach ($answers as $index => $answer) {
        $question = Question::factory()->create();

        foreach (range(0, 3) as $value) {
            AnswerOption::factory()->for($question)->create(['value' => $value, 'position' => $value]);
        }

        $placement = QuestionnaireQuestion::factory()
            ->for($questionnaire)
            ->for($question)
            ->create([
                'position' => $index + 1,
                'reverse_scored' => $index === $reverseScoredIndex,
                'weight' => 1,
                'subscale_id' => $subscale->id,
            ]);

        QuestionResponse::factory()
            ->for($response)
            ->for($placement)
            ->create(['value_numeric' => $answer]);
    }

    $score = app(SubscaleScoringService::class)->score($response, $subscale);

    expect($score)->toBe(5.0);
});
