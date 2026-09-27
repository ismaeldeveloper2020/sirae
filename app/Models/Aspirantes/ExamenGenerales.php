<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Aspirantes\CatDocumentos;

class ExamenGenerales extends Model
{
    use SoftDeletes;

    protected $table = 'examen_generales';
    protected $fillable = [
        'user_id',
        'folio',
        'correo',
        'clave_elector',
        'puntaje_total',
        'correctas',
        'incorrectas',
        'estado',
        'created_at',
        'updated_at',
        'deleted_at',
        'started_at',
        'expires_at',
        'abandonos'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
