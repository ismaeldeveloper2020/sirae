<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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


    public function proceso()
    {
        return $this->belongsTo(
            Procesos::class,
            'proceso_id'
        );
    }

}