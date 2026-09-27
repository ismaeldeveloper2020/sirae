<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class CurriculumConocimientosElectorales extends Model
{
    use SoftDeletes;

    protected $table="padron_curriculum_conocimientos_electorales";
    protected $fillable = [
        'user_id',
        'id_tipo_ce',
        'otro_ce',
        'id_participacion_ce',
        'institucion_ce',
        'descripcion_ce',
        'periodo_ce',
        'id_usuario_creo',
        'id_usuario_modifico',
        'id_usuario_elimino',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}