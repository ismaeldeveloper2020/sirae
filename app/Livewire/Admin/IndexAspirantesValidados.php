<?php
namespace App\Livewire\Admin;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

use App\Models\Aspirantes\Generales;
use Livewire\WithPagination;

class IndexAspirantesValidados extends Component
{


    public function validarListaDocumentos($user_id)
    {
        //return view('livewire.admin.aspirantes-validar-documentos');
        return redirect()->route('admin.aspirantes.validar.documentos', $user_id);
    }

    public function editarAspirante($user_id)
    {
        return redirect()->route('admin.aspirantes.editar', [
            'user_id' => $user_id
        ]);
    }

    public function confirmarReset($id)
    {
        $this->dispatch('confirmar-reset', id: $id);
        // $this->dispatch('recargarTablaUsuarios');
    }

    #[On('resetAspirante')]
    public function resetAspirante($id)
    {
        DB::beginTransaction();
        try {
            DB::table('padron_aspirantes_modulos')
                ->where('user_id', $id)
                ->update([
                    'modulo_registro' => 0,
                    'deleted_at' => null,
                    'updated_at' => now()
                ]);
            DB::commit();
            $this->dispatch(
                'reset-ok',
                mensaje: 'El registro del aspirante fue reiniciado correctamente'
            );
            $this->dispatch('recargarTablaUsuarios');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error reseteando aspirante: '.$e->getMessage());
            $this->dispatch(
                'reset-error',
                mensaje: 'Ocurrió un error al resetear el registro'
            );
        }
    }

    public function render()
    {
        $users = User::select([
            'users.id',
            'users.nombre',
            'users.apaterno',
            'users.amaterno',
            'users.email',
            'padron_generales.folio',
            'padron_generales.curp',
            'padron_generales.rfc',
            'padron_generales.homoclave',
            'padron_generales.clave_elector',
            'padron_generales.telefono_movil',
            'padron_generales.id_tipo_cargo',
            'padron_generales.designado',
            'padron_aspirantes_modulos.modulo_registro',
            'padron_aspirantes_modulos.fecha_valido',

            DB::raw("CONCAT(validador.nombre,' ',validador.apaterno,' ',validador.amaterno) AS usuario_valido"),

            DB::raw("
                CASE
                    WHEN padron_generales.id_tipo_cargo = 1 THEN 'Distrital'
                    WHEN padron_generales.id_tipo_cargo = 2 THEN 'Municipal'
                END AS enlace_distrito_municipio
            "),

            DB::raw("
                CASE
                    WHEN padron_generales.id_tipo_cargo = 1 THEN
                        CONCAT(cat_distritos_municipios.id_distrito,' ',cat_municipios.municipio_local)
                    WHEN padron_generales.id_tipo_cargo = 2 THEN
                        cat_municipios2.municipio_local
                END AS descripcion_distrito_municipio
            ")
        ])
        ->join('padron_generales', 'padron_generales.user_id', '=', 'users.id')

        ->leftJoin('padron_aspirantes_modulos', 'padron_aspirantes_modulos.user_id', '=', 'users.id')

        ->leftJoin('users as validador', 'validador.id', '=', 'padron_aspirantes_modulos.id_usuario_valido')

        ->leftJoin('cat_distritos_municipios', function ($join) {
            $join->on('cat_distritos_municipios.id_distrito', '=', 'padron_generales.id_distrital')
                ->where('cat_distritos_municipios.cabecera_distrital', 1);
        })

        ->leftJoin('cat_municipios', 'cat_municipios.id_municipio', '=', 'cat_distritos_municipios.id_municipio')

        ->leftJoin('cat_municipios as cat_municipios2', 'cat_municipios2.id_municipio', '=', 'padron_generales.id_municipal')

        ->role('Aspirante')
        ->whereNull('padron_generales.deleted_at')
        ->where('padron_aspirantes_modulos.modulo_registro', 5)
        ->orderByDesc('users.id')
        ->get();
            //->paginate(50);
        return view('livewire.admin.index-aspirantes-validados', compact('users'));
    }

    public function seleccionarAspirante($user_id)
    {
        try {
            $general = Generales::where('user_id', $user_id)->firstOrFail();

            $general->update([
                'designado' => 1
            ]);

            $this->dispatch('recargarTablaUsuarios');

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            report($e);
        }
    }

    public function deseleccionarAspirante($user_id)
    {
        try {
            $general = Generales::where('user_id', $user_id)->firstOrFail();

            $general->update([
                'designado' => 0
            ]);

            $this->dispatch('recargarTablaUsuarios');

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            report($e);
        }
    }

    public function descargarConstancia($user_id)
    {
        $this->generarConstancia($user_id);
        $this->dispatch('recargarTablaUsuarios');
    }

    public function descargarAcuse($user_id)
    {
        $this->generarAcuse($user_id);
        $this->dispatch('recargarTablaUsuarios');
    }

    public function descargarCv($user_id)
    {


        $this->generarCv($user_id);
        $this->dispatch('recargarTablaUsuarios');
    }

    private function generarConstancia($user_id)
    {
        $constancia = DB::table('padron_constancias')
            ->where('user_id', $user_id)
            ->whereNull('deleted_at')
            ->where('estatus', 1)
            ->first();

        if (!$constancia) {
            throw new \Exception(
                'No existe una constancia generada para este aspirante.'
            );
        }

        if (!$constancia->ruta) {
            throw new \Exception(
                'La constancia no tiene una ruta de archivo.'
            );
        }

        $rutaArchivo = storage_path(
            'app/public/' . $constancia->ruta
        );

        if (!file_exists($rutaArchivo)) {
            throw new \Exception(
                'El archivo de la constancia no existe.'
            );
        }

        $archivo = basename($rutaArchivo);

        $this->dispatch(
            'descargar-constancia',
            archivo: $archivo
        );
    }


    private function generarAcuse($user_id)
    {
        $registro = \DB::table('users')
            ->join(
                'padron_generales',
                'users.id',
                '=',
                'padron_generales.user_id'
            )
            ->join(
                'cat_cargos_tipos',
                'cat_cargos_tipos.id',
                '=',
                'padron_generales.id_tipo_cargo'
            )
            ->where('users.id',$user_id)
            ->whereNull('padron_generales.deleted_at')
            ->select(
                'users.email',
                'padron_generales.nombre',
                'padron_generales.apaterno',
                'padron_generales.amaterno',
                'padron_generales.folio',
                'padron_generales.id_tipo_cargo',
                'cat_cargos_tipos.descripcion as cargo',
                'padron_generales.id_distrital',
                'padron_generales.id_municipal'
            )
            ->first();


        if(!$registro){
            throw new \Exception('No existe información del aspirante');
        }


        $folio_registro = $registro->folio;


        $nombre =
            $registro->nombre." ".
            $registro->apaterno." ".
            $registro->amaterno;



        $descripcion_distrito_municipio = '';


        if($registro->id_municipal){

            $municipio = \DB::table('cat_municipios')
                ->where('id_municipio',$registro->id_municipal)
                ->select('municipio_local as descripcion')
                ->first();

            if($municipio){
                $descripcion_distrito_municipio =
                    $municipio->descripcion;
            }


        }elseif($registro->id_distrital){


            $distrito = \DB::table('cat_distritos_municipios')
                ->join(
                    'cat_municipios',
                    'cat_municipios.id_municipio',
                    '=',
                    'cat_distritos_municipios.id_municipio'
                )
                ->where(
                    'cat_distritos_municipios.id_distrito',
                    $registro->id_distrital
                )
                ->selectRaw(
                    'CONCAT(cat_distritos_municipios.id_distrito," ",cat_municipios.municipio_local) as descripcion'
                )
                ->first();


            if($distrito){
                $descripcion_distrito_municipio =
                    $distrito->descripcion;
            }
        }



        $distrital_municipal = $registro->cargo;



        $finalizar_proceso_registro = \DB::table('padron_documentos_subidos')
            ->whereNull('deleted_at')
            ->where('user_id',$user_id)
            ->orderBy('created_at','desc')
            ->first();


        $fecha_creacion_final = "";
        $hora_creacion_final = "";


        if($finalizar_proceso_registro){

            \Carbon\Carbon::setLocale('es');

            $fecha_creacion_final = ucfirst(
                \Carbon\Carbon::parse(
                    $finalizar_proceso_registro->created_at
                )
                ->translatedFormat('l d \d\e F \d\e Y')
            );


            $hora_creacion_final =
                \Carbon\Carbon::parse(
                    $finalizar_proceso_registro->created_at
                )
                ->format('H:i');
        }



        $pdf = Pdf::loadView(
            'reportes.aspirantes.acuse',
            compact(
                'folio_registro',
                'nombre',
                'descripcion_distrito_municipio',
                'distrital_municipal',
                'fecha_creacion_final',
                'hora_creacion_final'
            )
        );


        $pdf->setPaper('letter','portrait');


        $pdf->getDomPDF()
            ->set_option(
                'isRemoteEnabled',
                true
            );



        $archivo = 'acuse_'.$folio_registro.'.pdf';


        $carpeta = storage_path(
            'app/public/aspirantes/pdf/generados'
        );


        if(!file_exists($carpeta)){
            mkdir($carpeta,0777,true);
        }


        $rutaArchivo =
            $carpeta.'/'.$archivo;



        file_put_contents(
            $rutaArchivo,
            $pdf->output()
        );



        $this->dispatch(
            'descargar-acuse',
            archivo:$archivo
        );
    }

    private function generarCv($user_id)
    {
        $usuario = \DB::table('users')
            ->where('id',$user_id)
            ->first();

        if(!$usuario){
            throw new \Exception('Usuario no encontrado');
        }

        // Datos generales del aspirante
        $datos = \DB::table('users')
            ->join('padron_generales', 'users.id', '=', 'padron_generales.user_id')
            ->join('cat_discapacidades', 'cat_discapacidades.id', '=', 'padron_generales.id_discapacidad')
            ->join('cat_etnias', 'cat_etnias.id', '=', 'padron_generales.id_etnia')
            ->join('cat_idiomas', 'cat_idiomas.id', '=', 'padron_generales.id_idioma_predominante')
            ->join('cat_tipo_licencias', 'cat_tipo_licencias.id', '=', 'padron_generales.id_tipo_licencia')
            ->join('cat_estados', 'cat_estados.id_estado', '=', 'padron_generales.id_estado')
            ->join('cat_municipios', 'cat_municipios.id_municipio', '=', 'padron_generales.id_municipio')
            ->leftJoin('cat_idiomas as cat_otro_idioma', 'cat_otro_idioma.id', '=', 'padron_generales.id_otro_idioma')
            ->where('users.id', $user_id)
            ->whereNull('padron_generales.deleted_at')
            ->select(
                'users.nombre',
                'users.apaterno',
                'users.amaterno',
                'users.email',
                'padron_generales.*',
                'cat_discapacidades.descripcion as discapacidad',
                'cat_etnias.descripcion as etnia',
                'cat_idiomas.descripcion as idioma_predominante',
                'cat_otro_idioma.descripcion as otro_idioma',
                'cat_tipo_licencias.descripcion as licencia',
                'cat_estados.nombre as estado',
                'cat_municipios.municipio_local as municipio_nacio'
            )
            ->first();

        $pad_datos_academicos = \DB::table('padron_curriculum_datos_academicos')
            ->select(
                'padron_curriculum_datos_academicos.*',
                'cat_nivel_estudios.descripcion as nivel_estudio',
                'estatus_nivel.descripcion as estatus_nivel_estudio',
                'cat_carreras.descripcion as carrera',
                'cat_estudios_posgrados.descripcion as nivel_posgrado',
                'estatus_otros.descripcion as estatus_otros_estudios'
            )
            ->join('cat_nivel_estudios','cat_nivel_estudios.id','=','padron_curriculum_datos_academicos.id_nivel_estudios')
            ->leftJoin('cat_estatus_nivel_estudios as estatus_nivel','estatus_nivel.id','=','padron_curriculum_datos_academicos.id_status_nivel_estudios')
            ->leftJoin('cat_carreras','cat_carreras.id','=','padron_curriculum_datos_academicos.id_carrera')
            ->leftJoin('cat_estudios_posgrados','cat_estudios_posgrados.id','=','padron_curriculum_datos_academicos.id_otros_estudios')
            ->leftJoin('cat_estatus_nivel_estudios as estatus_otros','estatus_otros.id','=','padron_curriculum_datos_academicos.id_status_otro_estudios')
            ->whereNull('padron_curriculum_datos_academicos.deleted_at')
            ->where('padron_curriculum_datos_academicos.user_id',$user_id)
            ->get();


        $pad_experiencias_laboral = \DB::table('padron_curriculum_experiencias_laborales')
            ->select(
                'padron_curriculum_experiencias_laborales.*',
                'cat_giros.descripcion as giro'
            )
            ->join('cat_giros','cat_giros.id','=','padron_curriculum_experiencias_laborales.id_giro_el')
            ->whereNull('padron_curriculum_experiencias_laborales.deleted_at')
            ->where('padron_curriculum_experiencias_laborales.user_id',$user_id)
            ->get();


        $pad_experiencias_electoral = \DB::table('padron_curriculum_experiencias_electorales')
            ->select(
                'padron_curriculum_experiencias_electorales.*',
                'cat_cargos_ocupados.descripcion as cargo_ocupado',
                'cat_institutos.descripcion as instituto',
                'cat_periodos.descripcion as periodo'
            )
            ->join('cat_cargos_ocupados','cat_cargos_ocupados.id','=','padron_curriculum_experiencias_electorales.id_cargo_ee')
            ->join('cat_institutos','cat_institutos.id','=','padron_curriculum_experiencias_electorales.id_institucion_ee')
            ->leftJoin('cat_periodos','cat_periodos.id','=','padron_curriculum_experiencias_electorales.id_periodo_ee')
            ->whereNull('padron_curriculum_experiencias_electorales.deleted_at')
            ->where('padron_curriculum_experiencias_electorales.user_id',$user_id)
            ->get();


        $pad_conocimientos_electoral = \DB::table('padron_curriculum_conocimientos_electorales')
            ->select(
                'padron_curriculum_conocimientos_electorales.*',
                'cat_conocimientos_electorales.descripcion as conocimiento'
            )
            ->join('cat_conocimientos_electorales','cat_conocimientos_electorales.id','=','padron_curriculum_conocimientos_electorales.id_tipo_ce')
            ->whereNull('padron_curriculum_conocimientos_electorales.deleted_at')
            ->where('padron_curriculum_conocimientos_electorales.user_id',$user_id)
            ->get();


        $pad_trayectorias = \DB::table('padron_curriculum_experiencias_docentes')
            ->whereNull('deleted_at')
            ->where('user_id',$user_id)
            ->get();


        $pdf = Pdf::loadView(
            'reportes.aspirantes.cv',
            compact(
                'datos',
                'pad_datos_academicos',
                'pad_experiencias_laboral',
                'pad_experiencias_electoral',
                'pad_conocimientos_electoral',
                'pad_trayectorias'
            )
        );


        $pdf->setPaper('letter','portrait');

        $pdf->getDomPDF()
            ->set_option('isRemoteEnabled',true);


        $nombreArchivo = 'CV_'.$user_id.'.pdf';


        $directorio = storage_path(
            'app/public/aspirantes/pdf/generados/'
        );


        if(!file_exists($directorio)){
            mkdir($directorio,0755,true);
        }


        $rutaArchivo = $directorio.$nombreArchivo;


        file_put_contents(
            $rutaArchivo,
            $pdf->output()
        );


        $this->dispatch(
            'descargar-cv',
            archivo:$nombreArchivo
        );
    }
}
