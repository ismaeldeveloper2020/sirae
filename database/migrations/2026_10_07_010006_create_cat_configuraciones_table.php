<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cat_configuraciones')) {
            Schema::create('cat_configuraciones', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('proceso_id')->index();
                $table->integer('numero_bloque')->nullable();
                $table->string('descripcion')->nullable();
                $table->date('fecha_inicio')->index();
                $table->time('hora_inicio');
                $table->date('fecha_termino');
                $table->time('hora_termino');
                $table->boolean('activo')->default(true)->index();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_configuraciones');
    }
};
