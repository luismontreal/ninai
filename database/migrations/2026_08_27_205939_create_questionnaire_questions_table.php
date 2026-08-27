<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questionnaire_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->restrictOnDelete();
            $table->smallInteger('position')->comment('Order within the questionnaire');
            $table->boolean('is_required')->default(true);
            $table->boolean('reverse_scored')->default(false)->comment('If true, score as (min+max-value) at computation time');
            $table->decimal('weight', 6, 3)->default(1);
            $table->foreignId('subscale_id')->nullable()->constrained()->nullOnDelete();

            $table->unique(['questionnaire_id', 'question_id']);
            $table->unique(['questionnaire_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questionnaire_questions');
    }
};
