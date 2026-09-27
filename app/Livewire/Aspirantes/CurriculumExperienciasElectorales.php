<?php
namespace App\Livewire\Aspirantes;
use Livewire\Component;
use App\Models\Aspirantes\CurriculumExperienciasElectorales as ExperienciasElectorales;
use App\Models\Catalogos\CatalogoGeneral;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class CurriculumExperienciasElectorales extends Component
{
    public $experiencia_electoral_id;
    public $user_id;
    public $id_cargo_ee = null;
    public $descripcion_otro_cargo_ee;
    public $id_institucion_ee = null;
    public $descripcion_otro_institucion_ee;
    public $periodo_ee;
    public $datos = [];
    public $mostrar_otro_Cargo=false;
    public $mostrar_otro_instituto=false;

    protected function rules()
    {
        return [
            'id_cargo_ee' => [
                'required',
                'not_in:0',

                Rule::unique(
                    'padron_curriculum_experiencias_electorales',
                    'id_cargo_ee'
                )
                ->where(fn ($query) => $query
                    ->where('user_id', $this->user_id)
                    ->where('id_institucion_ee', $this->id_institucion_ee)
                    ->where('periodo_ee', $this->periodo_ee)
                    ->whereNull('deleted_at')
                )
                ->ignore($this->experiencia_electoral_id),
            ],

            'descripcion_otro_cargo_ee' => [
                'nullable',
                'required_if:id_cargo_ee,22',
                'string',
                'max:255',
            ],

            'id_institucion_ee' => [
                'required',
                'not_in:0',
            ],

            'descripcion_otro_institucion_ee' => [
                'nullable',
                'required_if:id_institucion_ee,8',
                'string',
                'max:255',
            ],

            'periodo_ee' => [
                'required',
                'string',
                'regex:/^\d{4}-\d{4}$/',

                function ($attribute, $value, $fail) {

                    if (preg_match('/^\d{4}-\d{4}$/', $value)) {

                        [$inicio, $fin] = explode('-', $value);

                        if ((int) $fin < (int) $inicio) {
                            $fail('El año final debe ser igual o mayor al año inicial.');
                        }
                    }
                },
            ],
        ];
    }

    protected $messages = [
        'id_cargo_ee.required' => 'Debe seleccionar un cargo.',
        'id_cargo_ee.not_in' => 'Debe seleccionar un cargo válido.',
        'id_cargo_ee.unique' => 'Ya existe una experiencia electoral con el mismo cargo, institución y período.',

        'descripcion_otro_cargo_ee.required_if' => 'Debe especificar el otro cargo.',
        'descripcion_otro_cargo_ee.string' => 'La descripción del otro cargo debe ser texto.',
        'descripcion_otro_cargo_ee.max' => 'La descripción del otro cargo no puede exceder 255 caracteres.',

        'id_institucion_ee.required' => 'Debe seleccionar una institución.',
        'id_institucion_ee.not_in' => 'Debe seleccionar una institución válida.',

        'descripcion_otro_institucion_ee.required_if' => 'Debe especificar la otra institución.',
        'descripcion_otro_institucion_ee.string' => 'La descripción de la otra institución debe ser texto.',
        'descripcion_otro_institucion_ee.max' => 'La descripción de la otra institución no puede exceder 255 caracteres.',

        'periodo_ee.required' => 'Debe capturar el período.',
        'periodo_ee.string' => 'El período debe ser texto.',
        'periodo_ee.regex' => 'El período debe tener el formato YYYY-YYYY. Ejemplo: 2018-2020.',

    ];

    protected $validationAttributes = [
        'id_cargo_ee' => 'cargo',
        'descripcion_otro_cargo_ee' => 'otro cargo',
        'id_institucion_ee' => 'institución',
        'descripcion_otro_institucion_ee' => 'otra institución',
        'periodo_ee' => 'período',
    ];

    public function mount($user_id = null)
    {
        $this->user_id = $user_id ?? auth()->id();
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        $this->datos = ExperienciasElectorales::select(
            'padron_curriculum_experiencias_electorales.*',
            'cat_cargos_ocupados.descripcion as cargo',
            'cat_institutos.descripcion as instituto'
        )
        ->join('cat_cargos_ocupados', 'cat_cargos_ocupados.id', '=', 'padron_curriculum_experiencias_electorales.id_cargo_ee')
        ->join('cat_institutos','cat_institutos.id', '=', 'padron_curriculum_experiencias_electorales.id_institucion_ee')
        ->where('padron_curriculum_experiencias_electorales.user_id',$this->user_id)
        ->get()
        ->toArray();
    }
    /*================================================
    CAMBIO CARGOS
    ================================================
    */
    public function updatedIdCargoEe($value)
    {
        $this->mostrar_otro_Cargo = false;
        if($value == 22){
            $this->mostrar_otro_Cargo = true;
        }
        else{
            $this->descripcion_otro_cargo_ee = null;
        }
          
    }
    /*
    ================================================
    CAMBIO INSTITUCION
    ================================================
    */
    public function updatedIdInstitucionEe($value)
    {
        $this->mostrar_otro_instituto = false;
        if($value == 8){
            $this->mostrar_otro_instituto = true;
        }
        else{
            $this->descripcion_otro_institucion_ee = null;
        }
          
    }

    public function storeExperienciaElectoral()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            ExperienciasElectorales::updateOrCreate(
                [
                    'id'=>$this->experiencia_electoral_id
                ],
                [
                    'user_id'=>$this->user_id,
                    'id_cargo_ee'=> trim($this->id_cargo_ee ?? '') ?: null,
                    'descripcion_otro_cargo_ee'=>trim($this->descripcion_otro_cargo_ee ?? '') ?: null,
                    'id_institucion_ee'=> trim($this->id_institucion_ee ?? '') ?: null,
                    'descripcion_otro_institucion_ee'=>trim($this->descripcion_otro_institucion_ee ?? '') ?: null,
                    'periodo_ee'=>$this->periodo_ee,
                ]
            );
            DB::commit();
            $this->cargarDatos();
            //$this->dispatch('recargarExperiencias');
            $this->dispatch('swalExperienciasElectorales',[
                'icon'=>'success',
                'title'=>'Correcto',
                'text'=>'Registro guardado correctamente.'
            ]);
            $this->limpiarFormulario();
            $this->mostrar_otro_Cargo=false;
            $this->mostrar_otro_instituto=false;
            $this->dispatch('actualizarChecklist');
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatch('swalExperienciasElectorales',[
                'icon'=>'error',
                'title'=>'Error',
                'text'=>$e->getMessage()
            ]);
        }
    } 

    function editarExperienciaElectoral($id)
    {

        $registro = ExperienciasElectorales::findOrFail($id);
        $this->experiencia_electoral_id = $registro->id;
        $this->id_cargo_ee = $registro->id_cargo_ee;
        $this->descripcion_otro_cargo_ee = $registro->descripcion_otro_cargo_ee;
        $this->id_institucion_ee = $registro->id_institucion_ee;
        $this->descripcion_otro_institucion_ee = $registro->descripcion_otro_institucion_ee;
        $this->periodo_ee = $registro->periodo_ee;
        $this->mostrar_otro_Cargo = ($registro->id_cargo_ee == 22);
        $this->mostrar_otro_instituto = ($registro->id_institucion_ee == 8);

        $this->dispatch('actualizarSelectsElectorales');
    }

    public function confirmarDeleteExperienciaElectoral($id)
    {
        $this->experiencia_electoral_id = $id;
        $this->dispatch('confirmaBorrarExperienciaElectoral', id: $id);
    }
    #[On('eliminarRegistroExperienciaElectoral')]
    public function eliminar($id)
    {
        try {
            ExperienciasElectorales::findOrFail($id)->delete();
            $this->cargarDatos();
            //$this->dispatch('refrescarTablaExperiencias');
            $this->dispatch('swalExperienciasElectorales',[
                'icon'=>'success',
                'title'=>'Correcto',
                'text'=>'Registro guardado correctamente.'
            ]);
            $this->dispatch('actualizarChecklist');
        } catch (\Exception $e) {
            $this->dispatch('swalExperienciasElectorales',[
                'icon'=>'error',
                'title'=>'Error',
                'text'=>$e->getMessage()
            ]);
        }
    }
    public function limpiarFormulario()
    {
        $this->experiencia_electoral_id = null;
        $this->id_cargo_ee = null;
        $this->descripcion_otro_cargo_ee = null;
        $this->id_institucion_ee = null;
        $this->descripcion_otro_institucion_ee = null;
        $this->periodo_ee = '';

        $this->dispatch('actualizarSelectsElectorales');
    }
    public function render()
    {
        return view('livewire.aspirantes.curriculum-experiencias-electorales',
            [
                'cargos_ocupados'=>CatalogoGeneral::get_cargos_ocupados(),
                'institutos'=>CatalogoGeneral::get_institutos(),
            ]
        );
    }
}
