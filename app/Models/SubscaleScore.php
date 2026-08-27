<?php

namespace App\Models;

use Database\Factories\SubscaleScoreFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Cached rollup of a subscale's score for one questionnaire response.
 *
 * @property int $id
 * @property int $questionnaire_response_id
 * @property int $subscale_id
 * @property float $raw_score
 * @property int|null $severity_band_id
 * @property Carbon $computed_at
 */
#[Fillable(['questionnaire_response_id', 'subscale_id', 'raw_score', 'severity_band_id', 'computed_at'])]
class SubscaleScore extends Model
{
    /** @use HasFactory<SubscaleScoreFactory> */
    use HasFactory;

    public $timestamps = false;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'raw_score' => 'decimal:3',
            'computed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<QuestionnaireResponse, $this>
     */
    public function questionnaireResponse(): BelongsTo
    {
        return $this->belongsTo(QuestionnaireResponse::class);
    }

    /**
     * @return BelongsTo<Subscale, $this>
     */
    public function subscale(): BelongsTo
    {
        return $this->belongsTo(Subscale::class);
    }

    /**
     * @return BelongsTo<SeverityBand, $this>
     */
    public function severityBand(): BelongsTo
    {
        return $this->belongsTo(SeverityBand::class);
    }
}
