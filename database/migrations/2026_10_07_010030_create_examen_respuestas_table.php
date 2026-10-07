<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('examen_respuestas')) {
            Schema::create('examen_respuestas', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('examen_id')->constrained('examen_generales')->cascadeOnDelete();
                $table->foreignId('pregunta_id')->constrained('examen_preguntas')->cascadeOnDelete();
                $table->enum('respuesta_usuario', ['A', 'B', 'C', 'D'])->nullable();
                $table->enum('respuesta_correcta', ['A', 'B', 'C', 'D']);
                $table->boolean('es_correcta')->nullable()->default(false);
                $table->timestamps();
                $table->softDeletes();
                $table->unique(['examen_id', 'pregunta_id'], 'uq_examen_pregunta');
                $table->index('examen_id');
                $table->index('pregunta_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('examen_respuestas');
    }
};
