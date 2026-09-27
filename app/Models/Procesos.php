<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procesos extends Model
{
    protected $table = 'cat_procesos';


    protected $fillable = [
        'nombre',
        'descripcion',
        'activo'
    ];


    protected $casts = [
        'activo' => 'boolean'
    ];


    public function configuraciones()
    {
        return $this->hasMany(
            Configuraciones::class,
            'proceso_id'
        );
    }
}