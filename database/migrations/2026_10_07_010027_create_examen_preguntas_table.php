<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('examen_preguntas')) {
            Schema::create('examen_preguntas', function (Blueprint $table): void {
                $table->id();
                $table->text('pregunta');
                $table->text('respuestaA');
                $table->text('respuestaB');
                $table->text('respuestaC');
                $table->text('respuestaD');
                $table->enum('respuesta_correcta', ['A', 'B', 'C', 'D']);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('examen_preguntas');
    }
};
