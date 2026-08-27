<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->nullable()->unique()->comment("Optional stable id, e.g. 'dass21_item_01'");
            $table->json('prompt')->comment('Translatable: locale-keyed object, e.g. {"es": "...", "en": "..."}');
            $table->string('question_type')->comment('QuestionType enum: boolean, scale');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
