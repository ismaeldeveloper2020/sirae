<div class="container py-4" id="examContainer">

    <style>
.timer-box{
    position: relative;
    width: 140px;
    height: 140px;
}

.timer-svg{
    transform: rotate(-90deg);
    width: 140px;
    height: 140px;
}

.timer-svg circle{
    fill: none;
    stroke-width: 10;
}

.timer-svg .bg{
    stroke: #e9ecef;
}

.timer-svg .progress{
    stroke: #0d6efd;
    stroke-linecap: round;
    stroke-dasharray: 339;
    stroke-dashoffset: 0;
    transition: 1s linear;
}

.timer-text{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    text-align:center;
}

.timer-text #timeText{
    font-size: 22px;
    font-weight: bold;
}

/* opciones */
.option-box{
    display:flex;
    gap:10px;
    padding:10px;
    border:1px solid #dee2e6;
    border-radius:10px;
    cursor:pointer;
    transition:.2s;
    align-items:center;
    background:#fff;
}

.option-box:hover{
    border-color:#0d6efd;
    transform:scale(1.01);
}

.option-box input{
    margin-right:8px;
}

.option-box .letter{
    font-weight:bold;
    color:#0d6efd;
}
</style>

    <!-- TIMER CIRCULAR PRO -->
    <div class="d-flex justify-content-center mb-4">

        <div class="timer-box">

            <svg class="timer-svg" viewBox="0 0 120 120">
                <circle class="bg" cx="60" cy="60" r="54"></circle>
                <circle class="progress" cx="60" cy="60" r="54"></circle>
            </svg>

            <div class="timer-text">
                <div id="timeText">20:00</div>
                <small>Tiempo restante</small>
            </div>

        </div>

    </div>

    <!-- EXAMEN CARD -->
    <div class="card shadow border-0 rounded-4">

        <div class="card-header bg-dark text-white">
            📝 Examen de Aspirante
        </div>

        <div class="card-body p-4">

            @if($finalizado)

                <div class="alert alert-success text-center">
                    ✔ Examen finalizado correctamente
                </div>

            @else

                @foreach($preguntas as $index => $pregunta)

                    <div class="card mb-3 border-0 shadow-sm">

                        <div class="card-body">

                            <span class="badge bg-primary mb-2">
                                Pregunta {{ $index + 1 }}
                            </span>

                            <h6 class="fw-bold mb-3">
                                {{ $pregunta->pregunta }}
                            </h6>

                            <div class="row">

                                @foreach(['A','B','C','D'] as $op)

                                    <div class="col-12 col-md-6 mb-2">

                                        <label class="option-box w-100">

                                            <input type="radio"
                                                   name="p{{ $pregunta->id }}"
                                                   wire:click="setRespuesta({{ $pregunta->id }}, '{{ $op }}')">

                                            <span class="letter">{{ $op }})</span>
                                            <span>{{ $pregunta->{'respuesta'.$op} }}</span>

                                        </label>

                                    </div>

                                @endforeach

                            </div>

                        </div>
                    </div>

                @endforeach

            @endif

            <div class="d-flex justify-content-between mt-4 border-top pt-3">

                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    ← Salir
                </a>

                @if(!$finalizado)
                    <button class="btn btn-success"
                            wire:click="finalizar">
                        ✔ Finalizar examen
                    </button>
                @endif

            </div>

        </div>
    </div>
</div>


@push('scripts')
<script>

const expiresAt = new Date(@json($expires_at)).getTime();

// =====================
// FULLSCREEN OBLIGATORIO
// =====================
function goFullscreen() {
    const elem = document.documentElement;
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    goFullscreen();
});

// =====================
// BLOQUEO CAMBIO DE PESTAÑA
// =====================
document.addEventListener("visibilitychange", function () {
    if (document.hidden) {
        alert("⚠ No puedes salir del examen");
        @this.call('registrarAbandono');
    }
});

// =====================
// TIMER CIRCULAR
// =====================
const circle = document.querySelector(".progress");
const radius = 54;
const circumference = 2 * Math.PI * radius;

circle.style.strokeDasharray = circumference;

function updateTimer() {

    const now = Date.now();
    const diff = expiresAt - now;

    if (diff <= 0) {
        document.getElementById("timeText").innerText = "00:00";
        circle.style.strokeDashoffset = circumference;
        return;
    }

    const minutes = Math.floor(diff / 60000);
    const seconds = Math.floor((diff % 60000) / 1000);

    document.getElementById("timeText").innerText =
        String(minutes).padStart(2,'0') + ":" +
        String(seconds).padStart(2,'0');

    const total = 20 * 60 * 1000;
    const offset = circumference - (diff / total) * circumference;

    circle.style.strokeDashoffset = offset;
}

setInterval(updateTimer, 1000);
updateTimer();

</script>
@endpush