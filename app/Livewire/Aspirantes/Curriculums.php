<?php

namespace App\Livewire\Aspirantes;

use Livewire\Component;
use App\Models\Aspirantes\CurriculumConocimientosElectorales;
use App\Models\Aspirantes\CurriculumDatosAcademicos;
use App\Models\Aspirantes\CurriculumExperienciasDocentes;
use App\Models\Aspirantes\CurriculumExperienciasElectorales;
use App\Models\Aspirantes\CurriculumExperienciasLaborales;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class Curriculums extends Component
{
    protected $listeners = [
        'actualizarChecklist' => 'cargarChecklist'
    ];

    public $tabActivo = 'academicos';

    public $checkAcademicos = false;
    public $checkConocimientos = false;
    public $checkDocentes = false;
    public $checkElectorales = false;
    public $checkLaborales = false;

    public $ConocimientosElectorales = [];
    public $DatosAcademicos = [];
    public $ExperienciasDocentes = [];
    public $ExperienciasElectorales = [];
    public $ExperienciasLaborales = [];

    public $id_user;

    private function validarModulo()
    {
        if (auth()->user()->hasRole('Administrador')) {
            return;
        }

        $estatus = DB::table('padron_aspirantes_modulos')
            ->where('user_id', $this->id_user)
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
        $this->id_user = $user_id ?? auth()->id();
        if (is_null($user_id)) {
            $this->validarModulo();
        }

        // Siempre iniciar en académicos al entrar al módulo
        $this->tabActivo = 'academico';

        // borrar tab anterior de sesión
        session()->forget('curriculum_tab');

        $this->cargarChecklist();
    }


    public function cambiarTab($tab)
    {
        $this->tabActivo = $tab;

        session([
            'curriculum_tab' => $tab
        ]);
    }


    public function cargarChecklist()
    {

        $this->ConocimientosElectorales = CurriculumConocimientosElectorales::where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->get();


        $this->DatosAcademicos = CurriculumDatosAcademicos::where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->get();


        $this->ExperienciasDocentes = CurriculumExperienciasDocentes::where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->get();


        $this->ExperienciasElectorales = CurriculumExperienciasElectorales::where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->get();


        $this->ExperienciasLaborales = CurriculumExperienciasLaborales::where('user_id',$this->id_user)
            ->whereNull('deleted_at')
            ->get();

        $this->checkAcademicos = $this->DatosAcademicos->count() > 0;
        $this->checkConocimientos = $this->ConocimientosElectorales->count() > 0;
        $this->checkDocentes = $this->ExperienciasDocentes->count() > 0;
        $this->checkElectorales = $this->ExperienciasElectorales->count() > 0;
        $this->checkLaborales = $this->ExperienciasLaborales->count() > 0;

    }


    public function render()
    {
        return view('livewire.aspirantes.curriculums');
    }
}