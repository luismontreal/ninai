<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->comment("Stable slug shared across versions, e.g. 'dass-21'");
            $table->integer('version')->default(1)->comment('Increments on edits; published questionnaires are immutable');
            $table->json('title')->comment('Translatable: locale-keyed object, e.g. {"es": "...", "en": "..."}');
            $table->json('description')->nullable()->comment('Translatable: locale-keyed object');
            $table->text('source_citation')->nullable()->comment('Academic/author attribution; not translated');
            $table->string('status')->default('draft')->comment('QuestionnaireStatus enum: draft, published, archived');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['code', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
