<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Aspirantes\CatDocumentos;

class ExamenPreguntas extends Model
{
    use SoftDeletes;

    protected $table = 'examen_preguntas';
    protected $fillable = [
        'pregunta',
        'respuestaA',
        'respuestaB',
        'respuestaC',
        'respuestaD',
        'respuesta_correcta',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
