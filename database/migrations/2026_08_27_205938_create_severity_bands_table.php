<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('severity_bands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscale_id')->constrained()->cascadeOnDelete();
            $table->json('label')->comment('Translatable: locale-keyed object, e.g. {"es": "Leve", "en": "Mild"}');
            $table->decimal('min_score', 8, 3);
            $table->decimal('max_score', 8, 3);
            $table->smallInteger('position');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('severity_bands');
    }
};
