<?php

use App\Models\Questionnaire;

test('a translatable attribute falls back to the fallback locale when missing for the current locale', function () {
    config(['app.fallback_locale' => 'en']);
    app()->setLocale('es');

    $questionnaire = Questionnaire::factory()->create([
        'title' => ['en' => 'Wellbeing Scale'],
    ]);

    expect($questionnaire->title)->toBe('Wellbeing Scale');
});

test('a translatable attribute resolves per-locale when both are present', function () {
    $questionnaire = Questionnaire::factory()->create([
        'title' => ['en' => 'Wellbeing Scale', 'es' => 'Escala de Bienestar'],
    ]);

    expect($questionnaire->getTranslation('title', 'en'))->toBe('Wellbeing Scale')
        ->and($questionnaire->getTranslation('title', 'es'))->toBe('Escala de Bienestar');
});
