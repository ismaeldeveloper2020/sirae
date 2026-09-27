<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class CurriculumExperienciasDocentes extends Model
{
    use SoftDeletes;

    protected $table="padron_curriculum_experiencias_docentes";
    protected $fillable = [
        'user_id',
        'descripcion_docente',
        'id_usuario_creo',
        'id_usuario_modifico',
        'id_usuario_elimino',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}