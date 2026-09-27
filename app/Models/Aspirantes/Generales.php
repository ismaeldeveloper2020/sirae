<?php
namespace App\Models\Aspirantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Generales extends Model
{
    use SoftDeletes;

    protected $table="padron_generales";
    protected $fillable = [
        'user_id',
        'folio',
        'id_tipo_cargo',
        'id_distrital',
        'id_municipal',
        'nombre',
        'apaterno',
        'amaterno',
        'rfc',
        'homoclave',
        'curp',
        'id_discapacidad',
        'id_genero',
        'telefono_casa',
        'telefono_movil',
        'id_tipo_licencia',
        'id_etnia',
        'id_idioma_predominante',
        'id_otro_idioma',
        'especifique_idioma',
        'ocupacion_actual',
        'clave_elector',
        'fecha_nacimiento',
        'genero',
        'edad',
        'calle',
        'num_casa_exterior',
        'num_casa_interior',
        'colonia',
        'cp',
        'id_estado',
        'id_municipio',
        'designado'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}