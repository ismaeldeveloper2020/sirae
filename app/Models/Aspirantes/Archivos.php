<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Aspirantes\CatDocumentos;

class Archivos extends Model
{
    use SoftDeletes;

    protected $table = 'padron_documentos';
    protected $fillable = [
        'user_id',
        'documento_id',
        'nombre',
        'ruta',
        'extension',
        'validado',
        'observacion',
        'id_usuario_creo',
        'id_usuario_modifico',
        'id_usuario_elimino',
        'id_usuario_requirio',
        'fecha_requirio',
        'id_usuario_valido',
        'fecha_valido'
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documento()
    {
        return $this->belongsTo(
            CatDocumentos::class,
            'documento_id'
        );
    }

}
