<?php

use App\Models\AnswerOption;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponse;
use App\Models\QuestionResponse;
use App\Models\SeverityBand;
use App\Models\Subscale;
use App\Models\SubscaleScore;

test('the full questionnaire schema persists and relationships resolve', function () {
    $questionnaire = Questionnaire::factory()->create();
    $subscale = Subscale::factory()->for($questionnaire)->create();
    $severityBand = SeverityBand::factory()->for($subscale)->create();
    $question = Question::factory()->create();
    $answerOption = AnswerOption::factory()->for($question)->create();
    $placement = QuestionnaireQuestion::factory()
        ->for($questionnaire)
        ->for($question)
        ->create(['subscale_id' => $subscale->id]);
    $response = QuestionnaireResponse::factory()->for($questionnaire)->create();
    $questionResponse = QuestionResponse::factory()
        ->for($response)
        ->for($placement)
        ->create(['selected_option_id' => $answerOption->id]);
    $subscaleScore = SubscaleScore::factory()
        ->for($response)
        ->for($subscale)
        ->create(['severity_band_id' => $severityBand->id]);

    expect($questionnaire->subscales)->toHaveCount(1)
        ->and($questionnaire->questionnaireQuestions)->toHaveCount(1)
        ->and($subscale->severityBands)->toHaveCount(1)
        ->and($question->answerOptions)->toHaveCount(1)
        ->and($placement->question->is($question))->toBeTrue()
        ->and($placement->subscale->is($subscale))->toBeTrue()
        ->and($response->questionResponses)->toHaveCount(1)
        ->and($response->respondent)->not->toBeNull()
        ->and($questionResponse->selectedOption->is($answerOption))->toBeTrue()
        ->and($subscaleScore->severityBand->is($severityBand))->toBeTrue();
});
