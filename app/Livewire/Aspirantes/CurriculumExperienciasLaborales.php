<?php
namespace App\Livewire\Aspirantes;
use Livewire\Component;
use App\Models\Aspirantes\CurriculumExperienciasLaborales as ExperienciasLaborales;
use App\Models\Catalogos\CatalogoGeneral;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class CurriculumExperienciasLaborales extends Component
{
    public $experiencia_laboral_id;
    public $user_id;
    public $id_giro_el = null;
    public $institucion_el;
    public $puesto_el;
    public $periodo_el;
    public $datos = [];
    protected function rules()
    {
        return [
            'id_giro_el' => 'required|not_in:0',
            'institucion_el' => 'required|string|max:255',
            'puesto_el' => 'required|string|max:255',
            'periodo_el' => [
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
        'id_giro_el.required' => 'Seleccione el giro.',
        'id_giro_el.not_in' => 'Seleccione un giro válido.',
        'institucion_el.required' => 'Capture la institución.',
        'institucion_el.string' => 'La institución no es válida.',
        'puesto_el.required' => 'Capture el puesto.',
        'puesto_el.string' => 'El puesto no es válido.',
        'periodo_el.required' => 'Debe capturar el período.',
        'periodo_el.string' => 'El período debe ser texto.',
        'periodo_el.regex' => 'El período debe tener el formato YYYY-YYYY. Ejemplo: 2018-2020.',

    ];
    public function mount($user_id = null)
    {
        $this->user_id = $user_id ?? auth()->id();
        $this->cargarDatos();
    }
    public function cargarDatos()
    {
        $this->datos = ExperienciasLaborales::select(
            'padron_curriculum_experiencias_laborales.*',
            'cat_giros.descripcion as giro'
        )
        ->join('cat_giros', 'cat_giros.id', '=', 'padron_curriculum_experiencias_laborales.id_giro_el')
        ->where('padron_curriculum_experiencias_laborales.user_id',$this->user_id)
        ->get()
        ->toArray();
    }
    public function storeExperienciaLaboral()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            ExperienciasLaborales::updateOrCreate(
                ['id' => $this->experiencia_laboral_id],
                [
                    'user_id' => $this->user_id,
                    'id_giro_el' => trim($this->id_giro_el ?? '') ?: null,
                    'institucion_el' => trim($this->institucion_el ?? '') ?: null,
                    'puesto_el' => trim($this->puesto_el ?? '') ?: null,
                    'periodo_el' => trim($this->periodo_el ?? '') ?: null,
                ]
            );
            DB::commit();
            $this->limpiarFormulario();
            $this->cargarDatos();
            $this->dispatch('swalExperienciasLaborales', [
                'icon' => 'success',
                'title' => 'Correcto',
                'text' => 'Registro guardado correctamente.'
            ]);
            $this->dispatch('actualizarChecklist');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('swalExperienciasLaborales', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Ocurrió un error al guardar los datos académicos.'
                //'text' => $e->getMessage()
            ]);
        }
    }
    public function editar($id)
    {
        $registro = ExperienciasLaborales::findOrFail($id);
        $this->experiencia_laboral_id = $registro->id;
        $this->id_giro_el = $registro->id_giro_el;
        $this->institucion_el = $registro->institucion_el;
        $this->puesto_el = $registro->puesto_el;
        $this->periodo_el = $registro->periodo_el;
        
        $this->dispatch('actualizarSelectsLaborales');
    }

    public function confirmarEliminar($id)
    {
        $this->experiencia_laboral_id = $id;
        $this->dispatch('confirmaBorrarExperienciaLaboral', id: $id);
        $this->cargarDatos();
    }

    #[On('eliminarRegistroExperienciaLaboral')]
    public function eliminar($id)
    {
        try {
            ExperienciasLaborales::findOrFail($id)->delete();
            $this->cargarDatos();
            //$this->dispatch('refrescarTablaLaborales');
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
        $this->experiencia_laboral_id = null;
        $this->id_giro_el = null;
        $this->institucion_el = null;
        $this->puesto_el = null;
        $this->periodo_el = null;
        $this->dispatch('actualizarSelectsLaborales');
    }
    public function render()
    {
        return view('livewire.aspirantes.curriculum-experiencias-laborales',
            [
                'giros'=>CatalogoGeneral::get_giros(),
            ]
        );
    }
}