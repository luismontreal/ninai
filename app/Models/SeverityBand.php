<?php

namespace App\Models;

use Database\Factories\SeverityBandFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $subscale_id
 * @property array<string, string> $label
 * @property float $min_score
 * @property float $max_score
 * @property int $position
 */
#[Fillable(['subscale_id', 'label', 'min_score', 'max_score', 'position'])]
class SeverityBand extends Model
{
    /** @use HasFactory<SeverityBandFactory> */
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
            'min_score' => 'decimal:3',
            'max_score' => 'decimal:3',
            'position' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Subscale, $this>
     */
    public function subscale(): BelongsTo
    {
        return $this->belongsTo(Subscale::class);
    }
}
