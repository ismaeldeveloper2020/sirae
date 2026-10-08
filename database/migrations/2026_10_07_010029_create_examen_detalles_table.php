<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('examen_detalles')) {
            Schema::create('examen_detalles', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->bigInteger('examen_id')->nullable();
                $table->bigInteger('pregunta_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->index('examen_id', 'idx_examen_id');
                $table->index('pregunta_id', 'idx_pregunta_id');
                $table->index(['examen_id', 'pregunta_id'], 'idx_examen_pregunta');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('examen_detalles');
    }
};
