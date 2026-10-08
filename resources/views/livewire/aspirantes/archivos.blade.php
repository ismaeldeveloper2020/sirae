<div>
    <style>
        /* TOOLTIP PERSONALIZADO */
        .tooltip-inner {
            background: #020a16 !important;
            color: #fff !important;
            font-size: 13px;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 500;
        }
        .bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #020a16 !important;
        }
        .bs-tooltip-bottom .tooltip-arrow::before {
            border-bottom-color: #020a16 !important;
        }
        .bs-tooltip-start .tooltip-arrow::before {
            border-left-color: #020a16 !important;
        }
        .bs-tooltip-end .tooltip-arrow::before {
            border-right-color: #020a16 !important;
        }
        /* TARJETAS */
        .documento-card {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-left: 5px solid #928e90;
            border-radius: 16px;
            transition: all .25s ease;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,.06);
        }


        .documento-card:hover {
            transform: translateY(-3px);
            border-color: #928e90;
            box-shadow: 0 8px 20px rgba(236,76,146,.18);
        }


        /* Encabezado de la tarjeta */
        .documento-header {
            background: linear-gradient(135deg,#fafafa,#f6f6f6);
            padding: 14px 16px;
            border-bottom: 1px solid #eee;
        }


        /* Cuerpo */
        .documento-body {
            padding: 18px;
        }


        /* Separación entre tarjetas */
        .row.g-3 > div {
            margin-bottom: 8px;
        }
        /* BOTONES ICONO */
        .btn-icon {
            width:36px;
            height:36px;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        /* GUARDAR */
        .btn-guardar {
            background:linear-gradient(135deg,#673AB7,#512DA8);
            border:none;
            color:white;
            font-weight:600;
        }
        .btn-guardar:hover {
            background:linear-gradient(135deg,#512DA8,#4527A0);
            color:white;
        }
        /* BOTON SUSTITUIR */
        .btn-sustituir:hover {
            background:#35d6e8;
            color:white;
        }
        .nota-expediente {
            color:#706c6e;
            font-size:13px;
            display:flex;
            align-items:flex-start;
            gap:10px;
            margin-bottom:10px;
            line-height:1.4;
        }
        .nota-expediente i {
            color:#ec4c92;
            font-size:15px;
            min-width:18px;
            margin-top:2px;
        }
        .nota-expediente em {
            text-align:justify;
        }
    </style>
    <div class="container-fluid">
        <div class="card shadow border-0">
            <div class="card-header text-white" style="background:#E22275">
                <h5 class="mb-0">
                    <i class="fa-solid fa-folder-open me-2"></i>
                    Expediente digital
                </h5>
            </div>
            <div class="card-body">
            <div class="mt-3 mb-4">
                <p class="nota-expediente">
                    <i class="fa-solid fa-file-pdf"></i>
                    <em>
                        Únicamente se admiten documentos en formato PDF con un tamaño máximo de 2 MB. Si necesita agregar varias hojas comprobatorias para un mismo documento, deberá unirlas previamente en un solo archivo PDF.
                    </em>
                </p>
                <p class="nota-expediente">
                    <i class="fa-solid fa-upload"></i>
                    <em>
                        Para cargar un documento, seleccione el archivo PDF correspondiente en el campo de carga ubicado debajo del nombre del documento requerido. Una vez seleccionado el archivo,
                        aparecerá el botón "guardar archivo" para enviarlo al sistema.
                    </em>
                </p>
                <p class="nota-expediente">
                    <i class="fa-solid fa-eye"></i>
                    <em>
                        Después de guardar correctamente el documento, podrá visualizarlo utilizando el botón con el ícono de “visualizar documento” ubicado en la parte derecha del documento cargado.
                    </em>
                </p>
                <p class="nota-expediente">
                    <i class="fa-solid fa-rotate"></i>
                    <em>
                        Si por alguna razón seleccionó o cargó un archivo incorrecto, puede utilizar la opción "sustituir documento" mediante el botón con el ícono de “rotación”. Esta opción permite reemplazar el documento cargado por el archivo correcto y guardarlo nuevamente en el sistema.
                    </em>
                </p>
                <p class="nota-expediente">
                    <i class="fa-solid fa-file-signature"></i>
                    <em>
                        Para los documentos de carta bajo protesta de decir verdad y constancia o carta compromiso de situación fiscal, deberá subir
                        el formato disponible en:
                        <a href="https://sirae2027.iepc-chiapas.org.mx" target="_blank" rel="noopener noreferrer"> https://sirae2027.iepc-chiapas.org.mx</a>
                        debidamente requisitado.
                    </em>
                </p>
                <p class="nota-expediente">
                    <i class="fa-solid fa-id-card"></i>
                    <em>
                        Es necesario que la Credencial para Votar y la licencia para conducir sean vigentes; en caso de que no cuente con Credencial para Votar vigente, deberá capturar el comprobante de trámite. El comprobante de domicilio debe ser reciente (no mayor a tres meses).
                    </em>
                </p>
                <p class="nota-expediente">
                    <i class="fa-solid fa-circle-check"></i>
                    <em>
                        Antes de guardar el módulo, verifique que todos los documentos requeridos correspondan a lo solicitado.
                    </em>
                </p>
            </div>
            <div class="row g-3">
                @foreach($documentos as $doc)
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="documento-card">
                        <div class="documento-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>
                                    <i class="fa-solid fa-file-pdf text-danger me-2"></i>
                                    {{$doc->nombre}}
                                </strong>
                                @php
                                $esObligatorio = $doc->obligatorio == 1 || in_array($doc->nombre,$documentosConInformacion);
                                //$esObligatorio = $doc->obligatorio == 1 || in_array($doc->id, $documentosConInformacion);
                                @endphp
                                @if($esObligatorio)
                                    <span class="badge bg-danger">
                                        Obligatorio
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Opcional
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="documento-body">
                        @if(isset($archivosGuardados[$doc->id]))
                            @php
                                $archivo=$archivosGuardados[$doc->id];
                            @endphp
                            <div class="mb-2">
                            @if($archivo->validado == 3)
                                <span class="badge bg-success">
                                    <i class="fa-solid fa-check"></i>
                                    Validado
                                </span>
                            @elseif($archivo->validado == 1 && !empty($archivo->observacion))
                                <span class="badge bg-danger">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Corrección requerida
                                </span>
                            @elseif($archivo->validado == 2)
                                <span class="badge bg-info text-dark">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Subsanado
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="fa-solid fa-clock"></i>
                                    En revisión
                                </span>
                            @endif
                            </div>
                            @if($archivo->validado == 1 && !empty($archivo->observacion))
                            <div class="alert alert-danger py-2 small">
                                <strong>
                                    Requerimiento:
                                </strong>
                                {{$archivo->observacion}}
                            </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fa-solid fa-file-pdf text-danger"></i>
                                    {{$archivo->nombre}}
                                </small>
                                <div class="d-flex gap-2">
                                    <!-- VER PDF -->
                                    <span data-bs-toggle="tooltip"
                                          title="Visualizar documento">
                                        <button
                                            type="button"
                                            class="btn btn-outline-primary btn-icon"
                                            data-bs-toggle="modal"
                                            data-bs-target="#pdf{{$doc->id}}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </span>
                                   @if($moduloCompletado && $esObligatorio && $archivo->validado == 1 && !empty($archivo->observacion))
                                        <span data-bs-toggle="tooltip"
                                            title="Subsanar documento">
                                            <button
                                                type="button"
                                                class="btn btn-outline-success btn-icon btn-subsanar"
                                                 wire:click="seleccionarSubsanacion({{$doc->id}})">
                                                 <i class="fa-solid fa-file-circle-check"></i>
                                            </button>
                                        </span>
                                    @endif
                                    <!-- CAMBIAR -->
                                   @if(!$moduloCompletado)
                                        <span data-bs-toggle="tooltip"
                                            title="Sustituir documento">
                                            <button
                                                type="button"
                                                class="btn btn-outline-info btn-icon btn-sustituir"
                                                wire:click="seleccionarCambio({{$doc->id}})">
                                                <i class="fa-solid fa-rotate"></i>
                                            </button>
                                        </span> 
                                        <span data-bs-toggle="tooltip"
                                            title="Eliminar documento">
                                            <button
                                                type="button"
                                                class="btn btn-outline-danger btn-icon btn-eliminar"
                                                wire:click="eliminar({{$doc->id}})">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </span> 
                                    @endif
                                </div>
                            </div>
                            @if($reemplazo == $doc->id || $subsanacion == $doc->id)
                                <hr>

                                <input
                                    type="file"
                                    class="form-control form-control-sm"
                                    accept=".pdf"
                                    wire:model="archivos.{{$doc->id}}">

                                @error('archivos.'.$doc->id)
                                    <div class="text-danger small">
                                        {{$message}}
                                    </div>
                                @enderror

                                @if(isset($archivos[$doc->id]))
                                    @if($subsanacion == $doc->id)
                                        <button
                                            class="btn btn-success btn-sm w-100 mt-2"
                                            wire:click="subsanar({{$doc->id}})">
                                    <i class="fa-solid fa-upload"></i>
                                            Guardar subsanación
                                        </button>
                                    @else
                                        <button
                                            class="btn btn-success btn-sm w-100 mt-2"
                                            wire:click="guardar({{$doc->id}})">
                                            <i class="fa-solid fa-upload"></i>
                                            Guardar sustitución
                                        </button>
                                    @endif
                                @endif


                            @endif
                        @else
                            <input
                            type="file"
                            class="form-control form-control-sm"
                            accept=".pdf"
                            wire:model="archivos.{{$doc->id}}">
                            <small class="text-muted">
                                Solo PDF máximo 2 MB
                            </small>
                            @error('archivos.'.$doc->id)
                                <div class="text-danger small">
                                    {{$message}}
                                </div>
                            @enderror
                            @if(isset($archivos[$doc->id]))
                            <button
                            class="btn btn-success btn-sm w-100 mt-2"
                            wire:click="guardar({{$doc->id}})">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Guardar documento
                            </button>
                            @endif
                        @endif
                        </div>
                    </div>
                </div>
                <!-- MODAL PDF -->
                @if(isset($archivosGuardados[$doc->id]))
                <div
                class="modal fade"
                id="pdf{{$doc->id}}"
                tabindex="-1"
                wire:ignore.self>
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white">
                                <h6 class="modal-title">
                                    <i class="fa-solid fa-file-pdf text-danger"></i>
                                    {{$doc->nombre}}
                                </h6>
                                <button
                                type="button"
                                class="btn-close btn-close-white"
                                data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="modal-body p-0">
                                <iframe
                                src="{{asset('storage/'.$archivo->ruta)}}"
                                style="width:100%;height:80vh;border:0">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                </div>
                <hr class="">
                <div class="d-flex justify-content-between mt-5 pt-0 mb-0">

                    <a href="{{route('dashboard')}}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left"></i>
                        Volver
                    </a>

                    <button
                        class="btn btn-guardar px-4"
                        wire:click="finalizarModulo"
                        wire:loading.attr="disabled"
                        wire:target="finalizarModulo">

                        <span wire:loading.remove wire:target="finalizarModulo">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Guardar
                        </span>

                        <span wire:loading wire:target="finalizarModulo">
                            <i class="fa-solid fa-spinner fa-spin"></i>
                            Guardando
                        </span>

                    </button>

                </div>
            </div>
        </div>
    </div>
<script>
function activarTooltips(){
    document
    .querySelectorAll('[data-bs-toggle="tooltip"]')
    .forEach(el=>{
        let tooltip = bootstrap.Tooltip.getInstance(el);
        if(!tooltip){
            new bootstrap.Tooltip(el);
        }
    });
}
document.addEventListener('DOMContentLoaded',activarTooltips);
document.addEventListener('livewire:navigated',activarTooltips);
document.addEventListener('livewire:updated',activarTooltips);
document.addEventListener('livewire:init',()=>{
    Livewire.on('alerta',(data)=>{
        Swal.fire({
            icon:data.tipo,
            title:data.titulo,
            text:data.mensaje,
            confirmButtonText:'Aceptar'
        });
    });
});
</script>
</div>
