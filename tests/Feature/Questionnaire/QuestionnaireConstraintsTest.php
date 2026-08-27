<?php

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponse;
use Illuminate\Database\QueryException;

test('cannot duplicate a question at the same position within a questionnaire', function () {
    $questionnaire = Questionnaire::factory()->create();
    $questionOne = Question::factory()->create();
    $questionTwo = Question::factory()->create();

    QuestionnaireQuestion::factory()->for($questionnaire)->for($questionOne)->create(['position' => 1]);

    expect(fn () => QuestionnaireQuestion::factory()->for($questionnaire)->for($questionTwo)->create(['position' => 1]))
        ->toThrow(QueryException::class);
});

test('cannot duplicate a questionnaire code and version pair', function () {
    Questionnaire::factory()->create(['code' => 'dass-21', 'version' => 1]);

    expect(fn () => Questionnaire::factory()->create(['code' => 'dass-21', 'version' => 1]))
        ->toThrow(QueryException::class);
});

test('a user with questionnaire responses cannot be hard deleted', function () {
    $response = QuestionnaireResponse::factory()->create();

    expect(fn () => $response->respondent->delete())->toThrow(QueryException::class);
});
