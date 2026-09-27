<div class="container py-4">

    {{-- SI NO HAY EXAMEN --}}
    @if(!$examen)
        <div class="alert alert-warning text-center">
            <h5>⚠️ No hay examen registrado para este aspirante</h5>
            <p>Este usuario aún no ha presentado ningún examen.</p>
        </div>
    @else

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">📄 Revisión de examen</h3>
    </div>

    {{-- RESUMEN --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card text-center p-3 shadow-sm mb-3">
                <small class="text-muted">Examen</small>
                <h6 class="mb-0">
                    <span class="badge bg-dark">
                        {{ $examen->estado }}
                    </span>
                </h6>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-3 shadow-sm mb-3">
                <small class="text-muted">Folio</small>
                <h4 class="mb-0">{{ $examen->folio }}</h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-3 shadow-sm mb-3">
                <small class="text-muted">Puntaje</small>
                <h4 class="text-primary mb-0">
                    {{ $examen->puntaje_total }} / 100
                </h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-3 shadow-sm mb-3">
                <small class="text-muted">Correctas</small>
                <h4 class="text-success mb-0">
                    {{ $examen->correctas }}
                </h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-3 shadow-sm mb-3">
                <small class="text-muted">Incorrectas</small>
                <h4 class="text-danger mb-0">
                    {{ $examen->incorrectas }}
                </h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-3 shadow-sm mb-3">
                <small class="text-muted">Resultado</small>

                @if($examen->puntaje_total >= 60)
                    <h4 class="text-success mb-0">Aprobado</h4>
                @else
                    <h4 class="text-danger mb-0">Reprobado</h4>
                @endif
            </div>
        </div>

    </div>

    {{-- PREGUNTAS --}}
    @if(!empty($preguntas) && $preguntas->count())

        @foreach($preguntas as $i => $p)

            @php
                $r = $respuestas[$p->id]->respuesta_usuario ?? null;
                $correcta = $p->respuesta_correcta;
                $ok = $r === $correcta;
            @endphp

            <div class="card mb-3 shadow-sm border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-2">

                        <h6 class="mb-0">
                            <span class="badge bg-secondary me-2">
                                {{ $i + 1 }}
                            </span>
                            {{ $p->pregunta }}
                        </h6>

                        @if($ok)
                            <span class="badge bg-success">✔ Correcta</span>
                        @else
                            <span class="badge bg-danger">✖ Incorrecta</span>
                        @endif

                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-md-6">
                            <small class="text-muted">Respuesta del aspirante</small>
                            <div class="fw-bold {{ $ok ? 'text-success' : 'text-danger' }}">
                                @if($r)
                                    <small class="text-muted">({{ $r }})</small>
                                    {{ $p->{'respuesta'.$r} }}
                                @else
                                    Sin responder
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Respuesta correcta</small>
                            <div class="fw-bold text-success">
                                <small class="text-muted">({{ $correcta }})</small>
                                {{ $p->{'respuesta'.$correcta} }}
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        @endforeach

    @else
        <div class="alert alert-info text-center">
            No hay preguntas disponibles.
        </div>
    @endif

    @endif

</div>