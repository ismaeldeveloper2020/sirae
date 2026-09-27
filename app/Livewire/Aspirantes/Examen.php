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
    public $pregunta_actual = 0;

    public $respuestas = [];
    public $finalizado = false;

    public $expires_at;
    public $started_at;

    public function mount()
    {
        $this->user_id = Auth::id();

        $examen = ExamenGenerales::where('user_id', $this->user_id)
            ->latest()
            ->first();

        if (!$examen) {
            $examen = $this->crearExamen();
        }

        $this->examen_id = $examen->id;
        $this->expires_at = $examen->expires_at;
        $this->started_at = $examen->started_at;
        // 🔥 AQUÍ VA
        $this->pregunta_actual = $examen->pregunta_actual ?? 0;

        if ($examen->estado === 'terminado') {
            $this->finalizado = true;
            return;
        }

        $this->preguntas = ExamenPreguntas::select('examen_preguntas.*')
            ->join(
                'examen_detalles',
                'examen_detalles.pregunta_id',
                '=',
                'examen_preguntas.id'
            )
            ->where('examen_detalles.examen_id', $this->examen_id)
            ->orderBy('examen_detalles.id')
            ->get();

        $this->respuestas = ExamenRespuestas::where('examen_id', $this->examen_id)
            ->pluck('respuesta_usuario', 'pregunta_id')
            ->toArray();
    }

    public function crearExamen()
    {
        return DB::transaction(function () {

            // 🔥 traer datos del padrón (NO users)
            $padron = DB::table('padron_generales')
                ->where('user_id', $this->user_id)
                ->first();

            if (!$padron) {
                abort(404, 'Usuario no encontrado en padrón');
            }

            $examen = ExamenGenerales::create([
                'user_id' => $this->user_id,
                'folio' => $padron->folio,
                'correo' => $padron->correo ?? null,
                'clave_elector' => $padron->clave_elector,

                'puntaje_total' => 0,
                'correctas' => 0,
                'incorrectas' => 0,
                'estado' => 'pendiente',
                'started_at' => now(),
                'expires_at' => now()->addMinutes(60),  //modifucar e timpeo del examen en minutios seria 120 dos horas
                'abandonos' => 0,
            ]);

            $preguntas = ExamenPreguntas::inRandomOrder()
                ->limit(30)
                ->pluck('id');

            $detalles = $preguntas->map(function ($id) use ($examen) {
                return [
                    'examen_id' => $examen->id,
                    'pregunta_id' => $id,
                ];
            })->toArray();

            DB::table('examen_detalles')->insert($detalles);

            return $examen;
        });
    }

    public function seleccionarRespuesta($pregunta_id, $valor)
    {
        $this->respuestas[$pregunta_id] = $valor;
    }

    public function anterior()
    {
        if ($this->pregunta_actual > 0) {
            $this->pregunta_actual--;
        }
    }

    public function guardarYSiguiente()
    {
        $pregunta = $this->preguntas[$this->pregunta_actual];

        $respuesta = $this->respuestas[$pregunta->id] ?? null;

        if (!$respuesta) {
            $this->dispatch('alertaExamen',
                type: 'warning',
                message: 'Debes seleccionar una respuesta antes de continuar.'
            );
            return;
        }

        ExamenRespuestas::updateOrCreate(
            [
                'examen_id' => $this->examen_id,
                'pregunta_id' => $pregunta->id,
            ],
            [
                'respuesta_usuario' => $respuesta,
                'respuesta_correcta' => $pregunta->respuesta_correcta,
                'es_correcta' => $respuesta === $pregunta->respuesta_correcta,
            ]
        );

        // 🔥 GUARDAR PROGRESO
        ExamenGenerales::where('id', $this->examen_id)
            ->update([
                'pregunta_actual' => $this->pregunta_actual
            ]);

        if ($this->pregunta_actual < count($this->preguntas) - 1) {
            $this->pregunta_actual++;
        } else {
            $this->finalizar();
        }
    }

    public function finalizar()
    {
        // 🔥 1. Asegurar que todas las respuestas estén guardadas en BD
        foreach ($this->preguntas as $p) {

            $respuesta = $this->respuestas[$p->id] ?? null;

            if ($respuesta) {
                ExamenRespuestas::updateOrCreate(
                    [
                        'examen_id' => $this->examen_id,
                        'pregunta_id' => $p->id,
                    ],
                    [
                        'respuesta_usuario' => $respuesta,
                        'respuesta_correcta' => $p->respuesta_correcta,
                        'es_correcta' => $respuesta === $p->respuesta_correcta,
                    ]
                );
            }
        }

        // 🔥 2. Calcular resultados desde BD (FUENTE REAL)
        $correctas = ExamenRespuestas::where('examen_id', $this->examen_id)
            ->whereColumn('respuesta_usuario', 'respuesta_correcta')
            ->count();

        //$total = $this->preguntas->count();
        $total = count($this->preguntas);

        $incorrectas = $total - $correctas;

        $puntaje = ($total > 0)
            ? ($correctas / $total) * 100
            : 0;

        // 🔥 3. Guardar resultados finales
        ExamenGenerales::where('id', $this->examen_id)->update([
            'correctas' => $correctas,
            'incorrectas' => $incorrectas,
            'puntaje_total' => round($puntaje, 2),
            'estado' => 'terminado',
        ]);

        // 🔥 4. Marcar UI como finalizado
        $this->finalizado = true;

        // 🔥 5. Notificación UI
        $this->dispatch('alertaExamen',
            type: 'success',
            message: 'Examen finalizado correctamente.'
        );
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