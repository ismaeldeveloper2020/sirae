<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('padron_constancias')) {
            Schema::create('padron_constancias', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->unique();
                $table->string('verification_key')->nullable()->unique();
                $table->string('folio')->nullable();
                $table->string('ruta')->nullable();
                $table->string('estatus')->nullable();
                $table->dateTime('fecha_emision')->nullable();
                $table->dateTime('fecha_validacion')->nullable();
                $table->text('motivo')->nullable();
                $table->string('nombre')->nullable();
                $table->string('tipo_enlace')->nullable();
                $table->string('distrito_municipio')->nullable();
                $table->unsignedBigInteger('id_usuario_creo')->nullable();
                $table->bigInteger('id_usuario_modifico')->nullable();
                $table->bigInteger('id_usuario_elimino')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('padron_constancias');
    }
};
