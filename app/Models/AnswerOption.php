<?php

namespace App\Models;

use Database\Factories\AnswerOptionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $question_id
 * @property int $value
 * @property array<string, string> $label
 * @property int $position
 */
#[Fillable(['question_id', 'value', 'label', 'position'])]
class AnswerOption extends Model
{
    /** @use HasFactory<AnswerOptionFactory> */
    use HasFactory, HasTranslations;

    public $timestamps = false;

    /**
     * @var array<int, string>
     */
    public array $translatable = ['label'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => 'integer',
            'position' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Question, $this>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
