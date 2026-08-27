<?php

namespace App\Models;

use Database\Factories\QuestionnaireQuestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $questionnaire_id
 * @property int $question_id
 * @property int $position
 * @property bool $is_required
 * @property bool $reverse_scored
 * @property float $weight
 * @property int|null $subscale_id
 */
#[Fillable(['questionnaire_id', 'question_id', 'position', 'is_required', 'reverse_scored', 'weight', 'subscale_id'])]
class QuestionnaireQuestion extends Model
{
    /** @use HasFactory<QuestionnaireQuestionFactory> */
    use HasFactory;

    public $timestamps = false;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'reverse_scored' => 'boolean',
            'weight' => 'decimal:3',
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
     * @return BelongsTo<Question, $this>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return BelongsTo<Subscale, $this>
     */
    public function subscale(): BelongsTo
    {
        return $this->belongsTo(Subscale::class);
    }

    /**
     * @return HasMany<QuestionResponse>
     */
    public function questionResponses(): HasMany
    {
        return $this->hasMany(QuestionResponse::class);
    }
}
