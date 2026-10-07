<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('padron_aspirantes_modulos')) {
            Schema::create('padron_aspirantes_modulos', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->boolean('modulo_registro')->nullable()->default(false);
                $table->boolean('modulo_examen')->nullable()->default(false);
                $table->boolean('modulo_entrevista')->nullable()->default(false);
                $table->timestamp('fecha_completado')->nullable();
                $table->string('observacion')->nullable();
                $table->integer('id_usuario_valido')->nullable();
                $table->timestamp('fecha_valido')->nullable();
                $table->unsignedBigInteger('id_usuario_creo')->nullable();
                $table->unsignedBigInteger('id_usuario_modifico')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->unique(['user_id', 'modulo_registro']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('padron_aspirantes_modulos');
    }
};
