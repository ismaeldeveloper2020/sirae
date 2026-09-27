<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Aspirantes\CatDocumentos;

class ExamenRespuestas extends Model
{
    use SoftDeletes;

    protected $table = 'examen_respuestas';
    protected $fillable = [
        'examen_id',
        'pregunta_id',
        'respuesta_usuario',
        'respuesta_correcta',
        'es_correcta',
        'created_at',
        'updated_at'
    ];

}
