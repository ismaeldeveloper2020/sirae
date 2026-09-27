@extends('layouts.aspirante')
@section('title','Dashboard aspirante')
@section('content')
@livewireStyles
<style>
    .module {
        height: 100%;
        display: flex;
        flex-direction: column;
        padding: 25px;
    }
    .module p {
        min-height: 50px;
    }
    .module .mt-auto {
        margin-top: auto;
    }
</style>
@php
// =====================================
// ESTATUS NUMERICO
// =====================================
//
// 0 = Registro en proceso
// 1 = Revisión y validación
// 2 = Requerimientos
// 3 = Registro completado
//
$estatus_registro = 0;
// =====================================
// GENERALES
// =====================================
$generales = \App\Models\Aspirantes\Generales::where('user_id',auth()->id())->whereNull('deleted_at')->exists();
// =====================================
// CURRICULUM
// =====================================
$existe_ce = \App\Models\Aspirantes\CurriculumConocimientosElectorales::whereNull('deleted_at')->where('user_id',auth()->id())->exists();
$existe_da = \App\Models\Aspirantes\CurriculumDatosAcademicos::whereNull('deleted_at')->where('user_id',auth()->id())->exists();
$existe_ed = \App\Models\Aspirantes\CurriculumExperienciasDocentes::whereNull('deleted_at')->where('user_id',auth()->id())->exists();
$existe_ee = \App\Models\Aspirantes\CurriculumExperienciasElectorales::whereNull('deleted_at')->where('user_id',auth()->id())->exists();
$existe_el = \App\Models\Aspirantes\CurriculumExperienciasLaborales::whereNull('deleted_at')->where('user_id',auth()->id())->exists();
$value_da = \App\Models\Aspirantes\CurriculumDatosAcademicos::whereNull('deleted_at')->where('user_id',auth()->id())->value('id_nivel_estudios');
// =====================================
// ARCHIVOS
// =====================================
$archivosSubidos = \App\Models\Aspirantes\ArchivosSubidos::where('user_id', auth()->id())->whereNull('deleted_at')->exists();

$modulos_completos =  DB::table('padron_aspirantes_modulos')->where('user_id', auth()->id())->whereNull('deleted_at')->exists();
//1 requeridos
//2 subsanado
//3 validado
$requierido = \App\Models\Aspirantes\Archivos::where('user_id',auth()->id())->whereNull('deleted_at')->where('validado',1)->whereNotNull('observacion')->exists();
$subsanado = \App\Models\Aspirantes\Archivos::where('user_id',auth()->id())->whereNull('deleted_at')->where('validado',2)->whereNotNull('observacion')->exists();
$tienePendientes = \App\Models\Aspirantes\Archivos::where('user_id', auth()->id())->whereNull('deleted_at')->where('validado','!=',3)->exists();

$estatus_modulo = DB::table('padron_aspirantes_modulos')->where('user_id', auth()->id())->value('modulo_registro');

$modulos_completos = in_array($estatus_modulo, [1,2,3,4,5]);

/*
1. Registro completado en proceso de revisión y validación de documentos.
2. Registro completado con requerimientos pendientes de atender.
3. Registro completado con documentos subsanados en espera de revisión final.
4. Registro completado con documentos subsanados y con nuevos requerimientos pendientes.
5. Registro completado; documentación revisada y validada correctamente.
*/
$todoValidado = false;
if ($tienePendientes || $requierido || $subsanado) {
    $todoValidado = false;
} else {
    $todoValidado = true;
}
// =====================================
// AVANCE
// =====================================
$obligatorio_da = false;
$obligatorio_ce = false;
$obligatorio_ee = false;
$obligatorio_ed = false;
$obligatorio_el = false;
$curriculums = false;
$documentos_requeridos = [1,2,3,4,5,6,7,8];
if ($existe_da) {
    // Datos académicos
    if ($value_da == 1) {
        // Sin estudios
        $curriculums = true;
        $obligatorio_da = false;
        $documentos_requeridos = [1,3,4,5,6,7,8];
    } elseif ($value_da > 1) {
        // Con estudios
        $curriculums = true;
        $obligatorio_da = true;
    }
    // Si tiene información, requiere documento
    $obligatorio_ce = $existe_ce;
    $obligatorio_ed = $existe_ed;
    $obligatorio_ee = $existe_ee;
    $obligatorio_el = $existe_el;
    if ($obligatorio_ce) {
        $documentos_requeridos[] = 9;
    }
    if ($obligatorio_ee) {
        $documentos_requeridos[] = 10;
    }
    if ($obligatorio_ed) {
        $documentos_requeridos[] = 11;
    }
    if ($obligatorio_el) {
        $documentos_requeridos[] = 12;
    }
}
$subidos = \DB::table('padron_documentos')->whereNull('deleted_at')->where('user_id', auth()->id())->whereIn('documento_id', $documentos_requeridos)
->pluck('documento_id')->toArray();
$documentosCompletos = empty(array_diff($documentos_requeridos, $subidos));
if($documentosCompletos)
{
    $porvalidar = \App\Models\Aspirantes\Archivos::where('user_id', auth()->id())
        ->whereNull('deleted_at')
        ->where('validado','!=',3)
        ->exists();
    if($porvalidar)
    {
        $todoValidado = false;
    }
    else 
    {
        $todoValidado = true;
    }
}
$avance = 0;
$estatus_registro = 0;

if($generales && $curriculums && $archivosSubidos){
    $avance = 100;
    //validass egun eszto   estatus_modulo  si no no enstra en cada opcion
    if($modulos_completos)
    {
        if($todoValidado){
            // Todos en validado = 3
            $estatus_registro = 5;
        }elseif($requierido && $subsanado){
            // Hay documentos subsanados pero también nuevos requerimientos
            $estatus_registro = 4;
        }elseif($requierido){
            // Tiene requerimientos
            $estatus_registro = 2;
        }elseif($subsanado){
            // Todos los requerimientos ya fueron atendidos
            $estatus_registro = 3;
        }else{
            // Registro enviado esperando revisión
            $estatus_registro = 1;
        }
    }
}elseif($generales && $curriculums){

    $avance = 70;

}elseif($generales){

    $avance = 35;

}
$texto_estatus = match($estatus_registro)
{
    0 => 'Registro en proceso',
    1 => 'Registro completado en proceso de revisión y validación de documentos.',
    2 => 'Registro completado con requerimientos pendientes de atender.',
    3 => 'Registro completado con documentos subsanados en espera de revisión final.',
    4 => 'Registro completado con documentos subsanados y con nuevos requerimientos pendientes.',
    5 => 'Registro completado; documentación revisada y validada correctamente.',
    default => 'Sin estatus'
};
$edicionBloqueada = in_array($estatus_registro, [1,2,3,4,5]);


use Carbon\Carbon;

$examen = App\Models\Aspirantes\ExamenGenerales::where('user_id', auth()->id())
    ->whereNull('deleted_at')
    ->where('estado', 'terminado')
    ->exists();

$configuracion_examen = DB::table('cat_configuraciones')
    ->whereNull('deleted_at')
    ->where('activo', 1)
    ->where('proceso_id', 2) //examen de aspirante
    ->first();

$examen_visible = false;

if ($configuracion_examen && !$examen) {

    $ahora = now();

    $inicio = Carbon::parse(
        $configuracion_examen->fecha_inicio . ' ' . $configuracion_examen->hora_inicio
    );

    $fin = Carbon::parse(
        $configuracion_examen->fecha_termino . ' ' . $configuracion_examen->hora_termino
    );

    $examen_visible = $ahora->gte($inicio) && $ahora->lt($fin);
}

@endphp
<!-- PROGRESO -->
<div class="user-card mt-0">
    <h5 class="fw-bold">
        Progreso del registro
    </h5>
    <div class="progress mt-3">
        <div class="progress-bar bg-success" style="width:{{$avance}}%">
            {{$avance}}% completado
        </div>
    </div>
    <div class="d-flex justify-content-between mt-3">
        <span class="{{$generales?'text-success fw-bold':'text-muted'}}">
            @if($generales)
            <i class="fa-solid fa-circle-check"></i>
            @endif
            Generales
        </span>
        <span class="{{$curriculums?'text-success fw-bold':'text-muted'}}">
            @if($curriculums)
            <i class="fa-solid fa-circle-check"></i>
            @endif
            Currículum
        </span>
        <span class="{{$archivosSubidos?'text-success fw-bold':'text-muted'}}">
            @if($archivosSubidos)
            <i class="fa-solid fa-circle-check"></i>
            @endif
            Documentos
        </span>
    </div>
</div>
<h3 class="fw-bold mt-5 mb-4 d-flex align-items-center gap-3">
    Mis módulos
    @if($estatus_registro == 5)
    <span class="badge bg-success fs-6">
        <i class="fa-solid fa-circle-check me-1"></i>
        {{$texto_estatus}}
    </span>
    @elseif($estatus_registro == 4 || $estatus_registro == 2)
    <span class="badge bg-warning fs-6">
        <i class="fa-solid fa-triangle-exclamation me-1"></i>
        {{$texto_estatus}}
    </span>
    @elseif($estatus_registro == 3 || $estatus_registro == 1)
    <span class="badge bg-info text-dark fs-6">
        <i class="fa-solid fa-clock me-1"></i>
        {{$texto_estatus}}
    </span>
    @else
    <span class="badge bg-secondary fs-6">
        <i class="fa-solid fa-hourglass-half me-1"></i>
        {{$texto_estatus}}
    </span>
    @endif
</h3>
<small class="d-block text-muted fs-5 fw-normal mt-2" style="text-align: justify;">
    En esta sección podrá consultar y completar los
    módulos correspondientes a su registro. La
    documentación cargada será revisada por el área
    responsable de la validación. En caso de detectar
    algún error o inconsistencia, se mostrará una
    observación indicando la corrección requerida
    para continuar con el proceso.
</small>
<hr>
@if(session('error_modulo'))
    <div class="alert alert-danger">
        <i class="fa-solid fa-circle-exclamation"></i>
        {{ session('error_modulo') }}
    </div>
@endif
@if($estatus_registro == 2)
<div class="alert alert-danger d-flex align-items-center mt-3">
    <i class="fa-solid fa-circle-info fa-lg me-3"></i>
    <div>
        <strong>
            Documentos con observaciones pendientes
        </strong>
        <br>
        Algunos documentos requieren corrección.
        Revise la observación indicada en cada archivo y utilice la opción
        <strong>
            "Sustituir"
        </strong>
        para cargar el documento corregido.
    </div>
</div>
@endif
<div class="row g-4 align-items-stretch">
    <!-- GENERALES -->
    <div class="col-md-3 d-flex">
        <div class="module text-center {{$generales?'completed':''}} w-100">
            <div class="module-icon">
                <i class="fa-solid fa-user-pen"></i>
            </div>
            <h5>
                Generales
            </h5>
            <p>
                Datos personales y de contacto
            </p>
            <div class="mt-auto">
                @if($edicionBloqueada)

                    <button class="btn btn-secondary" disabled>
                        @if($estatus_registro == 5)
                            <i class="fa-solid fa-circle-check"></i>
                            Validado
                        @elseif($estatus_registro == 2 || $estatus_registro == 4)
                            <i class="fa-solid fa-lock"></i>
                            Edición bloqueada
                        @elseif($estatus_registro == 3)
                            <i class="fa-solid fa-clock"></i>
                            En revisión
                        @else
                            <i class="fa-solid fa-clock"></i>
                            En revisión
                        @endif
                    </button>

                @else

                    <a href="{{ route('aspirante.generales.listar') }}"
                    class="btn {{ $generales ? 'btn-success' : 'btn-main' }}">

                        @if($generales)
                            <i class="fa-solid fa-check"></i>
                            Completado
                        @else
                            Registrar
                        @endif

                    </a>

                @endif
            </div>
        </div>
    </div>
    <!-- CURRICULUM -->
    <div class="col-md-3 d-flex">
        <div class="module text-center {{$curriculums?'completed':''}} w-100">
            <div class="module-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h5>
                Currículum
            </h5>
            <p>
                Formación académica y experiencia laboral
            </p>
            <div class="mt-auto">
                @if($generales)

                    @if($edicionBloqueada)

                        <button class="btn btn-secondary" disabled>

                            @if($estatus_registro == 5)
                                <i class="fa-solid fa-circle-check"></i>
                                Validado
                            @elseif($estatus_registro == 2 || $estatus_registro == 4)
                                <i class="fa-solid fa-lock"></i>
                                Edición bloqueada
                            @else
                                <i class="fa-solid fa-clock"></i>
                                En revisión
                            @endif

                        </button>

                    @else

                        <a href="{{ route('aspirante.curriculums.listar') }}"
                        class="btn {{ $curriculums ? 'btn-success' : 'btn-main' }}">

                            @if($curriculums)
                                <i class="fa-solid fa-check"></i>
                                Completado
                            @else
                                Registrar
                            @endif

                        </a>

                    @endif

                @else

                    <button class="btn btn-secondary" disabled>
                        Bloqueado
                    </button>

                @endif
            </div>
        </div>
    </div>
    <!-- ARCHIVOS -->
    <div class="col-md-3 d-flex">
        <div class="module text-center {{$archivosSubidos?'completed':''}} w-100">
            <div class="module-icon">
                <i class="fa-solid fa-cloud-arrow-up"></i>
            </div>
            <h5>
                Documentos
            </h5>
            <p>
                Carga de documentos probatorios
            </p>
            <div class="mt-auto">
            @if($generales && $curriculums)

                @if($estatus_registro == 2 || $estatus_registro == 4)

                    <a href="{{ route('aspirante.archivos.listar') }}"
                    class="btn btn-warning">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Requerimientos
                    </a>

                @elseif($estatus_registro == 1 || $estatus_registro == 3)

                    <button class="btn btn-secondary" disabled>
                        <i class="fa-solid fa-clock"></i>
                        En revisión
                    </button>

                @elseif($estatus_registro == 5)

                    <button class="btn btn-secondary" disabled>
                        <i class="fa-solid fa-circle-check"></i>
                        Validados
                    </button>

                @else

                    <a href="{{ route('aspirante.archivos.listar') }}"
                    class="btn {{ $archivosSubidos ? 'btn-success' : 'btn-main' }}">

                        @if($archivosSubidos)
                            <i class="fa-solid fa-check"></i>
                            Completado
                        @else
                            Registrar
                        @endif

                    </a>

                @endif

            @else

                <button class="btn btn-secondary" disabled>
                    Bloqueado
                </button>

            @endif

            </div>
        </div>
    </div>
    <!-- FINALIZAR REGISTRO -->
    <div class="col-md-3 d-flex">
        <div class="module text-center {{ $modulos_completos ? 'completed' : '' }} w-100">
            <div class="module-icon">
                <i class="fa-solid fa-cloud-arrow-up"></i>
            </div>
            <h5>
                Finalizar registro
            </h5>
            <p>
                Guarda y envía tu registro completo con todos los módulos requeridos.
            </p>
            <div class="mt-auto">

                @if($modulos_completos)

                    <button class="btn btn-secondary" disabled>
                        <i class="fa-solid fa-check-circle"></i>
                        Registro completado
                    </button>

                @elseif($generales && $curriculums && $archivosSubidos)

                    <button class="btn btn-main" id="btnFinalizarRegistro">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        Finalizar registro
                    </button>

                @else

                    <button class="btn btn-secondary" disabled>
                        <i class="fa-solid fa-lock"></i>
                        Complete los módulos
                    </button>

                @endif

            </div>
        </div>
    </div>
</div>
<h3 class="fw-bold mt-5 mb-4">
    Documentos de registro para descargar
</h3>
<div class="row g-4 align-items-stretch">
    @if(in_array($estatus_modulo, [1,2,3,4,5]))
    <!-- CV -->
    <div class="col-md-3 d-flex">
        <div class="module text-center completed w-100">
            <div class="module-icon">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <h5>Currículum Vitae</h5>
            <p>Generar CV del aspirante en formato PDF.</p>
            <div class="mt-auto">
                <a href="{{route('aspirante.cv.pdf')}}" class="btn btn-outline-primary btn-descarga">
                    <i class="fa-solid fa-download"></i> Generar CV
                </a>
            </div>
        </div>
    </div>
    <!-- ACUSE -->
    <div class="col-md-3 d-flex">
        <div class="module text-center completed w-100">
            <div class="module-icon">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>
            <h5>Acuse de Registro</h5>
            <p>Generar comprobante de registro PDF.</p>
            <div class="mt-auto">
                <a href="{{route('aspirante.acuse.registro.pdf')}}" class="btn btn-outline-primary btn-descarga">
                    <i class="fa-solid fa-download"></i> Generar Acuse
                </a>
            </div>
        </div>
    </div>
    @endif
    @if($estatus_modulo == 5)
    <!-- CONSTANCIA -->
    <div class="col-md-3 d-flex">
        <div class="module text-center completed w-100">
            <div class="module-icon">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <h5>Constancia de Registro</h5>
            <p>Generar constancia oficial de registro PDF.</p>
            <div class="mt-auto">
                <a href="{{route('aspirante.constancia.registro.pdf')}}" class="btn btn-outline-primary btn-descarga">
                    <i class="fa-solid fa-download"></i> Generar Constancia
                </a>
            </div>
        </div>
    </div>
    @endif
</div>


@if($estatus_modulo == 5 && $todoValidado)
    <h3 class="fw-bold mt-5 mb-4">
        Presentar examen
    </h3>
    <div class="row g-4 align-items-stretch">
        <!-- EXAMEN -->
        <div class="col-md-4 d-flex">
            <div class="module text-center {{ $examen ? 'completed' : '' }} w-100">
                <div class="module-icon">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <h5>
                    Examen de aspirante
                </h5>
                <p>
                    Examen de conocimientos generales y electorales.
                </p>
                <div class="mt-auto">
                    @if($examen)
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class="fa-solid fa-check"></i>
                            Completado
                        </button>

                    @elseif($examen_visible)
                        <button type="button"
                                class="btn btn-main"
                                data-bs-toggle="modal"
                                data-bs-target="#modalRecomendaciones">
                            <i class="fa-solid fa-file-signature"></i>
                            Iniciar examen
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

<div class="modal fade" id="modalRecomendaciones" tabindex="-1" aria-labelledby="modalRecomendacionesLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalRecomendacionesLabel">
                    <i class="fas fa-info-circle me-2" style="color:#E22275;"></i>
                    Recomendaciones antes de iniciar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <p class="mb-3">
                    Antes de comenzar el examen, toma en cuenta las siguientes recomendaciones:
                </p>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-window-maximize me-2 mt-1"
                           style="color:#E22275;"></i>
                        <span>
                            No cierres la pestaña del navegador durante el examen.
                        </span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-sign-in-alt me-2 mt-1"
                           style="color:#E22275;"></i>
                        <span>
                            Si se cierra, vuelve a entrar con tu usuario para continuar el examen.
                        </span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-clock me-2 mt-1"
                           style="color:#E22275;"></i>
                        <span>
                            El tiempo corre desde el inicio y no se detiene.
                        </span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle me-2 mt-1"
                           style="color:#E22275;"></i>
                        <span>
                            Las preguntas no respondidas se registran como incorrectas.
                        </span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-check-circle me-2 mt-1"
                           style="color:#E22275;"></i>
                        <span>
                            Al finalizar podrás regresar al panel o cerrar sesión.
                        </span>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="fas fa-wifi me-2 mt-1"
                           style="color:#E22275;"></i>
                        <span>
                            Mantén una conexión estable a Internet durante todo el examen.
                        </span>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 30px; padding: 12px 30px;" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <a href="{{ route('aspirante.examen.listar') }}" class="btn btn-main">
                    <i class="fa-solid fa-play me-1"></i>
                    Entendido, iniciar examen
                </a>
            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<script>


document.querySelectorAll('.btn-descarga').forEach(btn => {

    btn.addEventListener('click', function(){

        Swal.fire({
            title: 'Generando documento',
            text: 'Estamos preparando su documento. La descarga iniciará automáticamente al finalizar el proceso.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 8000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });

    });

});

document.querySelectorAll('.btn-descarga3').forEach(btn => {

    btn.addEventListener('click', function(){

        let url = this.dataset.url;

        Swal.fire({
            title: 'Generando documento',
            text: 'Por favor espere mientras se prepara la descarga.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });


        fetch(url)
        .then(response => response.blob())
        .then(blob => {

            Swal.close();

            let link = document.createElement('a');

            link.href = window.URL.createObjectURL(blob);

            link.download = "documento.pdf";

            document.body.appendChild(link);

            link.click();

            document.body.removeChild(link);

        })
        .catch(error => {

            Swal.fire({
                icon:'error',
                title:'Error',
                text:'No fue posible generar el documento'
            });

            console.error(error);

        });

    });

});



$(function () {

    $('#btnFinalizarRegistro').on('click', function () {

        Swal.fire({
            title: '¿Finalizar registro?',
            text: 'Una vez finalizado el registro, su información será enviada para revisión y no podrá modificarla, salvo que exista algún requerimiento.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, finalizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {

            if (!result.isConfirmed) return;

            $.ajax({

                url: "{{ route('aspirante.finalizar.registro') }}",
                type: "POST",

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                beforeSend: function () {
                    $('#btnFinalizarRegistro')
                        .prop('disabled', true)
                        .html('<i class="fa-solid fa-spinner fa-spin"></i> Finalizando...');
                },

                success: function (response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Registro finalizado',
                        text: response.message,
                        confirmButtonColor: '#198754',
                         confirmButtonText: 'Aceptar',
                    }).then(() => {
                        location.reload();
                    });

                },

                error: function (xhr) {

                    $('#btnFinalizarRegistro')
                        .prop('disabled', false)
                        .html('<i class="fa-solid fa-cloud-arrow-up"></i> Finalizar registro');

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message ?? 'No fue posible finalizar el registro.'
                    });

                }

            });

        });

    });

});
</script>
@endpush