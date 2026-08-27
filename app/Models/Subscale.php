<?php

namespace App\Models;

use App\Enums\AggregationMethod;
use Database\Factories\SubscaleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $questionnaire_id
 * @property string $code
 * @property array<string, string> $name
 * @property AggregationMethod $aggregation_method
 * @property float $score_multiplier
 */
#[Fillable(['questionnaire_id', 'code', 'name', 'aggregation_method', 'score_multiplier'])]
class Subscale extends Model
{
    /** @use HasFactory<SubscaleFactory> */
    use HasFactory, HasTranslations;

    public $timestamps = false;

    /**
     * @var array<int, string>
     */
    public array $translatable = ['name'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'aggregation_method' => AggregationMethod::class,
            'score_multiplier' => 'decimal:3',
        ];
    }

    /**
     * @return BelongsTo<Questionnaire, $this>
     */
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    /**
     * @return HasMany<SeverityBand>
     */
    public function severityBands(): HasMany
    {
        return $this->hasMany(SeverityBand::class);
    }

    /**
     * @return HasMany<QuestionnaireQuestion>
     */
    public function questionnaireQuestions(): HasMany
    {
        return $this->hasMany(QuestionnaireQuestion::class);
    }

    /**
     * @return HasMany<SubscaleScore>
     */
    public function subscaleScores(): HasMany
    {
        return $this->hasMany(SubscaleScore::class);
    }
}
