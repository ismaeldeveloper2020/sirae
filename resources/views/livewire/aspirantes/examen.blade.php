<div class="container py-4">

<style>
    .timer-box{
        position: relative;
        width: 220px;
        height: 220px;
        margin: 0 auto 20px;
    }

    .timer-svg{
        transform: rotate(-90deg);
        width: 220px;
        height: 220px;
    }

    .timer-svg circle{
        fill: none;
        stroke-width: 12;
    }

    .timer-svg .bg{
        stroke: #e9ecef;
    }

    .timer-svg .progress{
        stroke: #E22275;
        stroke-linecap: round;
        stroke-dasharray: 565.48; /* recalculado para r=90 */
        stroke-dashoffset: 0;
        transition: stroke 0.4s ease, stroke-dashoffset 1s linear;
    }

    .timer-text{
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%,-50%);
        text-align:center;
    }

    .timer-text #timeText{
        font-size: 34px;
        font-weight: bold;
        color:#E22275;
    }

    .option-box {
        display: flex;
        gap: 10px;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 10px;
        cursor: pointer;
        transition: .2s ease;
        background: #fff;
        align-items: center;
    }

    .option-box:hover {
        border-color: #E22275;
    }

    .option-box.selected {
        border-color: #E22275;
        background: #FDE7F0;
    }

</style>

<div class="row align-items-stretch justify-content-center mb-4">

    {{-- RECOMENDACIONES IZQUIERDA (8 columnas) --}}
    <div class="col-md-8 d-flex">
        <div class="card shadow-sm border-0 w-100 h-100">
            <div class="card-body">

                {{-- TÍTULO --}}
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-info-circle me-2" style="color:#E22275;"></i>
                    Recomendaciones
                </h5>

                <ul class="mb-0 small list-unstyled w-100">

                    <li class="mb-3 fs-6 d-flex align-items-start">
                        <i class="fas fa-window-maximize me-2 mt-1"
                        style="color:#E22275;"></i>
                        <span>No cierres la pestaña del navegador durante el examen.</span>
                    </li>

                    <li class="mb-3 fs-6 d-flex align-items-start">
                        <i class="fas fa-sign-in-alt me-2 mt-1"
                        style="color:#E22275;"></i>
                        <span>Si se cierra, vuelve a entrar con tu usuario para continuar el examen.</span>
                    </li>

                    <li class="mb-3 fs-6 d-flex align-items-start">
                        <i class="fas fa-clock me-2 mt-1"
                        style="color:#E22275;"></i>
                        <span>El tiempo corre desde el inicio y no se detiene.</span>
                    </li>

                    <li class="mb-3 fs-6 d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle me-2 mt-1"
                        style="color:#E22275;"></i>
                        <span>Las preguntas no respondidas se registran como incorrectas.</span>
                    </li>

                    <li class="mb-3 fs-6 d-flex align-items-start">
                        <i class="fas fa-check-circle me-2 mt-1"
                        style="color:#E22275;"></i>
                        <span>Al finalizar podrás regresar al panel o cerrar sesión.</span>
                    </li>

                    <li class="mb-0 fs-6 d-flex align-items-start">
                        <i class="fas fa-wifi me-2 mt-1"
                        style="color:#E22275;"></i>
                        <span>Mantén una conexión estable a Internet durante todo el examen.</span>
                    </li>

                </ul>

            </div>
        </div>
    </div>


    {{-- TIMER DERECHA (4 columnas centrado) --}}
    <div class="col-md-4 d-flex">
        <div class="card shadow-sm border-0 w-100 h-100">

            <div class="card-body d-flex align-items-center justify-content-center">

                <div class="timer-box" wire:ignore>
                    <svg class="timer-svg" viewBox="0 0 200 200">
                        <circle class="bg" cx="100" cy="100" r="90"></circle>
                        <circle id="progressCircle" class="progress" cx="100" cy="100" r="90"></circle>
                    </svg>

                    <div class="timer-text">
                        <div id="timeText">60:00</div>
                        <small>Tiempo restante</small>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

@php
    $total = count($preguntas);

    $actual = $finalizado
        ? $total
        : ($pregunta_actual + 1);

    $porcentaje = $total > 0
        ? ($actual / $total) * 100
        : 0;
@endphp

<div class="mb-3">
    <div class="d-flex justify-content-between small mb-1">
        <span>Progreso</span>
        <span>{{ $actual }} / {{ $total }}</span>
    </div>

    <div class="progress" style="height: 8px;">
        <div class="progress-bar"
            role="progressbar"
            style="width: {{ $porcentaje }}%; background-color:#E22275;">
        </div>
    </div>
</div>

@if($finalizado)
    <div class="alert alert-success text-center shadow-sm rounded-3">
        <h4 class="mb-1">✔ Examen finalizado</h4>
        <small>Ya puedes cerrar esta sesión en el boton superior salir o regresar al panel</small>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{ route('dashboard') }}"
        class="btn btn-outline-secondary btn-md px-3 rounded-2">
            <i class="fa fa-arrow-left me-1"></i>
            Volver al panel
        </a>
    </div>
@else

    @php
        $pregunta = $preguntas[$pregunta_actual] ?? null;
        $respuestaActual = $respuestas[$pregunta->id] ?? null;
    @endphp

    @if($pregunta)

        <div wire:key="pregunta-{{ $pregunta->id }}" class="card p-4 mb-3">

            <h5 class="mb-5">{{ $pregunta->pregunta }}</h5>

            @foreach(['A','B','C','D'] as $op)

                <label class="option-box w-100 mb-2 {{ $respuestaActual === $op ? 'selected' : '' }}">

                    <input type="radio"
                           name="respuesta_{{ $pregunta->id }}"
                           wire:model.defer="respuestas.{{ $pregunta->id }}"
                           value="{{ $op }}">

                    <span>
                        <strong>{{ $op }})</strong>
                        {{ $pregunta->{'respuesta'.$op} }}
                    </span>

                </label>

            @endforeach

        </div>

    @endif

        <div class="d-flex justify-content-between align-items-center mt-3">

            {{-- ANTERIOR --}}
            <button class="btn btn-outline-secondary px-3 d-flex align-items-center gap-2"
                    wire:click="anterior"
                    @if($pregunta_actual == 0) disabled @endif>

                <i class="fa-solid fa-chevron-left"></i>
                <span>Anterior</span>
            </button>

            {{-- GUARDAR / SIGUIENTE --}}
            <button class="btn btn-primary px-3 d-flex align-items-center gap-2"
                    wire:click="guardarYSiguiente">

                @if($pregunta_actual < count($preguntas)-1)

                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Guardar y siguiente</span>

                @else

                    <i class="fa-solid fa-circle-check"></i>
                    <span>Finalizar examen</span>

                @endif

            </button>

        </div>

@endif

</div>

@push('scripts')
<script>

let examStarted = false;
let interval = null;

function startTimer() {

    if (examStarted) return;
    examStarted = true;

    // Fecha/hora real guardada en BD
    const startedAt = new Date(@json($started_at)).getTime();
    const expiresAt = new Date(@json($expires_at)).getTime();

    const circle = document.getElementById("progressCircle");
    const timeText = document.getElementById("timeText");

    const radius = 90;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = circumference;

    // Duración real del examen
    const total = expiresAt - startedAt;

    interval = setInterval(() => {

        const now = Date.now();
        const diff = expiresAt - now;

        if (diff <= 0) {

            clearInterval(interval);

            timeText.innerText = "00:00";

            // 🔥 CÍRCULO COMPLETO VACÍO
            circle.style.strokeDashoffset = circumference;

            // 🔥 GRIS TOTAL (SIN RESIDUO ROSA)
            circle.style.stroke = "#e9ecef";

            // opcional: detener transición
            circle.style.transition = "none";

            @this.call('finalizar');
            return;
        }

        const m = Math.floor(diff / 60000);
        const s = Math.floor((diff % 60000) / 1000);

        timeText.innerText =
            String(m).padStart(2,'0') + ":" +
            String(s).padStart(2,'0');

        const progress = diff / total;

        circle.style.strokeDashoffset = circumference * (1 - progress);

        // 🔥 COLOR SOLO MIENTRAS HAY TIEMPO
        if (progress > 0.5) {
            circle.style.stroke = "#E22275";
            timeText.style.color = "#E22275";
        } else if (progress > 0.25) {
            circle.style.stroke = "#E22275";
            timeText.style.color = "#E22275";
        } else {
            circle.style.stroke = "#E22275";
            timeText.style.color = "#E22275";
        }

        if (diff <= 2 * 60 * 1000 && !window.lowTimeAlertShown) {
            window.lowTimeAlertShown = true;

            window.dispatchEvent(new CustomEvent('alertaExamen', {
                detail: {
                    type: 'warning',
                    message: 'Te quedan menos de 2 minutos para terminar el examen'
                }
            }));
        }

    }, 1000);
}

document.addEventListener("DOMContentLoaded", startTimer);



window.addEventListener('alertaExamen', e => {

    Swal.fire({
        icon: e.detail.type ?? 'warning',
        title: 'Atención',
        text: e.detail.message,

        confirmButtonColor: '#0d6efd',
        confirmButtonText: 'Aceptar',

        // 🔒 BLOQUEO TOTAL
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,

        backdrop: true
    });

});

</script>
@endpush