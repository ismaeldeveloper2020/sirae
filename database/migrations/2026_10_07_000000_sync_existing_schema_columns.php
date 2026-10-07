<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Completa columnas que existen en el contrato actual de SIRAE
     * pero no estaban representadas en todas las migraciones originales.
     */
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            $columnsToAdd = [];

            foreach ([
                'id_usuario_creo',
                'id_usuario_modifico',
                'id_usuario_elimino',
            ] as $column) {
                if (! Schema::hasColumn('users', $column)) {
                    $columnsToAdd[] = $column;
                }
            }

            if ($columnsToAdd || ! Schema::hasColumn('users', 'deleted_at')) {
                Schema::table('users', function (Blueprint $table) use ($columnsToAdd) {
                    foreach ($columnsToAdd as $column) {
                        $table->unsignedBigInteger($column)->nullable();
                    }

                    if (! Schema::hasColumn('users', 'deleted_at')) {
                        $table->softDeletes();
                    }
                });
            }
        }

        if (
            Schema::hasTable('organizaciones') &&
            ! Schema::hasColumn('organizaciones', 'deleted_at')
        ) {
            Schema::table('organizaciones', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (
            Schema::hasTable('padron_generales') &&
            ! Schema::hasColumn('padron_generales', 'designado')
        ) {
            Schema::table('padron_generales', function (Blueprint $table) {
                $table->unsignedBigInteger('designado')->default(0);
            });
        }
    }

    /**
     * Se deja sin reversión automática para no eliminar columnas que
     * pudieron existir antes de esta migración de sincronización.
     */
    public function down(): void
    {
        //
    }
};
