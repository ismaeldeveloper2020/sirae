<?php

namespace App\Livewire\Aspirantes;

use Livewire\Component;
use App\Models\Aspirantes\CurriculumConocimientosElectorales as ConocimientosElectorales;
use App\Models\Catalogos\CatalogoGeneral;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class CurriculumConocimientosElectorales extends Component
{
    public $conocimiento_electoral_id;
    public $user_id;
    public $id_tipo_ce;
    public $otro_ce;
    public $id_participacion_ce;
    public $institucion_ce;
    public $periodo_ce;
    public $datos = [];
    public $mostrar_otro_conocimiento=false;

    protected function rules()
    {
        return [
            'id_tipo_ce' => [
                'required',
                'not_in:0',

                Rule::unique(
                    'padron_curriculum_conocimientos_electorales',
                    'id_tipo_ce'
                )
                ->where(fn ($query) => $query
                    ->where('user_id', $this->user_id)
                    ->where('institucion_ce', $this->institucion_ce)
                    ->where('periodo_ce', $this->periodo_ce)
                    ->whereNull('deleted_at')
                )
                ->ignore($this->conocimiento_electoral_id),
            ],
            'otro_ce' => ['nullable','required_if:id_tipo_ce,9','string','max:255'],
            'institucion_ce' => 'required|string|max:255',
            'id_participacion_ce' => 'required|not_in:0',

            'periodo_ce' => [
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
        'id_tipo_ce.required' => 'Debe seleccionar un tipo de conocimiento.',
        'id_tipo_ce.not_in' => 'Debe seleccionar un tipo de conocimiento válido.',
        'id_tipo_ce.unique' => 'Ya existe un registro con el mismo tipo de conocimiento, institución y período.',


        'institucion_ce.required' => 'Debe capturar una institución.',
        'institucion_ce.string' => 'La institución debe ser texto.',
        'institucion_ce.max' => 'La institución no puede exceder 255 caracteres.',

        'otro_ce.required_if' => 'Debe especificar el otro conocimiento.',
        'otro_ce.string' => 'El otro conocimiento debe ser texto.',
        'otro_ce.max' => 'El otro conocimiento no puede exceder 255 caracteres.',

        'id_participacion_ce.required' => 'Debe seleccionar una participación.',
        'id_participacion_ce.not_in' => 'Debe seleccionar una participación válida.',

        'periodo_ce.required' => 'Debe capturar el período.',
        'periodo_ce.string' => 'El período debe ser texto.',
        'periodo_ce.regex' => 'El período debe tener el formato YYYY-YYYY. Ejemplo: 2018-2020.',
    ];

    protected $validationAttributes = [
        'id_tipo_ce' => 'tipo de conocimiento',
        'otro_ce' => 'otro conocimiento',
        'id_participacion_ce' => 'participación',
        'periodo_ce' => 'período',
    ];

    public function mount($user_id = null)
    {
        $this->user_id = $user_id ?? auth()->id();
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        
        $this->datos = ConocimientosElectorales::select(
            'padron_curriculum_conocimientos_electorales.*',
            'cat_conocimientos_electorales.descripcion as conocimiento',
            'cat_tipos_asistencias.descripcion as participacion'
        )
        ->leftJoin('cat_conocimientos_electorales', 'cat_conocimientos_electorales.id', '=', 'padron_curriculum_conocimientos_electorales.id_tipo_ce')
        ->leftJoin('cat_tipos_asistencias','cat_tipos_asistencias.id', '=', 'padron_curriculum_conocimientos_electorales.id_participacion_ce')
        ->where('padron_curriculum_conocimientos_electorales.user_id',$this->user_id)
        ->get()
        ->toArray();
    }
    /*================================================
    CAMBIO CARGOS
    ================================================
    */
    public function updatedIdTipoCe($value)
    {
        $this->mostrar_otro_conocimiento = false;
        if($value == 9){
            $this->mostrar_otro_conocimiento = true;
        }
        else{
            $this->otro_ce = null;
        }
          
    }

    public function store_conocimiento_electoral()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            ConocimientosElectorales::updateOrCreate(
                [
                    'id'=>$this->conocimiento_electoral_id
                ],
                [
                    'user_id'=>$this->user_id,
                    'id_tipo_ce'=>trim($this->id_tipo_ce ?? '') ?: null,
                    'otro_ce'=>trim($this->otro_ce ?? '') ?: null,
                    'id_participacion_ce'=>$this->id_participacion_ce,
                    'institucion_ce'=>trim($this->institucion_ce ?? '') ?: null,
                    'periodo_ce'=>trim($this->periodo_ce ?? '') ?: null
                ]
            );
            DB::commit();
            $this->cargarDatos();
            //$this->dispatch('recargarExperiencias');
            $this->dispatch('swalConocimientosElectorales',[
                'icon'=>'success',
                'title'=>'Correcto',
                'text'=>'Registro guardado correctamente.'
            ]);
            $this->limpiarFormulario();
            $this->mostrar_otro_conocimiento=false;
            $this->dispatch('actualizarChecklist');
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            $this->dispatch('swalConocimientosElectorales',[
                'icon'=>'error',
                'title'=>'Error',
                'text'=>$e->getMessage()
            ]);
        }
    } 

    function editarExperienciaElectoral($id)
    {

        $registro = ConocimientosElectorales::findOrFail($id);
        $this->conocimiento_electoral_id = $registro->id;
        $this->id_tipo_ce = $registro->id_tipo_ce;
        $this->otro_ce = $registro->otro_ce;
        $this->id_participacion_ce = $registro->id_participacion_ce;
        $this->institucion_ce = $registro->institucion_ce;
        $this->periodo_ce = $registro->periodo_ce;

        $this->mostrar_otro_conocimiento = ($registro->id_tipo_ce == 9);

        $this->dispatch('actualizarSelectsConocimientos');
    }

    public function confirmarDeleteConocimientoElectoral($id)
    {
        $this->conocimiento_electoral_id = $id;
        $this->dispatch('confirmaBorrarConocimientoElectoral', id: $id);
    }
    #[On('eliminarRegistroConocimientosElectoral')]
    public function eliminar($id)
    {
        try {
            ConocimientosElectorales::findOrFail($id)->delete();
            $this->cargarDatos();
            $this->dispatch('swalConocimientosElectorales',[
                'icon'=>'success',
                'title'=>'Correcto',
                'text'=>'Registro guardado correctamente.'
            ]);
            $this->dispatch('actualizarChecklist');
        } catch (\Exception $e) {
            $this->dispatch('swalConocimientosElectorales',[
                'icon'=>'error',
                'title'=>'Error',
                'text'=>$e->getMessage()
            ]);
        }
    }
    public function limpiarFormulario()
    {
        $this->conocimiento_electoral_id = null;
        $this->id_tipo_ce = null;
        $this->otro_ce = null;
        $this->id_participacion_ce = null;
        $this->institucion_ce = null;
        $this->periodo_ce = null;

        $this->dispatch('actualizarSelectsConocimientos');
    }
    public function render()
    {
        return view('livewire.aspirantes.curriculum-conocimientos-electorales',
            [
                'conocimientos_electorales'=>CatalogoGeneral::get_conocimientos_electorales(),
                'tipo_asistencias'=>CatalogoGeneral::get_tipo_asistencias(),
            ]
        );
    }
}