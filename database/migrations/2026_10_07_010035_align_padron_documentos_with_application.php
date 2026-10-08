<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the columns used by the current document upload workflow.
     *
     * The original table already exists in some databases with legacy names
     * such as id_tipo_documento and ruta_file, so this migration is additive
     * and preserves those columns and their data.
     */
    public function up(): void
    {
        if (! Schema::hasTable('padron_documentos')) {
            return;
        }

        if (! Schema::hasColumn('padron_documentos', 'documento_id')) {
            Schema::table('padron_documentos', function (Blueprint $table): void {
                $table->unsignedBigInteger('documento_id')->nullable();
            });
        }

        if (! Schema::hasColumn('padron_documentos', 'nombre')) {
            Schema::table('padron_documentos', function (Blueprint $table): void {
                $table->string('nombre', 255)->nullable();
            });
        }

        if (! Schema::hasColumn('padron_documentos', 'ruta')) {
            Schema::table('padron_documentos', function (Blueprint $table): void {
                $table->string('ruta', 255)->nullable();
            });
        }

        if (! Schema::hasColumn('padron_documentos', 'extension')) {
            Schema::table('padron_documentos', function (Blueprint $table): void {
                $table->string('extension', 20)->nullable();
            });
        }

        foreach ([
            'id_usuario_requirio',
            'id_usuario_valido',
        ] as $column) {
            if (! Schema::hasColumn('padron_documentos', $column)) {
                Schema::table('padron_documentos', function (Blueprint $table) use ($column): void {
                    $table->unsignedBigInteger($column)->nullable();
                });
            }
        }

        foreach ([
            'fecha_requirio',
            'fecha_valido',
        ] as $column) {
            if (! Schema::hasColumn('padron_documentos', $column)) {
                Schema::table('padron_documentos', function (Blueprint $table) use ($column): void {
                    $table->timestamp($column)->nullable();
                });
            }
        }

        $legacyColumns = [
            'documento_id' => 'id_tipo_documento',
            'nombre' => 'nombre_mostrar',
            'ruta' => 'ruta_file',
            'extension' => 'tipo_file',
        ];

        foreach ($legacyColumns as $currentColumn => $legacyColumn) {
            if (
                Schema::hasColumn('padron_documentos', $currentColumn) &&
                Schema::hasColumn('padron_documentos', $legacyColumn)
            ) {
                DB::table('padron_documentos')
                    ->whereNull($currentColumn)
                    ->whereNotNull($legacyColumn)
                    ->update([
                        $currentColumn => DB::raw("`{$legacyColumn}`"),
                    ]);
            }
        }
    }

    /**
     * Keep the compatibility columns on rollback to avoid deleting uploaded
     * document metadata from an existing database.
     */
    public function down(): void
    {
        // Intentionally non-destructive.
    }
};
