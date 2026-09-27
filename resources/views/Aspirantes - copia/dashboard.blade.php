@extends('layouts.aspirante')
@section('title','Panel Aspirante')
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
$conObservacion_requerido = \App\Models\Aspirantes\Archivos::where('user_id',auth()->id())->whereNull('deleted_at')->where('validado',1)->whereNotNull('observacion')->exists();
$tienePendientes = \App\Models\Aspirantes\Archivos::where('user_id', auth()->id())->whereNull('deleted_at')->where('validado','!=',3)->exists();

$estatus_modulo = DB::table('padron_aspirantes_modulos')->where('user_id', auth()->id())->value('modulo_registro');

$todoValidado = false;
if($tienePendientes && $conObservacion_requerido)
{
    $todoValidado = false;
}
else {
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
    $todoValidado = true;
}
else {
    $todoValidado = false;
}

$avance = 0;

$avance = 0;
$estatus_registro = 0;

if ($generales && $curriculums && $todoValidado && $archivosSubidos && $conObservacion_requerido)
{
    // Completo pero con archivos para corregir
    $avance = 100;
    $estatus_registro = 2;
}
elseif ($generales && $curriculums && $todoValidado && $archivosSubidos)
{
    // Completo y todo correcto
    $avance = 100;
    $estatus_registro = 3;
}
elseif ($generales && $curriculums)
{
    // Tiene generales y curriculum, faltan documentos o validación
    $avance = 70;
    $estatus_registro = 0;
}
elseif ($generales)
{
    // Solo generales
    $avance = 35;
    $estatus_registro = 0;
}

$texto_estatus = match($estatus_registro)
{
    0 => 'Registro en proceso',
    1 => 'Registro completado se encuentra en revisión y validación',
    2 => 'Registro completado con requerimientos',
    3 => 'Registro completado y validado',
    default => 'Sin estatus'
};
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
    @if($estatus_registro == 3)
    <span class="badge bg-success fs-6">
        <i class="fa-solid fa-circle-check me-1"></i>
        {{$texto_estatus}}
    </span>
    @elseif($estatus_registro == 2)
    <span class="badge bg-danger fs-6">
        <i class="fa-solid fa-triangle-exclamation me-1"></i>
        {{$texto_estatus}}
    </span>
    @elseif($estatus_registro == 1)
    <span class="badge bg-warning text-dark fs-6">
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
<small class="d-block text-muted fs-5 fw-normal mt-2">
    En esta sección podrá consultar y completar los módulos correspondientes a su registro.
    La documentación cargada será revisada por el área encargada de validación.
    En caso de detectar algún error o inconsistencia, se mostrará una observación
    indicando la corrección requerida para continuar con el proceso.
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
    <div class="col-md-4 d-flex">
        <div class="module text-center {{$generales?'completed':''}} w-100">
            <div class="module-icon">
                <i class="fa-solid fa-user-pen"></i>
            </div>
            <h5>
                Generales
            </h5>
            <p>
                Datos personales y contacto.
            </p>
            <div class="mt-auto">

                @if($estatus_registro == 1 || $estatus_registro == 2 || $estatus_registro == 3)

                    <button class="btn btn-secondary" disabled>
                        @if($estatus_registro == 1)
                            En revisión
                        @else
                            Validación finalizada
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
    <div class="col-md-4 d-flex">
        <div class="module text-center {{$curriculums?'completed':''}} w-100">
            <div class="module-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h5>
                Currículum
            </h5>
            <p>
                Formación académica y experiencia.
            </p>
            <div class="mt-auto">
                @if($generales)

                   @if($estatus_registro == 1 || $estatus_registro == 2 || $estatus_registro == 3)

                        <button class="btn btn-secondary" disabled>
                            @if($estatus_registro == 1)
                                En revisión
                            @else
                                Validación finalizada
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
    <div class="col-md-4 d-flex">
        <div class="module text-center {{$archivosSubidos?'completed':''}} w-100">
            <div class="module-icon">
                <i class="fa-solid fa-cloud-arrow-up"></i>
            </div>
            <h5>
                Documentos
            </h5>
            <p>
                Carga de documentos.
            </p>
<div class="mt-auto">

    @if($generales && $curriculums)

        @if($estatus_registro == 2)

            <a href="{{ route('aspirante.archivos.listar') }}" 
               class="btn btn-warning">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Requerimientos pendientes
            </a>

        @elseif($estatus_registro == 1 || $estatus_registro == 3)

            <button class="btn btn-secondary" disabled>
                @if($estatus_registro == 1)
                    En revisión
                @else
                    Validación finalizada
                @endif
            </button>

        @else

            <a href="{{ route('aspirante.archivos.listar') }}" 
               class="btn 
                    @if($archivosSubidos)
                        btn-success
                    @else
                        btn-main
                    @endif">

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
</div>


<h3 class="fw-bold mt-5 mb-4">
    Documentos de registro para descargar
</h3>

<div class="row g-4 align-items-stretch">
    @if(in_array($estatus_modulo, [1,2]))
    <!-- CV -->
    <div class="col-md-4 d-flex">
        <div class="module text-center completed w-100">
            <div class="module-icon">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <h5>Currículum Vitae</h5>
            <p>Generar CV del aspirante en formato PDF.</p>
            <div class="mt-auto">
                <a href="{{route('aspirante.cv.pdf')}}" class="btn btn-primary">
                    <i class="fa-solid fa-download"></i> Generar CV
                </a>
            </div>
        </div>
    </div>
    <!-- ACUSE -->
    <div class="col-md-4 d-flex">
        <div class="module text-center completed w-100">
            <div class="module-icon">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>
            <h5>Acuse de Registro</h5>
            <p>Generar comprobante de registro PDF.</p>
            <div class="mt-auto">
                <a href="{{route('aspirante.acuse.registro.pdf')}}" class="btn btn-primary">
                    <i class="fa-solid fa-download"></i> Generar Acuse
                </a>
            </div>
        </div>
    </div>
    @endif
    @if($estatus_modulo == 1)
    <!-- CONSTANCIA -->
    <div class="col-md-4 d-flex">
        <div class="module text-center completed w-100">
            <div class="module-icon">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <h5>Constancia de Registro</h5>
            <p>Generar constancia oficial de registro PDF.</p>
            <div class="mt-auto">
                <a href="{{route('aspirante.constancia.registro.pdf')}}" class="btn btn-primary">
                    <i class="fa-solid fa-download"></i> Generar Constancia
                </a>
            </div>
        </div>
    </div>
    @endif
</div>


@if($estatus_modulo == 1)
<h3 class="fw-bold mt-5 mb-4">
    Presentar examen
</h3>
<div class="row g-4 align-items-stretch">
    <div class="col-md-4">
        <div class="module text-center w-100">
            <h5>
                Iniciar examen
            </h5>
        </div>
    </div>
</div>
@endif
@endsection
