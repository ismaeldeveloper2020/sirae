<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('padron_documentos_subidos')) {
            Schema::create('padron_documentos_subidos', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('modulo', 100)->nullable();
                $table->boolean('completado')->nullable()->default(false);
                $table->dateTime('fecha_completado')->nullable();
                $table->unsignedBigInteger('id_usuario_creo')->nullable();
                $table->unsignedBigInteger('id_usuario_modifico')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->unique(['user_id', 'modulo']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('padron_documentos_subidos');
    }
};
