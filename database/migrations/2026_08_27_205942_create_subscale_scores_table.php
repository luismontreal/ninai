<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscale_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_response_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscale_id')->constrained()->cascadeOnDelete();
            $table->decimal('raw_score', 8, 3);
            $table->foreignId('severity_band_id')->nullable()->constrained();
            $table->timestamp('computed_at')->useCurrent();

            $table->unique(['questionnaire_response_id', 'subscale_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscale_scores');
    }
};
