<?php
namespace App\Http\Controllers\Admin;
use App\Models\Ciudadano;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class AspirantesController extends Controller
{

    public function index_aspirantes()
    {
        $lista = [];
        $id_user = Auth::id(); // Obtiene el ID del usuario logueado
        return view('Admin.aspirantes', ['lista' => $lista, 'id_user' => $id_user]);
    }

    
    public function index_aspirantes_validados()
    {
        $lista = [];
        $id_user = Auth::id(); // Obtiene el ID del usuario logueado
        return view('Admin.aspirantes-validados', ['lista' => $lista, 'id_user' => $id_user]);
    }

    
    public function index_aspirantes_requeridos()
    {
        $lista = [];
        $id_user = Auth::id(); // Obtiene el ID del usuario logueado
        return view('Admin.aspirantes-requeridos', ['lista' => $lista, 'id_user' => $id_user]);
    }

    
    public function index_aspirantes_validar_documentos($user_id)
    {
        $lista = [];
        $id_user = Auth::id(); // Obtiene el ID del usuario logueado
        return view('Admin.aspirantes-validar-documentos', ['lista' => $lista, 'user_id' => $user_id]);
    }

    

    public function index_generales()
    {
        $lista = [];
        $id_user = Auth::id(); // Obtiene el ID del usuario logueado
        return view('Aspirantes.generales', ['lista' => $lista, 'id_user' => $id_user]);
    }
    public function index_curriculms()
    {
        $lista = [];
        $id_user = Auth::id(); // Obtiene el ID del usuario logueado
        return view('Aspirantes.curriculums', ['lista' => $lista, 'id_user' => $id_user]);
    }
    public function index_archivos()
    {
        $lista = [];
        $id_user = Auth::id(); // Obtiene el ID del usuario logueado
        return view('Aspirantes.archivos', ['lista' => $lista, 'id_user' => $id_user]);
    }
    public function generar_cv1()
    {
        $usuario = Auth::user();
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
            ->where('users.id', $usuario->id)
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
            ->where('padron_curriculum_datos_academicos.user_id', $usuario->id)
            ->get();
        $pad_experiencias_laboral = \DB::table('padron_curriculum_experiencias_laborales')
            ->select(
                'padron_curriculum_experiencias_laborales.*',
                'cat_giros.descripcion as giro'
            )
            ->join('cat_giros','cat_giros.id','=','padron_curriculum_experiencias_laborales.id_giro_el')
            ->whereNull('padron_curriculum_experiencias_laborales.deleted_at')
            ->where('padron_curriculum_experiencias_laborales.user_id',$usuario->id)
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
            ->join('cat_periodos','cat_periodos.id','=','padron_curriculum_experiencias_electorales.id_periodo_ee')
            ->whereNull('padron_curriculum_experiencias_electorales.deleted_at')
            ->where('padron_curriculum_experiencias_electorales.user_id',$usuario->id)
            ->get();
        $pad_conocimientos_electoral = \DB::table('padron_curriculum_conocimientos_electorales')
            ->select(
                'padron_curriculum_conocimientos_electorales.*',
                'cat_conocimientos_electorales.descripcion as conocimiento'
            )
            ->join('cat_conocimientos_electorales','cat_conocimientos_electorales.id','=','padron_curriculum_conocimientos_electorales.id_tipo_ce')
            ->whereNull('padron_curriculum_conocimientos_electorales.deleted_at')
            ->where('padron_curriculum_conocimientos_electorales.user_id',$usuario->id)
            ->get();
        $pad_trayectorias = \DB::table('padron_curriculum_experiencias_docentes')
            ->whereNull('deleted_at')
            ->where('user_id', $usuario->id)
            ->get();
        $pdf = Pdf::loadView('reportes.aspirantes.cv', compact('datos', 'pad_datos_academicos', 'pad_experiencias_laboral', 'pad_experiencias_electoral', 'pad_conocimientos_electoral', 'pad_trayectorias'));
        $pdf->setPaper('letter', 'portrait');
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);

        $nombreArchivo = 'CV_' . $usuario->id . '.pdf';
        $directorio = storage_path('app/public/aspirantes/pdf/generados/');
        if (!file_exists($directorio)) {
            mkdir($directorio, 0755, true);
        }
        $rutaArchivo = $directorio . $nombreArchivo;
        file_put_contents($rutaArchivo, $pdf->output());

        
        Mail::send(
            'reportes.aspirantes.email_cv',
            [
                'nombre' => $datos->nombre . " " . $datos->apaterno . " " . $datos->amaterno,
                'folio'  => $datos->folio,
                'fecha'  => now()->format('d/m/Y')
            ],
            function ($mail) use ($rutaArchivo, $nombreArchivo, $datos) {
                $mail->to($datos->email)
                    ->subject('Currículum Vitae - Registro de Aspirante')
                    ->attach(
                        $rutaArchivo,
                        [
                            'as' => $nombreArchivo,
                            'mime' => 'application/pdf'
                        ]
                    );
            }
        );
        
        return response()->download(
            $rutaArchivo
        );

    }
    public function generar_acuse1()
    {
        $usuario = Auth::user();
        /*
        |--------------------------------------------------------------------------
        | Datos del aspirante
        |--------------------------------------------------------------------------
        */
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
            ->where('users.id',$usuario->id)
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
            abort(404,'No existe información del aspirante');
        }
        $folio_registro = $registro->folio;
        $nombre =
            $registro->nombre." ".
            $registro->apaterno." ".
            $registro->amaterno;
        /*
        |--------------------------------------------------------------------------
        | Distrito / Municipio
        |--------------------------------------------------------------------------
        */
        $descripcion_distrito_municipio = '';

        if($registro->id_municipal){

            $municipio = \DB::table('cat_municipios')
                ->where('id_municipio', $registro->id_municipal)
                ->select('municipio_local as descripcion')
                ->first();

            if($municipio){
                $descripcion_distrito_municipio = $municipio->descripcion;
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
                    'CONCAT(cat_distritos_municipios.id_distrito, " ", cat_municipios.municipio_local) as descripcion'
                )
                ->first();

            if($distrito){
                $descripcion_distrito_municipio = $distrito->descripcion;
            }
        }
        $distrital_municipal = $registro->cargo;
        // cuando se guarda el último módulo de documentos
        $finalizar_proceso_registro = \DB::table('padron_documentos_subidos')
            ->whereNull('deleted_at')
            ->where('user_id', $usuario->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $fecha_creacion_final = "";
        $hora_creacion_final = "";
        if($finalizar_proceso_registro){
            \Carbon\Carbon::setLocale('es');
            $fecha_creacion_final = ucfirst(
                \Carbon\Carbon::parse($finalizar_proceso_registro->created_at)
                    ->translatedFormat('l d \d\e F \d\e Y')
            );
            $hora_creacion_final = \Carbon\Carbon::parse($finalizar_proceso_registro->created_at)
                ->format('H:i');
        }
        /*
        |--------------------------------------------------------------------------
        | Generar PDF
        |--------------------------------------------------------------------------
        */
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
        $pdf->setPaper(
            'letter',
            'portrait'
        );
        $pdf->getDomPDF()
            ->set_option(
                'isRemoteEnabled',
                true
            );
        /*
        |--------------------------------------------------------------------------
        | Guardar PDF
        |--------------------------------------------------------------------------
        */
        $archivo = 'acuse_'.$folio_registro.'.pdf';

        $carpeta = storage_path('app/public/aspirantes/pdf/generados');

        if(!file_exists($carpeta)){
            mkdir($carpeta, 0777, true);
        }

        $rutaArchivo = storage_path(
            'app/public/aspirantes/pdf/generados/'.$archivo
        );

        file_put_contents(
            $rutaArchivo,
            $pdf->output()
        );
        /*
        |--------------------------------------------------------------------------
        | Enviar correo
        |--------------------------------------------------------------------------
        */
        
        Mail::send(
            'reportes.aspirantes.email_acuse',
            [
                'nombre'=>$nombre,
                'folio'=>$folio_registro,
                'fecha'=>now()->format('d/m/Y')
            ],
            function($mail) use(
                $registro,
                $rutaArchivo,
                $archivo
            ){
                $mail->to(
                    $registro->email
                )
                ->subject(
                    'Acuse de registro electrónico - Aspirante'
                )
                ->attach(
                    $rutaArchivo,
                    [
                        'as'=>$archivo,
                        'mime'=>'application/pdf'
                    ]
                );
            }
        );
        /*
        |--------------------------------------------------------------------------
        | Descargar PDF
        |--------------------------------------------------------------------------
        */
        return response()->download(
            $rutaArchivo
        );
    }
    public function generar_constancia1()
    {
            $usuario = Auth::user();


            // DATOS DEL ASPIRANTE
            $datos = \DB::table('users')
                ->join(
                    'padron_generales',
                    'users.id',
                    '=',
                    'padron_generales.user_id'
                )
                ->where('users.id', $usuario->id)
                ->whereNull('padron_generales.deleted_at')
                ->select(
                    'users.nombre',
                    'users.apaterno',
                    'users.amaterno',
                    'users.email',
                    'padron_generales.folio',
                    'padron_generales.id_tipo_cargo',
                    'padron_generales.id_distrital',
                    'padron_generales.id_municipal'
                )
                ->first();

            if (!$datos) {
                abort(404, 'No existe información del aspirante');
            }

            /*
            |--------------------------------------------------------------------------
            | CONSEJO
            |--------------------------------------------------------------------------
            */

            $tipoConsejo = '';
            $descripcion_distrito_municipio = '';

            if ($datos->id_tipo_cargo == 1) {

                $tipoConsejo = 'DISTRITAL';

                $distrito = \DB::table('cat_distritos_municipios')
                    ->join(
                        'cat_municipios',
                        'cat_municipios.id_municipio',
                        '=',
                        'cat_distritos_municipios.id_municipio'
                    )
                    ->where(
                        'cat_distritos_municipios.id_distrito',
                        $datos->id_distrital
                    )
                    ->where(
                        'cat_distritos_municipios.cabecera_distrital',
                        1
                    )
                    ->select(
                        'cat_distritos_municipios.id_distrito',
                        'cat_municipios.municipio_local'
                    )
                    ->first();

                if ($distrito) {

                    $descripcion_distrito_municipio =
                        'DISTRITO ' .
                        $distrito->id_distrito .
                        ' ' .
                        $distrito->municipio_local;
                }

            } else {

                $tipoConsejo = 'MUNICIPAL';

                $municipio = \DB::table('cat_municipios')
                    ->where(
                        'id_municipio',
                        $datos->id_municipal
                    )
                    ->first();

                if ($municipio) {

                    $descripcion_distrito_municipio =
                        $municipio->municipio_local;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | QR
            |--------------------------------------------------------------------------
            */

            $builder = new \Endroid\QrCode\Builder\Builder(

                writer: new \Endroid\QrCode\Writer\PngWriter(),

                data:
                    'Folio aspirante: ' .
                    $datos->folio,

                size: 600,

                margin: 20,

                encoding: new \Endroid\QrCode\Encoding\Encoding('UTF-8')

            );

            $qr = $builder->build();

            $codigoQR =
                'data:image/png;base64,' .
                base64_encode(
                    $qr->getString()
                );

            /*
            |--------------------------------------------------------------------------
            | FECHA
            |--------------------------------------------------------------------------
            */

            $fecha = now();

            /*
            |--------------------------------------------------------------------------
            | PDF
            |--------------------------------------------------------------------------
            */

            $pdf = Pdf::loadView(
                'reportes.aspirantes.constancia',
                compact(
                    'datos',
                    'codigoQR',
                    'tipoConsejo',
                    'descripcion_distrito_municipio',
                    'fecha'
                )
            );

            $pdf->setPaper(
                'letter',
                'portrait'
            );

            $pdf->getDomPDF()->set_option(
                'isRemoteEnabled',
                true
            );

            /*
            |--------------------------------------------------------------------------
            | GUARDAR PDF
            |--------------------------------------------------------------------------
            */

            $archivo = 'constancia_' . $datos->folio . '.pdf';

            $carpeta = storage_path(
                'app/public/aspirantes/pdf/generados'
            );

            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            $rutaArchivo = $carpeta . '/' . $archivo;

            file_put_contents(
                $rutaArchivo,
                $pdf->output()
            );

            /*
            |--------------------------------------------------------------------------
            | CORREO
            |--------------------------------------------------------------------------
            */

            $nombreCompleto =
                $datos->nombre . ' ' .
                $datos->apaterno . ' ' .
                $datos->amaterno;

            Mail::send(
                'reportes.aspirantes.email_constancia',
                [
                    'nombre' => $nombreCompleto,
                    'folio'  => $datos->folio,
                    'fecha'  => now()->format('d/m/Y')
                ],
                function ($mail) use (
                    $datos,
                    $rutaArchivo,
                    $archivo
                ) {

                    $mail->to(
                        $datos->email
                    )
                    ->subject(
                        'Constancia de registro - Aspirante'
                    )
                    ->attach(
                        $rutaArchivo,
                        [
                            'as'   => $archivo,
                            'mime' => 'application/pdf'
                        ]
                    );
                }
            );

            /*
            |--------------------------------------------------------------------------
            | DESCARGAR PDF
            |--------------------------------------------------------------------------
            */

            return response()->download(
                $rutaArchivo
            );


    }

    private function obtenerDatosUsuario($id)
    {
        // tu consulta real
        return [];
    }
    /**
     * Store a new ciudadano registration.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);
        $user = $request->user();
        // Attach user_id if authenticated
        if ($user) {
            $data['user_id'] = $user->id;
            // Optionally ensure the user has the Aspirante role
            if (method_exists($user, 'assignRole') && ! $user->hasRole('Aspirante')) {
                $user->assignRole('Aspirante');
            }
        }
        // Create or update ciudadano by email
        $ciudadano = Ciudadano::updateOrCreate(
            ['email' => $data['email']],
            $data
        );
        return redirect()->route('dashboard')->with('status', 'Registro aspirante guardado correctamente.');
    }
}
