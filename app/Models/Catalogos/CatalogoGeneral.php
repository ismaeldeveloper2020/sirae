<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class CatalogoGeneral extends Model
{


    /*General*/
    public static function get_distritos()
    {
        $info = DB::table('cat_municipios')
            ->leftJoin(
                'cat_distritos_municipios',
                'cat_municipios.id_municipio',
                '=',
                'cat_distritos_municipios.id_municipio'
            )
            ->where('cat_distritos_municipios.cabecera_distrital', '=', '1')
            ->orderBy('cat_distritos_municipios.id_distrito', 'asc')
            ->selectRaw('CONCAT(cat_distritos_municipios.id_distrito, " ", cat_municipios.municipio_local) as descripcion, cat_distritos_municipios.id_distrito')
            ->pluck('descripcion', 'id_distrito')
            ->toArray();

        return ['' => 'Seleccione una opción'] + $info;
    }

    
   public static function get_municipios()
    {
        $info = DB::table('cat_municipios')
            ->where('id_municipio', '!=', '064')
            ->orderBy('municipio_local', 'asc')
            //->selectRaw('UPPER(municipio_local) as descripcion, id_municipio')
            ->select('municipio_local as descripcion', 'id_municipio')
            ->pluck('descripcion', 'id_municipio')
            ->toArray();

        return ['' => 'Seleccione una opción'] + $info;
    }

   public static function get_licencias()
{
    $info = DB::table('cat_tipo_licencias')
        ->whereNull('deleted_at')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}


public static function get_autoadscripcion_indigenas()
{
    $info = DB::table('cat_etnias')
        ->whereNull('deleted_at')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}


public static function get_lenguas()
{
    $info = DB::table('cat_idiomas')
        ->whereNull('deleted_at')
        ->where('id', '!=', '14')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}


public static function get_otras_lenguas()
{
    $info = DB::table('cat_idiomas')
        ->whereNull('deleted_at')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}


public static function get_discapacidades()
{
    $info = DB::table('cat_discapacidades')
        ->whereNull('deleted_at')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}


public static function get_generos()
{
    $info = DB::table('cat_generos')
        ->whereNull('deleted_at')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}


public static function get_cargos()
{
    $info = DB::table('cat_cargos_tipos')
        ->whereNull('deleted_at')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}


public static function get_estados()
{
    $info = DB::table('cat_estados')
        ->orderBy('nombre', 'asc')
        ->select('nombre', 'id_estado')
        ->pluck('nombre', 'id_estado')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}


/*Curriculum*/

public static function get_nivel_estudios()
{
    $info = DB::table('cat_nivel_estudios')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}


public static function get_carreras()
{
    $info = DB::table('cat_carreras')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}

public static function get_estatus_nivel_estudios()
{
    $info = DB::table('cat_estatus_nivel_estudios')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}

public static function get_estudios_posgrados()
{
    $info = DB::table('cat_estudios_posgrados')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}

public static function get_giros()
{
    $info = DB::table('cat_giros')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}


public static function get_cargos_ocupados()
{
    $info = DB::table('cat_cargos_ocupados')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}

public static function get_institutos()
{
    $info = DB::table('cat_institutos')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}

public static function get_periodos()
{
    $info = DB::table('cat_periodos')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}

public static function get_conocimientos_electorales()
{
    $info = DB::table('cat_conocimientos_electorales')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}

public static function get_tipo_asistencias()
{
    $info = DB::table('cat_tipos_asistencias')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}

public static function get_tipo_asietncias()
{
    $info = DB::table('cat_tipos_asistencias')
        ->orderBy('descripcion', 'asc')
        ->select('descripcion', 'id')
        ->pluck('descripcion', 'id')
        ->toArray();

    return ['' => 'Seleccione una opción'] + $info;
}







/*Archivos*/







    public static function getCombo()
    {
        return Paises::lists('nombre', 'id')->prepend('Elige un pais...');
    }

    public static function get_paises(){
        return Paises::lists('nombre','id')->prepend('ELIGE UN PAIS');
    }

    public static function get_usuarios(){
        $info = DB::table('usuarios')->whereNull('usuarios.deleted_at')->orderBy('nombre', 'asc')->lists('nombre','id');
        return ['' => 'Selecciona un usuario'] + $info;
    }
}
