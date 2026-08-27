<?php

namespace App\Models;

use App\Enums\QuestionnaireStatus;
use Database\Factories\QuestionnaireFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $code
 * @property int $version
 * @property array<string, string> $title
 * @property array<string, string>|null $description
 * @property string|null $source_citation
 * @property QuestionnaireStatus $status
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['code', 'version', 'title', 'description', 'source_citation', 'status', 'published_at'])]
class Questionnaire extends Model
{
    /** @use HasFactory<QuestionnaireFactory> */
    use HasFactory, HasTranslations;

    /**
     * @var array<int, string>
     */
    public array $translatable = ['title', 'description'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => QuestionnaireStatus::class,
            'published_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<QuestionnaireQuestion>
     */
    public function questionnaireQuestions(): HasMany
    {
        return $this->hasMany(QuestionnaireQuestion::class);
    }

    /**
     * @return HasMany<Subscale>
     */
    public function subscales(): HasMany
    {
        return $this->hasMany(Subscale::class);
    }

    /**
     * @return HasMany<QuestionnaireResponse>
     */
    public function responses(): HasMany
    {
        return $this->hasMany(QuestionnaireResponse::class);
    }
}
