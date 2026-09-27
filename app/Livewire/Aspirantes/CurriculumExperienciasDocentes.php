<?php

namespace App\Livewire\Aspirantes;

use Livewire\Component;
use App\Models\Aspirantes\CurriculumExperienciasDocentes as ExperienciasDocentes;
use App\Models\Catalogos\CatalogoGeneral;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CurriculumExperienciasDocentes extends Component
{
    public $experiencia_laboral_id;
    public $user_id;
    public $descripcion_docente;

    public $datos = [];

    protected function rules()
    {
        return [
            'descripcion_docente' => 'required|string|max:2000',
        ];
    }


    protected $messages = [
        'descripcion_docente.required' => 'Capture la descripción docente.',
        'descripcion_docente.string' => 'La descripción debe ser texto.',
        'descripcion_docente.max' => 'La descripción no puede superar los 2000 caracteres.',
    ];
    public function mount($user_id = null)
    {
        $this->user_id = $user_id ?? auth()->id();
        $this->cargarDatos();
    }
    public function cargarDatos()
    {
        $datos = ExperienciasDocentes::where('user_id',$this->user_id)->first();
        if($datos){
            $this->fill($datos->toArray());
        }
    }
    public function storeExperienciaDocente()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            ExperienciasDocentes::updateOrCreate(
                ['user_id' => $this->user_id],
                [
                    'descripcion_docente' => trim($this->descripcion_docente ?? '') ?: null,
                ]
            );
            DB::commit();
            $this->cargarDatos();
            $this->dispatch('swalExperienciasDocentes', [
                'icon' => 'success',
                'title' => 'Correcto',
                'text' => 'Registro guardado correctamente.'
            ]);
            $this->dispatch('actualizarChecklist');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('swalExperienciasDocentes', [
                'icon' => 'error',
                'title' => 'Error',
                //'text' => 'Ocurrió un error al guardar los datos académicos.'
                'text' => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.aspirantes.curriculum-experiencias-docentes');
    }
}