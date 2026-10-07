<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Configuraciones extends Model
{
    protected $table = 'cat_configuraciones';

    protected $fillable = [
        'proceso_id',
        'fecha_inicio',
        'fecha_termino',
        'hora_inicio',
        'hora_termino',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_termino' => 'date',
    ];

    /**
     * Obtiene la configuración activa del periodo de registro.
     *
     * Los catálogos cat_configuraciones y cat_procesos pertenecen al esquema
     * existente de SIRAE y no se crean en la base SQLite temporal de pruebas.
     */
    public static function registroActivo(): ?self
    {
        if (
            ! Schema::hasTable('cat_configuraciones') ||
            ! Schema::hasTable('cat_procesos')
        ) {
            return null;
        }

        return static::whereHas('proceso', function ($query) {
            $query->where('nombre', 'REGISTRO');
        })
            ->where('activo', true)
            ->first();
    }


    public function proceso()
    {
        return $this->belongsTo(
            Procesos::class,
            'proceso_id'
        );
    }

}
