<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class CurriculumDatosAcademicos extends Model
{
    use SoftDeletes;

    protected $table="padron_curriculum_datos_academicos";
    protected $fillable = [
        'user_id',
        'id_nivel_estudios',
        'id_carrera',
        'otra_carrera',
        'id_status_nivel_estudios',
        'id_otros_estudios',
        'posgrado',
        'id_status_otro_estudios',
        'id_usuario_creo',
        'id_usuario_modifico',
        'id_usuario_elimino',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}