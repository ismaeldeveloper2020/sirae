<div class="container-fluid py-4">
    @push('styles')
    <style>
        .card {
            border-radius: 18px;
        }
        table thead th {
            background: #f8f9fa;
            font-weight: 700;
        }
        table td .btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    @endpush
    @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('status') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
        @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-3">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('error') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    {{-- INFORMACION ASPIRANTE --}}
<div class="card shadow border-0 mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="bi bi-person-badge me-2"></i>
            Información del aspirante
        </h5>
    </div>
    <div class="card-body">
        <h4 class="mb-3">
            {{ $user->nombre }}
            {{ $user->apaterno }}
            {{ $user->amaterno }}
        </h4>
        <div class="row">
            <div class="col-md-6">
                <p class="mb-2">
                    <i class="bi bi-envelope me-2"></i>
                    <b>Email:</b> {{ $user->email }}
                </p>
                <p class="mb-2">
                    <b>Folio:</b> {{ $user->folio }}
                </p>
            </div>
            <div class="col-md-6">
                <p class="mb-2">
                    <b>Teléfono:</b> {{ $user->telefono_movil }}
                </p>
                <p class="mb-2">
                    <b>Fecha registro:</b> 
                    {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>
</div>
    {{-- DOCUMENTOS --}}
    <div class="card shadow border-0">
<div class="card-header bg-white d-flex align-items-center">
    {{-- IZQUIERDA --}}
    <div class="flex-grow-1">
        <h5 class="mb-0">
            <i class="bi bi-folder-check me-2"></i>
            Documentos cargados
        </h5>
    </div>
    {{-- CENTRO --}}
<div class="text-center flex-grow-1">
    @php
        $tieneRequerimientos = $user->documentos
            ->where('validado',1)
            ->count() > 0;
        $tieneSubsanados = $user->documentos
            ->where('validado',2)
            ->count() > 0;
        $todosValidados = $user->documentos
            ->where('validado','!=',3)
            ->count() == 0
            && $user->documentos->count() > 0;
        $pendientes = $user->documentos
            ->where('validado',0)
            ->count() > 0;
    @endphp
    @if($todosValidados)
        <span class="badge bg-success rounded-pill px-4 py-2 fs-6">
            <i class="bi bi-check-circle me-1"></i>
            Documentos validados
        </span>
    @elseif($tieneRequerimientos && $tieneSubsanados)
        <span class="badge bg-danger rounded-pill px-4 py-2 fs-6">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Documentos con requerimientos y subsanados
        </span>
    @elseif($tieneRequerimientos)
        <span class="badge bg-warning text-dark rounded-pill px-4 py-2 fs-6">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Documentos con requerimientos
        </span>
    @elseif($tieneSubsanados)
        <span class="badge bg-info rounded-pill px-4 py-2 fs-6">
            <i class="bi bi-arrow-repeat me-1"></i>
            Documentos subsanados
        </span>
    @else
        <span class="badge bg-secondary rounded-pill px-4 py-2 fs-6">
            <i class="bi bi-clock me-1"></i>
            Pendientes por validar
        </span>
    @endif
</div>
    {{-- DERECHA --}}
    <div class="flex-grow-1 text-end">
        @if($validacionCompleta)
            <button 
                class="btn btn-dark"
                wire:click="finalizarValidacion({{ $user->id }})"
                wire:loading.attr="disabled"
                wire:target="finalizarValidacion({{ $user->id }})">

                <span wire:loading.remove wire:target="finalizarValidacion({{ $user->id }})">
                    <i class="bi bi-check-circle"></i>
                    Finalizar validación y generar constancia
                </span>

                <span wire:loading wire:target="finalizarValidacion({{ $user->id }})">
                    <i class="bi bi-hourglass-split"></i>
                    Generando constancia...
                </span>
            </button>
        @endif
        <button 
            class="btn btn-info text-white"
            wire:click="enviarRequerimiento({{ $user->id }})"
            wire:loading.attr="disabled"
            wire:target="enviarRequerimiento({{ $user->id }})">

            <span wire:loading.remove wire:target="enviarRequerimiento({{ $user->id }})">
                <i class="bi bi-check-circle"></i>
                Enviar requerimiento
            </span>

            <span wire:loading wire:target="enviarRequerimiento({{ $user->id }})">
                <i class="bi bi-hourglass-split"></i>
                Generando requerimiento...
            </span>
        </button>

        <button wire:click="validarTodos"
                class="btn btn-primary">
            <i class="bi bi-check-circle me-1"></i>
            Validar todos
        </button>
    </div>
</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="documentsTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Tipo documento
                            </th>
                            <th>
                                Archivo
                            </th>
                            <th>
                                Estado
                            </th>
                            <th>
                                Observación
                            </th>
                            <th class="text-center" style="width: 120px;">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->documentos as $doc)
                        <tr>
                            <td>
                                <strong>
                                    {{ $doc->documento->id ?? 's/n' }}
                                </strong>
                            </td>
                            <td>
                                <strong>
                                    {{ $doc->documento->nombre ?? 'Documento' }}
                                </strong>
                            </td>
                            <td>
                                <button title="Ver documnento" type="button" class="btn btn-outline-primary" onclick="verPdf('{{ url('storage/'.$doc->ruta) }}','{{ $doc->nombre }}')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                            <td>
                                @if($doc->validado == 0)
                                <span class="badge bg-secondary">
                                    Pendiente
                                </span>
                                @elseif($doc->validado == 1)
                                <span class="badge bg-warning text-dark">
                                    Requerido
                                </span>
                                @elseif($doc->validado == 2)
                                <span class="badge bg-info">
                                    Subsanado
                                </span>
                                @elseif($doc->validado == 3)
                                <span class="badge bg-success">
                                    Validado
                                </span>
                                @endif
                            </td>
                            <td>
                                {{ $doc->observacion ?? 'Sin observación' }}
                            </td>
                            <td class="text-center">
                                @if($doc->validado == 3)
                                {{-- quitar validacion --}}
                                <button wire:click="quitarValidacion({{ $doc->id }})" class="btn btn-outline-secondary rounded-circle" title="Quitar validación">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                                @else
                                    @if($doc->validado == 1)
                                        {{-- Solo botón visual sin acción --}}
                                        <button class="btn btn-outline-secondary rounded-circle"
                                                title="Documento con requerimiento"
                                                disabled>
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    @elseif($doc->validado == 2 or $doc->validado == 0)
                                        {{-- Botón funcional --}}
                                        <button wire:click="validarDocumento({{ $doc->id }})"
                                                class="btn btn-outline-success rounded-circle"
                                                title="Validar">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    @endif
                                @endif
                                @if($doc->validado == 1)
                                {{-- quitar requerimiento --}}
                                <button wire:click="quitarRequerimiento({{ $doc->id }})" class="btn btn-outline-secondary rounded-circle" title="Quitar requerimiento">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                                @else
                                {{-- requerir --}}
                                <button wire:click="abrirRequerimiento({{ $doc->id }})" class="btn btn-outline-danger rounded-circle" title="Requerir">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="pdfModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfTitulo">
                            Documento
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <iframe id="pdfViewer" width="100%" height="700px" style="border:none;">
                        </iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @if($mostrarModalRequerimiento)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.55);">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg border-0 rounded-4">
                    <div class="modal-header bg-warning text-dark rounded-top-4">
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Agregar requerimiento
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('mostrarModalRequerimiento',false)">
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="alert alert-warning d-flex align-items-center">
                            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                            <div>
                                Indique claramente qué debe corregir el aspirante
                                en este documento.
                            </div>
                        </div>
                        <label class="form-label fw-bold">
                            Observación del requerimiento
                        </label>
                        <textarea wire:model.defer="observacion" class="form-control rounded-3" rows="8" placeholder="Ejemplo:
        El documento no es legible.
        Favor de subir nuevamente el archivo."></textarea>
                        @error('observacion')
                        <div class="text-danger mt-2">
                            <i class="bi bi-x-circle"></i>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button class="btn btn-secondary" wire:click="$set('mostrarModalRequerimiento',false)">
                            <i class="bi bi-x-lg me-1"></i>
                            Cancelar
                        </button>
                        <button class="btn btn-warning" wire:click="guardarRequerimiento" wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <i class="bi bi-save me-1"></i>
                                Guardar requerimiento
                            </span>
                            <span wire:loading>
                                <i class="bi bi-arrow-repeat"></i>
                                Guardando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
function verPdf(url,nombre){
    document.getElementById('pdfViewer').src=url;
    document.getElementById('pdfTitulo').innerHTML=nombre;
    new bootstrap.Modal(
        document.getElementById('pdfModal')
    ).show();
}
document.getElementById('pdfModal')
.addEventListener('hidden.bs.modal',function(){
    document.getElementById('pdfViewer').src='';
});
document.addEventListener('livewire:init',()=>{
    let tabla=null;
    //==========================================
    // DATATABLE
    //==========================================
    function cargarTabla(){
        if(!$('#documentsTable').length){
            return;
        }
        if($.fn.DataTable.isDataTable('#documentsTable')){
            tabla=$('#documentsTable').DataTable();
            return;
        }
        tabla=$('#documentsTable').DataTable({
            responsive:true,
            autoWidth:false,
            pageLength:25,
            lengthMenu:[
                [5,10,25,50,-1],
                [5,10,25,50,'Todos']
            ],
            language:{
                search:'Buscar:',
                lengthMenu:'Mostrar _MENU_ registros',
                info:'Mostrando _START_ a _END_ de _TOTAL_',
                zeroRecords:'No hay documentos',
                paginate:{
                    previous:'‹',
                    next:'›'
                }
            },
            columnDefs:[
                {
                    targets:4,
                    orderable:false
                }
            ]
        });
    }
    cargarTabla();
    //==========================================
    // RECARGAR TABLA (SOLO CUANDO SEA NECESARIO)
    //==========================================
    Livewire.on('recargarTabla',()=>{
        if($.fn.DataTable.isDataTable('#documentsTable')){
            $('#documentsTable')
            .DataTable()
            .destroy();
        }
        setTimeout(()=>{
            cargarTabla();
        },150);
    });
    //==========================================
    // DESCARGAR CONSTANCIA
    //==========================================
    Livewire.on('descargar-constancia',(event)=>{
        let link=document.createElement('a');
        link.href='/storage/aspirantes/pdf/generados/'+event.archivo;
        link.download=event.archivo;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    Livewire.on('descargar-requerimiento',(event)=>{
        let link=document.createElement('a');
        link.href='/storage/aspirantes/pdf/generados/'+event.archivo;
        link.download=event.archivo;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
    //==========================================
    // MENSAJES
    //==========================================
    Livewire.on('finalizacion-ok',(event)=>{
        Swal.fire({
            icon:'success',
            title:'Proceso finalizado',
            text:event.mensaje ??
            'Validación completada correctamente',
            confirmButtonColor:'#E22275'
        });
    });
    Livewire.on('finalizacion-error',(event)=>{
        Swal.fire({
            icon:'error',
            title:'Error',
            text:event.mensaje ??
            'Ocurrió un error',
            confirmButtonColor:'#E22275'
        });
    });
});
</script>
@endpush
