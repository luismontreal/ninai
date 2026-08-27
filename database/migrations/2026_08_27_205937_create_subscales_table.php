<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_id')->constrained()->cascadeOnDelete();
            $table->string('code', 64)->comment("e.g. 'depression', 'anxiety', 'stress', 'total'");
            $table->json('name')->comment('Translatable: locale-keyed object, e.g. {"es": "...", "en": "..."}');
            $table->string('aggregation_method', 16)->default('sum')->comment('AggregationMethod enum: sum, average');
            $table->decimal('score_multiplier', 6, 3)->default(1)->comment('Some instruments scale the raw sum, e.g. x2');

            $table->unique(['questionnaire_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscales');
    }
};
