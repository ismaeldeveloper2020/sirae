<?php
namespace App\Livewire\Aspirantes;
use Livewire\Component;
use App\Models\Aspirantes\Generales as modelGenerales;
use App\Models\Catalogos\CatalogoGeneral;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class Generales extends Component
{
    /*
    VZRQLN87052207M800
    LPRVAL80052707H400
    MAPE980330	GL0   	MAPE980330HCSZRS02
    */
    public $id_usuario;
    public $id_padron_aspirante;
    public $folio;
    public $id_tipo_cargo;
    public $id_distrital;
    public $id_municipal;
    // PERSONALES
    public $nombre;
    public $apaterno;
    public $amaterno;
    public $rfc;
    public $homoclave;
    public $curp;
    // DATOS GENERALES
    public $id_discapacidad;
    public $id_genero;
    public $telefono_casa;
    public $telefono_movil;
    // IDENTIDAD
    public $id_tipo_licencia;
    public $id_etnia;
    public $id_idioma_predominante;
    public $id_otro_idioma;
    public $especifique_idioma;
    public $ocupacion_actual;
    public $clave_elector;
    // CALCULADOS
    public $fecha_nacimiento;
    public $genero;
    public $edad;
    // DOMICILIO
    public $calle;
    public $num_casa_exterior;
    public $num_casa_interior;
    public $colonia;
    public $cp;
    public $id_estado='07';
    public $id_municipio;
    public $mostrar_distrito=false;
    public $mostrar_municipio=false;
    public $mostrar_otro_idioma=false;
    public $clave_elector_mensaje='';

    protected function rules()
    {
        return [
            // ================= STEP 1 =================
            'id_tipo_cargo' => 'required|not_in:0',
            'id_distrital' => 'required_if:id_tipo_cargo,1',
            'id_municipal' => 'required_if:id_tipo_cargo,2',
            // ================= DATOS PERSONALES =================
            'nombre' => 'required|string|max:255',
            'apaterno' => 'required|string|max:255',
            'amaterno' => 'nullable|string|max:255',
            // ================= IDENTIFICACIÓN =================
            'rfc' => 'required|string|min:10|max:13',
            'homoclave' => 'nullable|string|max:3',
            'curp' => [
                'required',
                'size:18',
                'regex:/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9A-Z]{2}$/'
            ],
            // ================= DATOS GENERALES =================
            'id_discapacidad' => 'required|not_in:0',
            'id_genero' => 'required|not_in:0',
            'telefono_casa' =>
                'nullable|digits:10',
            'telefono_movil' =>
                'required|digits:10',
            // ================= IDENTIDAD =================
            'id_tipo_licencia' =>
                'required|not_in:0',
            'id_etnia' =>
                'required|not_in:0',
            'id_idioma_predominante' =>
                'required|not_in:0',
            'id_otro_idioma' =>
                'required|not_in:0',
            'especifique_idioma' => [
                'nullable',
                'required_if:id_otro_idioma,14',
                'string',
                'max:255'
            ],
            // ================= INFORMACIÓN LABORAL =================
            'ocupacion_actual' =>
                'required|string|max:255',
            'clave_elector' => [
                'required',
                'size:18',
                'regex:/^[A-Z]{6}[0-9]{8}[HM][0-9]{3}$/i',
                Rule::unique('padron_generales','clave_elector')
                    ->ignore($this->id_usuario,'user_id')
            ],
            // ================= CALCULADOS =================
            'fecha_nacimiento' =>
                'nullable',
            'genero' =>
                'nullable',
            'edad' =>
                'nullable',
            // ================= DOMICILIO =================
            'calle' =>
                'required|string|max:255',
            'num_casa_exterior' =>
                'required|string|max:20',
            'num_casa_interior' =>
                'nullable|string|max:20',
            'colonia' =>
                'required|string|max:255',
            'cp' => [
                'required',
                'digits:5'
            ],
            /*'id_estado' =>
                'required|not_in:0',*/
            'id_municipio' =>
                'required|not_in:0',
        ];
    }

    protected $messages = [
        // ================= SELECTS =================
        'id_tipo_cargo.required' =>
            'Debe seleccionar el tipo de enlace.',
        'id_tipo_cargo.not_in' =>
            'Debe seleccionar el tipo de enlace.',
        'id_discapacidad.required' =>
            'Debe seleccionar discapacidad.',
        'id_discapacidad.not_in' =>
            'Debe seleccionar discapacidad.',
        'id_genero.required' =>
            'Debe seleccionar el género.',
        'id_genero.not_in' =>
            'Debe seleccionar el género.',
        'id_tipo_licencia.required' =>
            'Debe seleccionar el tipo de licencia.',
        'id_tipo_licencia.not_in' =>
            'Debe seleccionar el tipo de licencia.',
        'id_etnia.required' =>
            'Debe seleccionar la etnia.',
        'id_etnia.not_in' =>
            'Debe seleccionar la etnia.',
        'id_idioma_predominante.required' =>
            'Debe seleccionar el idioma predominante.',
        'id_idioma_predominante.not_in' =>
            'Debe seleccionar el idioma predominante.',
        'id_otro_idioma.required' =>
            'Debe seleccionar una opción.',
        'id_otro_idioma.not_in' =>
            'Debe seleccionar una opción.',
        // ================= CONDICIONALES =================
        'id_distrital.required_if' =>
            'Debe seleccionar el distrito.',
        'id_municipal.required_if' =>
            'Debe seleccionar el municipio.',
        'especifique_idioma.required_if' =>
            'Debe especificar la lengua seleccionada.',
        // ================= PERSONALES =================
        'nombre.required' =>
            'El nombre es obligatorio.',
        'apaterno.required' =>
            'El primer apellido es obligatorio.',
        // ================= RFC =================
        'rfc.required' =>
            'El RFC es obligatorio.',
        'rfc.min' =>
            'El RFC debe contener mínimo 10 caracteres.',
        'rfc.max' =>
            'El RFC no puede contener más de 13 caracteres.',
        // ================= CURP =================
        'curp.required' =>
            'La CURP es obligatoria.',
        'curp.size' =>
            'La CURP debe contener exactamente 18 caracteres.',
        'curp.regex' =>
            'La estructura de la CURP no es válida.',
        // ================= CLAVE ELECTOR =================
        'clave_elector.required' =>
            'La clave de elector es obligatoria.',
        'clave_elector.size' =>
            'La clave de elector debe tener exactamente 18 caracteres.',
        'clave_elector.regex' =>
            'La estructura de la clave de elector no es válida.',
        'clave_elector.unique' =>
            'La clave de elector ya está registrada.',
        // ================= TELEFONOS =================
        'telefono_casa.digits' =>
            'El teléfono de casa debe tener exactamente 10 dígitos.',
        'telefono_movil.required' =>
            'El teléfono celular es obligatorio.',
        'telefono_movil.digits' =>
            'El teléfono celular debe tener exactamente 10 dígitos.',
        // ================= CP =================
        'cp.required' =>
            'El código postal es obligatorio.',
        'cp.digits' =>
            'El código postal debe contener exactamente 5 números.',
        // ================= DOMICILIO =================
        'calle.required' =>
            'La calle es obligatoria.',
        'num_casa_exterior.required' =>
            'El número exterior es obligatorio.',
        'colonia.required' =>
            'La colonia es obligatoria.',
        /*'id_estado.required' =>
            'Debe seleccionar el estado.',
        'id_estado.not_in' =>
            'Debe seleccionar el estado.',*/
        'id_municipio.required' =>
            'Debe seleccionar el municipio.',
        'id_municipio.not_in' =>
            'Debe seleccionar el municipio.',

    ];

    private function validarModulo()
    {
        $estatus = DB::table('padron_aspirantes_modulos')
            ->where('user_id', $this->id_usuario)
            ->value('modulo_registro');

        $mensajes = [
            1 => 'El proceso ya fue finalizado y se encuentra en revisión y validación de documentos. No puede realizar cambios por el momento.',
            2 => 'Su registro tiene requerimientos pendientes de atender. Revise las observaciones y sustituya los documentos solicitados.',
            3 => 'Los documentos subsanados fueron enviados y se encuentran en revisión final. No puede realizar cambios por el momento.',
            4 => 'Existen nuevos requerimientos pendientes de atender. Revise las observaciones y sustituya los documentos correspondientes.',
            5 => 'Su registro ha sido validado correctamente. Ya no es posible realizar modificaciones.',
        ];

        if (isset($mensajes[$estatus])) {
            session()->flash('error_modulo', $mensajes[$estatus]);
            return redirect()->route('dashboard');

        }
    }

    public function mount($user_id = null)
    {
        // Si no recibe un user_id, es el aspirante editando sus datos
        $this->id_usuario = $user_id ?? auth()->id();

        // Solo validar cuando el aspirante entra a su propio módulo
        if (is_null($user_id)) {
            $this->validarModulo();
        }

        $this->cargarDatos();
        $this->updatedIdTipoCargo(
            $this->id_tipo_cargo
        );
        $this->updatedIdOtroIdioma(
            $this->id_otro_idioma
        );
    }

    public function generarFolio(): string
    {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $folio = '';

        for ($i = 0; $i < 10; $i++) {
            $folio .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }

        return $folio;
    }

    /*
    ================================================
    CAMBIO TIPO DE ENLACE
    ================================================
    */
    public function updatedIdTipoCargo($value)
    {
        if(!$this->id_distrital){
            $this->id_distrital=null;
        }
        if(!$this->id_municipal){
            $this->id_municipal=null;
        }
        $this->mostrar_distrito=false;
        $this->mostrar_municipio=false;
        if($value==1){
            $this->mostrar_distrito=true;
        }
        if($value==2){
            $this->mostrar_municipio=true;
        }
        $this->dispatch('refresh-select2');
    }
    public function updatedIdOtroIdioma($value)
    {
        $this->mostrar_otro_idioma = false;
        if($value == 14){
            $this->mostrar_otro_idioma = true;
            // conserva el valor si ya existe
            if(empty($this->especifique_idioma)){
                $this->especifique_idioma = null;
            }
        }
        else
        {
            // solo limpiar si cambia a otra opción
            $this->especifique_idioma = null;
        }
        $this->dispatch('refresh-select2');
    }
    // 🕓 Validar con un pequeño retardo de 400 ms después de escribir
    public function updatedClaveElector($value)
    {
        $this->clave_elector = strtoupper(trim($value));
        $this->clave_elector_mensaje = '';
        $this->fecha_nacimiento = null;
        $this->edad = null;
        $this->genero = null;
        if (empty($this->clave_elector)) {
            return;
        }
        $len = strlen($this->clave_elector);
        // Validar longitud
        if ($len < 18) {
            $faltan = 18 - $len;
            $this->clave_elector_mensaje = 
                "La clave de elector debe tener 18 caracteres. Faltan {$faltan}.";
        }
        // Primeros 6 caracteres
        if ($len <= 6) {
            if (!preg_match('/^[A-Z]*$/', $this->clave_elector)) {
                $this->clave_elector_mensaje = 'Los primeros 6 caracteres deben ser letras.';
            }
            return;
        }
        // Posiciones 7-14 (fecha)
        if ($len > 6 && $len <= 14) {
            $fecha = substr($this->clave_elector, 6);
            if (!preg_match('/^\d*$/', $fecha)) {
                $this->clave_elector_mensaje = 'Los caracteres 7 al 14 deben ser números.';
            }
            return;
        }
        // Posición 15 (sexo)
        if ($len == 15) {
            $sexo = substr($this->clave_elector, 14, 1);
            if (!preg_match('/^[HM]$/i', $sexo)) {
                $this->clave_elector_mensaje = 'El carácter 15 debe ser H o M.';
            }
            return;
        }
        // Posiciones 16-18
        if ($len > 15 && $len < 18) {
            $ultimo = substr($this->clave_elector, 15);
            if (!preg_match('/^\d*$/', $ultimo)) {
                $this->clave_elector_mensaje = 'Los últimos 3 caracteres deben ser numéricos.';
            }
            return;
        }
        // Validación completa
        if ($len === 18) {
            if ($this->validarFormatoClaveElector($this->clave_elector)) {
                $this->buscarClaveElector($this->clave_elector);
            }
            return;
        }
    }
    // ✅ Valida estructura, fecha, sexo y edad
    private function validarFormatoClaveElector($clave)
    {
        if (!preg_match('/^[A-Z]{6}[0-9]{8}[HM][0-9]{3}$/i', $clave)) {
            $this->clave_elector_mensaje = 'La estructura de la clave de elector es inválida.';
            return false;
        }
        $anio = intval(substr($clave, 6, 2));
        $mes  = intval(substr($clave, 8, 2));
        $dia  = intval(substr($clave, 10, 2));
        $anio += ($anio <= 30) ? 2000 : 1900;
        if (!checkdate($mes, $dia, $anio)) {
            $this->clave_elector_mensaje = 'Fecha de nacimiento inválida.';
            return false;
        }
        $fecha = Carbon::createFromDate($anio, $mes, $dia);
        $this->fecha_nacimiento = $fecha->format('Y-m-d');
        $this->edad = $fecha->age;
        $sexo = strtoupper(substr($clave, 14, 1));
        $this->genero = $sexo === 'H'
            ? 'HOMBRE'
            : 'MUJER';
        $this->clave_elector_mensaje = '';
        return true;
    }
    // 🔍 Verificar existencia en BD
    public function buscarClaveElector($clave)
    {
        $existe = modelGenerales::where('clave_elector', $clave)->exists();
        if ($existe) {
            $this->clave_elector_mensaje =
                '⚠️ La clave de elector ya está registrada en el padrón.';
            $this->fecha_nacimiento = null;
            $this->edad = null;
            $this->genero = null;
            return;
        }
        $this->clave_elector_mensaje = '';
    }
    public function cargarDatos()
    {
        $generales = modelGenerales::where('user_id', $this->id_usuario)->first();
        $user = User::find($this->id_usuario);

        $this->fill([
            // ================= PERSONALES =================
           
            'nombre' => $this->safeValue($generales->nombre ?? $user->nombre ?? null),
            'apaterno' => $this->safeValue($generales->apaterno ?? $user->apaterno ?? null),
            'amaterno' => $this->safeValue($generales->amaterno ?? $user->amaterno ?? null),

            // ================= IDENTIFICACIÓN =================
            'folio' => $this->safeValue($generales->folio ?? null),
            'rfc' => $this->safeValue($generales->rfc ?? null),
            'homoclave' => $this->safeValue($generales->homoclave ?? null),
            'curp' => $this->safeValue($generales->curp ?? null),
            'clave_elector' => $this->safeValue($generales->clave_elector ?? null),

            // ================= TIPOS =================
            'id_tipo_cargo' => $this->safeValue($generales->id_tipo_cargo ?? null),
            'id_distrital' => $this->safeValue($generales->id_distrital ?? null),
            'id_municipal' => $this->safeValue($generales->id_municipal ?? null),

            // ================= GENERALES =================
            'id_discapacidad' => $this->safeValue($generales->id_discapacidad ?? null),
            'id_genero' => $this->safeValue($generales->id_genero ?? null),
            'telefono_casa' => $this->safeValue($generales->telefono_casa ?? null),
            'telefono_movil' => $this->safeValue($generales->telefono_movil ?? null),

            // ================= IDENTIDAD =================
            'id_tipo_licencia' => $this->safeValue($generales->id_tipo_licencia ?? null),
            'id_etnia' => $this->safeValue($generales->id_etnia ?? null),
            'id_idioma_predominante' => $this->safeValue($generales->id_idioma_predominante ?? null),
            'id_otro_idioma' => $this->safeValue($generales->id_otro_idioma ?? null),
            'especifique_idioma' => $this->safeValue($generales->especifique_idioma ?? null),

            // ================= LABORAL =================
            'ocupacion_actual' => $this->safeValue($generales->ocupacion_actual ?? null),

            // ================= DOMICILIO =================
            'calle' => $this->safeValue($generales->calle ?? null),
            'num_casa_exterior' => $this->safeValue($generales->num_casa_exterior ?? null),
            'num_casa_interior' => $this->safeValue($generales->num_casa_interior ?? null),
            'colonia' => $this->safeValue($generales->colonia ?? null),
            'cp' => $this->safeValue($generales->cp ?? null),
            'id_estado' => '07',
            'id_municipio' => $this->safeValue($generales->id_municipio ?? null),

            // ================= CALCULADOS =================
            'fecha_nacimiento' => $this->safeValue($generales->fecha_nacimiento ?? null),
            'genero' => $this->safeValue($generales->genero ?? null),
            'edad' => $this->safeValue($generales->edad ?? null),
        ]);
    }

    private function safeValue($value)
    {
        // evita: null, '', '0' problemáticos en selects o inputs
        if ($value === null) {
            return null;
        }

        if ($value === '') {
            return null;
        }

        // opcional: evita 0 en selects si usas not_in:0
        if ($value === 0 || $value === '0') {
            return null;
        }

        return $value;
    }

    public function storeGenerales()
    {
        //dd(get_object_vars($this));
        /*
        dd([
            'id_tipo_cargo' => $this->id_tipo_cargo,
            'id_distrital' => $this->id_distrital,
            'id_municipal' => $this->id_municipal,
            'nombre' => $this->nombre,
        ]);
        */
        $this->validate();
        DB::beginTransaction();
        try{
            // Buscar si ya existe registro del usuario
            $registro = modelGenerales::where('user_id', $this->id_usuario)->first();
            // Si es nuevo registro genera folio único
            if (!$registro) {
                do {
                    $this->folio = $this->generarFolio();
                } while (
                    modelGenerales::where('folio', $this->folio)->exists()
                );
            }

            modelGenerales::updateOrCreate(
            [
                'user_id'=>$this->id_usuario
            ],
            [
                'user_id'=>$this->id_usuario,
                'folio'=>$this->folio,
                'id_tipo_cargo'=>$this->id_tipo_cargo,
                'id_distrital'=>$this->id_distrital,
                'id_municipal'=>$this->id_municipal,
                'nombre'=>$this->nombre,
                'apaterno'=>$this->apaterno,
                'amaterno'=>$this->amaterno,
                'rfc'=>strtoupper($this->rfc),
                'homoclave'=>strtoupper($this->homoclave),
                'curp'=>strtoupper($this->curp),
                'id_discapacidad'=>$this->id_discapacidad,
                'id_genero'=>$this->id_genero,
                'telefono_casa'=>$this->telefono_casa,
                'telefono_movil'=>$this->telefono_movil,
                'id_tipo_licencia'=>$this->id_tipo_licencia,
                'id_etnia'=>$this->id_etnia,
                'id_idioma_predominante'=>$this->id_idioma_predominante,
                'id_otro_idioma'=>$this->id_otro_idioma,
                'especifique_idioma'=>$this->especifique_idioma,
                'ocupacion_actual'=>$this->ocupacion_actual,
                'clave_elector'=>$this->clave_elector,
                'fecha_nacimiento'=>$this->fecha_nacimiento,
                'genero'=>$this->genero,
                'edad'=>$this->edad,
                'calle'=>$this->calle,
                'num_casa_exterior'=>$this->num_casa_exterior,
                'num_casa_interior'=>$this->num_casa_interior,
                'colonia'=>$this->colonia,
                'cp'=>$this->cp,
                'id_estado'=>'07',
                'id_municipio'=>$this->id_municipio,
            ]);

            // 🔥 ACTUALIZAR USERS TAMBIÉN
            User::where('id', $this->id_usuario)->update([
                'nombre' => $this->nombre, // si usas name
                'apaterno' => $this->apaterno,
                'amaterno' => $this->amaterno,
            ]);

            DB::commit();
            $this->dispatch('swalDatosAcademicos', [
                'icon' => 'success',
                'title' => 'Correcto',
                'text' => 'Registro guardado correctamente.'
            ]);
            $this->dispatch('folio-generado', folio: $this->folio);
            
        }catch(\Exception $e){
            DB::rollBack();
            $this->dispatch('swalDatosAcademicos', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Ocurrió un error al guardar los datos académicos.'
                //'text' => $e->getMessage()
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.aspirantes.generales',
            [
                'distritos'=>CatalogoGeneral::get_distritos(),
                'municipios'=>CatalogoGeneral::get_municipios(),
                'licencias'=>CatalogoGeneral::get_licencias(),
                'etnias'=>CatalogoGeneral::get_autoadscripcion_indigenas(),
                'idiomas'=>CatalogoGeneral::get_lenguas(),
                'idiomas_otros'=>CatalogoGeneral::get_otras_lenguas(),
                'discapacidades'=>CatalogoGeneral::get_discapacidades(),
                'generos'=>CatalogoGeneral::get_generos(),
                'cargos'=>CatalogoGeneral::get_cargos(),
                'estados'=>CatalogoGeneral::get_estados(),
            ]
        );
    }
}