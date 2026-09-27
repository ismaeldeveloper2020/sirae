<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class CurriculumExperienciasElectorales extends Model
{
    use SoftDeletes;

    protected $table="padron_curriculum_experiencias_electorales";
    
    protected $fillable = [
        'user_id',
        'id_cargo_ee',
        'descripcion_otro_cargo_ee',
        'id_institucion_ee',
        'descripcion_otro_institucion_ee',
        'periodo_ee',
        'id_usuario_creo',
        'id_usuario_modifico',
        'id_usuario_elimino',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}