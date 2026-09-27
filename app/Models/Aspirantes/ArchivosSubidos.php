<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class ArchivosSubidos extends Model
{
     use SoftDeletes;

    protected $table = 'padron_documentos_subidos';
    protected $fillable = [
        'user_id',
        'modulo',
        'completado',
        'fecha_completado',
        'observacion',
        'id_usuario_creo'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
