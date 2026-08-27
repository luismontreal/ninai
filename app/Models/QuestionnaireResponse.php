<?php

namespace App\Models;

use App\Enums\ResponseStatus;
use Database\Factories\QuestionnaireResponseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $questionnaire_id
 * @property int $user_id
 * @property int|null $administered_by
 * @property ResponseStatus $status
 * @property Carbon $started_at
 * @property Carbon|null $completed_at
 * @property string|null $notes
 */
#[Fillable(['questionnaire_id', 'user_id', 'administered_by', 'status', 'started_at', 'completed_at', 'notes'])]
class QuestionnaireResponse extends Model
{
    /** @use HasFactory<QuestionnaireResponseFactory> */
    use HasFactory;

    public $timestamps = false;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ResponseStatus::class,
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
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
     * The user who took the questionnaire.
     *
     * @return BelongsTo<User, $this>
     */
    public function respondent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The user who administered the questionnaire, if any.
     *
     * @return BelongsTo<User, $this>
     */
    public function administrator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'administered_by');
    }

    /**
     * @return HasMany<QuestionResponse>
     */
    public function questionResponses(): HasMany
    {
        return $this->hasMany(QuestionResponse::class);
    }

    /**
     * @return HasMany<SubscaleScore>
     */
    public function subscaleScores(): HasMany
    {
        return $this->hasMany(SubscaleScore::class);
    }
}
