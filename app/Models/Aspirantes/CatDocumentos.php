<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CatDocumentos extends Model
{
    use SoftDeletes;

    protected $table = 'cat_documentos';
    protected $fillable = [
        'user_id',
        'nombre',
        'orden',
        'obligatorio',
        'activo',
        'id_usuario_creo',
        'id_usuario_modifico',
        'id_usuario_elimino'
    ];

}
