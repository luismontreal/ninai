<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_response_id')->constrained()->cascadeOnDelete();
            $table->foreignId('questionnaire_question_id')->constrained()->restrictOnDelete();
            // TODO: PII/sensitive-data handling (encryption at rest, access control, retention
            // policy) is intentionally out of scope for this pass. This table holds individual
            // clinical response data (e.g. depression/anxiety item answers) tied to a real user.
            $table->foreignId('selected_option_id')->nullable()->constrained('answer_options')->restrictOnDelete();
            $table->decimal('value_numeric', 8, 3)->nullable()->comment("Snapshot of selected_option's value, for stable scoring/queries");
            $table->timestamp('answered_at')->useCurrent();

            $table->unique(['questionnaire_response_id', 'questionnaire_question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_responses');
    }
};
