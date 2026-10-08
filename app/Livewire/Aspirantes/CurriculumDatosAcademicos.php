<?php
namespace App\Livewire\Aspirantes;
use Livewire\Component;
use App\Models\Aspirantes\CurriculumDatosAcademicos as ModelAcademico;
use App\Models\Catalogos\CatalogoGeneral;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CurriculumDatosAcademicos extends Component
{
    public $user_id;
    public $id_nivel_estudios;
    public $id_carrera;
    public $otra_carrera;
    public $id_status_nivel_estudios;
    public $id_otros_estudios;
    public $posgrado;
    public $id_status_otro_estudios;

    public $datos = [];
    public $mostrar_carrera=false;
    public $mostrar_otra_carrera=false;
    public $mostrar_estatus_nivel_estudios=false;
    public $mostrar_otros_estudios=false;
    public $mostrar_posgrado=false;
    public $mostrar_estatus_posgrado=false;
    protected function rules()
    {
        return [
            'id_nivel_estudios' => 'required|not_in:0',
            'id_carrera' => 'nullable|required_if:id_nivel_estudios,5|not_in:0',
            'otra_carrera' => [
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(function () {
                    return (string) $this->id_nivel_estudios === '4'
                        || (
                            (string) $this->id_nivel_estudios === '5'
                            && (string) $this->id_carrera === '9'
                        );
                }),
            ],
            'id_status_nivel_estudios' => 'nullable|required_if:id_nivel_estudios,4,5|not_in:0',
            'id_otros_estudios' => 'nullable|required_if:id_nivel_estudios,5|not_in:0',
            'posgrado' => 'nullable|required_if:id_otros_estudios,1,2,3|string|max:255',
            'id_status_otro_estudios' => 'nullable|required_if:id_otros_estudios,1,2,3|not_in:0',
        ];
    }
    protected $messages = [
        'id_nivel_estudios.required' => 'Seleccione el nivel de estudios.',
        'id_carrera.required_if' => 'Seleccione la carrera.',
        'otra_carrera.required' => 'Capture la licenciatura.',
        'id_status_nivel_estudios.required_if' => 'Seleccione el estatus del estudio.',
        'id_otros_estudios.required_if' => 'Seleccione otros estudios.',
        'posgrado.required_if' => 'Capture el posgrado.',
        'id_status_otro_estudios.required_if' => 'Seleccione el estatus del otro estudio.',
    ];
    public function mount($user_id = null)
    {
        $this->user_id = $user_id ?? auth()->id();
        $this->cargarDatos();
        $this->updatedIdNivelEstudios($this->id_nivel_estudios);
        if((string) $this->id_nivel_estudios === '5'){
            $this->updatedIdCarrera($this->id_carrera);
        }
        $this->updatedIdOtrosEstudios($this->id_otros_estudios);
    }
    /*
    ================================================
    CAMBIO NIVEL ESTUDIOS
    ================================================
    */
    public function updatedIdNivelEstudios($value)
    {
        $this->mostrar_carrera = false;
        $this->mostrar_otra_carrera = false;
        $this->mostrar_estatus_nivel_estudios = false;
        $this->mostrar_otros_estudios = false;
        $this->mostrar_posgrado = false;
        $this->mostrar_estatus_posgrado = false;

        // Nivel 4
        if($value == 4){

            // Bachillerato no utiliza el catálogo de carreras.
            $this->mostrar_otra_carrera = true;
            $this->mostrar_estatus_nivel_estudios = true;
            $this->id_carrera = null;

            // Ocultar posgrado
            $this->mostrar_posgrado = false;
            $this->mostrar_estatus_posgrado = false;
        }

        // Nivel 5
        if($value == 5){

            $this->mostrar_carrera = true;
            $this->mostrar_estatus_nivel_estudios = true;

            // Mostrar otros estudios y posgrado
            $this->mostrar_otros_estudios = true;
            //$this->mostrar_posgrado = true;
            //$this->mostrar_estatus_posgrado = true;
        }

        if(!$this->mostrar_carrera){
            $this->id_carrera = null;

            if(!$this->mostrar_otra_carrera){
                $this->otra_carrera = null;
            }
        }

        if(!$this->mostrar_estatus_nivel_estudios){
            $this->id_status_nivel_estudios = null;
        }

        if(!$this->mostrar_otros_estudios){
            $this->id_otros_estudios = null;
            $this->posgrado = null;
            $this->id_status_otro_estudios = null;
        }

       /* if(!$this->mostrar_posgrado){
            $this->posgrado = null;
            $this->id_status_otro_estudios = null;
        }*/

        $this->dispatch('refresh-select2');
    }
    /*
    ================================================
    CAMBIO CARRERA
    ================================================
    */
    public function updatedIdCarrera($value)
    {
        if((string) $this->id_nivel_estudios !== '5'){
            return;
        }

        $this->mostrar_otra_carrera = false;
        if($value == 9){
            $this->mostrar_otra_carrera = true;
        }
        else{
            $this->otra_carrera = null;
        }
        $this->dispatch('refresh-select2');
    }
    /*
    ================================================
    CAMBIO OTROS ESTUDIOS
    ================================================
    */
    public function updatedIdOtrosEstudios($value)
    {
        $this->mostrar_posgrado = false;
        $this->mostrar_estatus_posgrado = false;
        if(in_array($value,[1,2,3])){
            $this->mostrar_posgrado = true;
            $this->mostrar_estatus_posgrado = true;
        }
        else{
            $this->posgrado = null;
            $this->id_status_otro_estudios = null;
        }
        $this->dispatch('refresh-select2');
    }

    public function cargarDatos()
    {
        $datos =
        ModelAcademico::where(
            'user_id',
            $this->user_id
        )->first();
        if($datos){
            $this->fill(
                $datos->toArray()
            );
        }
        //$this->datos = ModelAcademico::where('user_id',$this->user_id)->get();
    }
    public function storeDatosAcademicos()
    {
        if((string) $this->id_nivel_estudios === '4'){
            $this->id_carrera = null;
        }

        if(
            (string) $this->id_nivel_estudios !== '4' &&
            !(
                (string) $this->id_nivel_estudios === '5' &&
                (string) $this->id_carrera === '9'
            )
        ){
            $this->otra_carrera = null;
        }

        $this->otra_carrera = trim((string) ($this->otra_carrera ?? '')) ?: null;

        $this->validate();
        DB::beginTransaction();
        try {
            ModelAcademico::updateOrCreate(
                [
                    'user_id' => $this->user_id
                ],
                [
                    'user_id' => $this->user_id,
                    'id_nivel_estudios' => $this->id_nivel_estudios,
                    'id_carrera' => $this->id_carrera,
                    'otra_carrera' => $this->otra_carrera,
                    'id_status_nivel_estudios' => $this->id_status_nivel_estudios,
                    'id_otros_estudios' => $this->id_otros_estudios,
                    'posgrado' => $this->posgrado,
                    'id_status_otro_estudios' => $this->id_status_otro_estudios,
                ]
            );

            // ERROR DE PRUEBA
            //throw new \Exception('Error de prueba: no se pudo guardar');

            DB::commit();
            $this->cargarDatos();
            
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Guardado correctamente',
                'text' => 'Los datos académicos fueron guardados.'
            ]);
            $this->dispatch('actualizarChecklist');
        } catch(\Exception $e){
            DB::rollBack();
            // Guarda el error real en el log
            Log::error($e->getMessage());
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error al guardar',
                'text' => 'Ocurrió un error al guardar los datos académicos.'
            ]);
        }
    }
    public function render()
    {
        return view('livewire.aspirantes.curriculum-datos-academicos',
            [
                'nivelEstudiosLicenciaturas'=>CatalogoGeneral::get_nivel_estudios(),
                'carreras'=>CatalogoGeneral::get_carreras(),
                'estatusNivelEstudiosLicenciaturas'=>CatalogoGeneral::get_estatus_nivel_estudios(),
                'estudios_posgrados'=>CatalogoGeneral::get_estudios_posgrados(),
                'estatusNivelEstudiosposgrados'=>CatalogoGeneral::get_estatus_nivel_estudios(),
            ]
        );
    }
}
