<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega la referencia opcional al catálogo de periodos.
     * periodo_ee se conserva como texto por compatibilidad con los registros actuales.
     */
    public function up(): void
    {
        if (
            Schema::hasTable('padron_curriculum_experiencias_electorales') &&
            ! Schema::hasColumn(
                'padron_curriculum_experiencias_electorales',
                'id_periodo_ee'
            )
        ) {
            Schema::table('padron_curriculum_experiencias_electorales', function (Blueprint $table) {
                $table->unsignedBigInteger('id_periodo_ee')
                    ->nullable()
                    ->default(null)
                    ->after('descripcion_otro_institucion_ee');
            });
        }
    }

    /**
     * No elimina la columna para conservar compatibilidad con instalaciones
     * donde ya existiera antes de esta migración.
     */
    public function down(): void
    {
        //
    }
};
