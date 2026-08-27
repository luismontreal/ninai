<?php

namespace App\Models;

use Database\Factories\QuestionResponseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * One answered item within a questionnaire response.
 *
 * TODO: PII/sensitive-data handling (encryption at rest, access control, retention
 * policy) is intentionally out of scope for this pass. This holds individual
 * clinical response data tied to a real user record.
 *
 * @property int $id
 * @property int $questionnaire_response_id
 * @property int $questionnaire_question_id
 * @property int|null $selected_option_id
 * @property float|null $value_numeric
 * @property Carbon $answered_at
 */
#[Fillable(['questionnaire_response_id', 'questionnaire_question_id', 'selected_option_id', 'value_numeric', 'answered_at'])]
class QuestionResponse extends Model
{
    /** @use HasFactory<QuestionResponseFactory> */
    use HasFactory;

    public $timestamps = false;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value_numeric' => 'decimal:3',
            'answered_at' => 'datetime',
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
     * @return BelongsTo<QuestionnaireQuestion, $this>
     */
    public function questionnaireQuestion(): BelongsTo
    {
        return $this->belongsTo(QuestionnaireQuestion::class);
    }

    /**
     * @return BelongsTo<AnswerOption, $this>
     */
    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(AnswerOption::class, 'selected_option_id');
    }
}
