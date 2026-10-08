<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('examen_generales')) {
            Schema::create('examen_generales', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
                $table->string('folio', 20)->nullable();
                $table->string('correo', 150)->nullable();
                $table->string('clave_elector', 20)->nullable();
                $table->integer('puntaje_total')->nullable()->default(0);
                $table->integer('correctas')->nullable()->default(0);
                $table->integer('incorrectas')->nullable()->default(0);
                $table->enum('estado', ['pendiente', 'terminado'])->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->timestamp('started_at');
                $table->timestamp('expires_at');
                $table->integer('abandonos')->default(0);
                $table->integer('pregunta_actual')->nullable()->default(0);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('examen_generales');
    }
};
