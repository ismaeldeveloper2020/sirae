<?php

namespace App\Livewire\Aspirantes;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Aspirantes\ExamenGenerales;
use App\Models\Aspirantes\ExamenPreguntas;
use App\Models\Aspirantes\ExamenRespuestas;

class Examen extends Component
{
    protected $listeners = [
        'registrarAbandono' => 'registrarAbandono'
    ];

    public $user_id;
    public $examen_id;

    public $preguntas = [];
    public $respuestas = [];

    public $finalizado = false;

    public $expires_at;

    public function mount()
    {
        $this->user_id = Auth::id();

        // 🔥 obtener último examen
        $examen = ExamenGenerales::where('user_id', $this->user_id)
            ->latest()
            ->first();

        // 🔥 crear si no existe
        if (!$examen) {
            $examen = $this->crearExamen();
        }

        $this->examen_id = $examen->id;
        $this->expires_at = $examen->expires_at;

        // 🔴 SI YA ESTÁ TERMINADO
        if ($examen->estado === 'terminado') {
            $this->finalizado = true;
            return;
        }

        // 🔴 SI YA VENCIO TIEMPO (SEGURIDAD)
        if ($examen->expires_at && now()->greaterThan($examen->expires_at)) {
            $this->finalizarPorTiempo($examen->id);
            $this->finalizado = true;
            return;
        }

        // 🟢 cargar preguntas fijas del examen
        $this->preguntas = ExamenPreguntas::whereIn(
            'id',
            DB::table('examen_detalles')
                ->where('examen_id', $this->examen_id)
                ->pluck('pregunta_id')
        )->get();
    }

    public function crearExamen()
    {
        return DB::transaction(function () {

            $user = User::findOrFail($this->user_id);

            $examen = ExamenGenerales::create([
                'user_id'         => $user->id,
                'folio'           => $user->folio,
                'correo'          => $user->email,
                'clave_elector'   => $user->clave_elector,
                'puntaje_total'   => 0,
                'correctas'       => 0,
                'incorrectas'     => 0,
                'estado'          => 'pendiente',
                'started_at'      => now(),
                //'expires_at'      => now()->addHours(2),
                'expires_at'      => now()->addMinutes(20),
                'abandonos'       => 0,
            ]);

            // 🔥 asignar preguntas SOLO UNA VEZ
            $preguntas = ExamenPreguntas::inRandomOrder()
                ->limit(30)
                ->pluck('id');

            $data = [];

            foreach ($preguntas as $id) {
                $data[] = [
                    'examen_id'   => $examen->id,
                    'pregunta_id' => $id,
                ];
            }

            DB::table('examen_detalles')->insert($data);

            return $examen;
        });
    }

    public function setRespuesta($pregunta_id, $valor)
    {
        $this->respuestas[$pregunta_id] = $valor;
    }

    public function finalizar()
    {
        DB::transaction(function () {

            $correctas = 0;

            foreach ($this->preguntas as $pregunta) {

                $respuesta = $this->respuestas[$pregunta->id] ?? null;

                $esCorrecta = ($respuesta === $pregunta->respuesta_correcta);

                if ($esCorrecta) {
                    $correctas++;
                }

                ExamenRespuestas::updateOrCreate(
                    [
                        'examen_id'   => $this->examen_id,
                        'pregunta_id' => $pregunta->id,
                    ],
                    [
                        'respuesta_usuario'  => $respuesta,
                        'respuesta_correcta' => $pregunta->respuesta_correcta,
                        'es_correcta'        => $esCorrecta,
                    ]
                );
            }

            ExamenGenerales::where('id', $this->examen_id)->update([
                'correctas'     => $correctas,
                'incorrectas'   => count($this->preguntas) - $correctas,
                'puntaje_total' => $correctas * 10,
                'estado'        => 'terminado',
            ]);

            $this->finalizado = true;

            $this->dispatch('examen-terminado');
        });
    }

    public function finalizarPorTiempo($examen_id)
    {
        ExamenGenerales::where('id', $examen_id)
            ->where('estado', 'pendiente')
            ->update([
                'estado' => 'terminado',
            ]);
    }

    public function registrarAbandono()
    {
        ExamenGenerales::where('id', $this->examen_id)
            ->increment('abandonos');
    }

    public function render()
    {
        return view('livewire.aspirantes.examen');
    }
}