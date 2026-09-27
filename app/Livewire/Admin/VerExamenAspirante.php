<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Aspirantes\ExamenGenerales;
use App\Models\Aspirantes\ExamenPreguntas;
use App\Models\Aspirantes\ExamenRespuestas;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Models\User;

#[Layout('layouts.admin')]
class VerExamenAspirante extends Component
{
    public $user_id;
    public $examen;
    public $preguntas = [];
    public $respuestas = [];

    #[On('aspirante-examen-actualizado')]
    public function mount($user)
    {
        $this->user_id = $user;

        $this->examen = ExamenGenerales::where('user_id', $user)
            ->latest()
            ->first();

        // SI NO HAY EXAMEN, SOLO SALIMOS
        if (!$this->examen) {
            $this->preguntas = collect();
            $this->respuestas = collect();
            return;
        }

        $this->preguntas = ExamenPreguntas::whereIn(
            'id',
            DB::table('examen_detalles')
                ->where('examen_id', $this->examen->id)
                ->pluck('pregunta_id')
        )->get();

        $this->respuestas = ExamenRespuestas::where('examen_id', $this->examen->id)
            ->get()
            ->keyBy('pregunta_id');
    }

    public function render()
    {
        return view('livewire.admin.ver-examen-aspirante');
    }
}