<?php

namespace App\Services;

use App\Enums\AggregationMethod;
use App\Models\QuestionnaireResponse;
use App\Models\Subscale;
use App\Models\SubscaleScore;

/**
 * Ports the `calculate_subscale_score()` Postgres function from the reference
 * SQL schema into application logic, per the design doc's own recommendation.
 */
class SubscaleScoringService
{
    /**
     * Compute the raw score for one subscale within one questionnaire response:
     * the weighted sum (or average) of each mapped item's value, reverse-scored
     * as (min + max - value) when the placement calls for it, times the
     * subscale's score multiplier.
     */
    public function score(QuestionnaireResponse $response, Subscale $subscale): float
    {
        $items = $response->questionResponses()
            ->whereNotNull('value_numeric')
            ->whereHas('questionnaireQuestion', fn ($query) => $query->where('subscale_id', $subscale->id))
            ->with('questionnaireQuestion.question.answerOptions')
            ->get();

        $total = 0.0;
        $count = 0;

        foreach ($items as $item) {
            $placement = $item->questionnaireQuestion;
            $value = (float) $item->value_numeric;

            if ($placement->reverse_scored) {
                $bounds = $placement->question->answerOptions;
                $value = (float) $bounds->min('value') + (float) $bounds->max('value') - $value;
            }

            $total += (float) $placement->weight * $value;
            $count++;
        }

        if ($subscale->aggregation_method === AggregationMethod::Average && $count > 0) {
            $total /= $count;
        }

        return round($total * (float) $subscale->score_multiplier, 3);
    }

    /**
     * Compute the raw score, resolve the matching severity band, and persist
     * the cached rollup row (creating or updating it for this response/subscale pair).
     */
    public function scoreAndPersist(QuestionnaireResponse $response, Subscale $subscale): SubscaleScore
    {
        $rawScore = $this->score($response, $subscale);

        $severityBand = $subscale->severityBands()
            ->where('min_score', '<=', $rawScore)
            ->where('max_score', '>=', $rawScore)
            ->first();

        return SubscaleScore::updateOrCreate(
            [
                'questionnaire_response_id' => $response->id,
                'subscale_id' => $subscale->id,
            ],
            [
                'raw_score' => $rawScore,
                'severity_band_id' => $severityBand?->id,
                'computed_at' => now(),
            ]
        );
    }
}
