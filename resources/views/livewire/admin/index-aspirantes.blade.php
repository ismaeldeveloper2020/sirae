<div class="container-fluid py-4">
    @push('styles')
        <style>
           
        </style>
    @endpush
    @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('status') }}
        <button class="btn-close" data-bs-dismiss="alert">
        </button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('error') }}
        <button class="btn-close" data-bs-dismiss="alert">
        </button>
    </div>
    @endif
    {{-- TABLA --}}

    <div class="card-header d-flex align-items-center w-100">
        <h5 class="mb-0">
            <i class="bi bi-people-fill me-2"></i>
            Aspirantes con registro
        </h5>
        <span class="badge bg-secondary rounded-pill px-3 ms-auto fs-6">
            Total de registros: {{ count($users) }}
        </span>
    </div>
    <div class="card-body p-2">
        <div wire:ignore.self>
        <div class="table-responsive">
            <table id="usersTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="all">
                            Folio
                        </th>
                        <th class="all">
                            Aspirante
                        </th>
                        <th class="all">
                            Enlace
                        </th>
                        <th class="all">
                            Descripción
                        </th>
                        <th class="none">
                            Validado
                        </th>
                        <th class="none">
                            CURP
                        </th>
                        <th class="none">
                            Rfc
                        </th>
                        <th class="none">
                            Clave Elector
                        </th>
                        <th class="all">
                            Estatus
                        </th>
                        <th class="all">
                            Designado
                        </th>
                        <th class="all text-center">
                            Acción
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="fw-bold">
                            {{ $user->folio }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-info text-white d-flex justify-content-center align-items-center me-3" style="width:32px;height:32px">
                                    {{ strtoupper(substr($user->nombre,0,1)) }}
                                </div>
                                <div>
                                    <strong>
                                        {{ $user->nombre ." ". $user->apaterno." ". $user->amaterno }}
                                    </strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $user->email }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $user->enlace_distrito_municipio }}
                        </td>
                        <td>
                            {{ $user->descripcion_distrito_municipio }}
                        </td>
                        <td>
                            {{ $user->usuario_valido ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $user->curp ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $user->rfc."".$user->homoclave ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $user->clave_elector ?? 'N/A' }}
                        </td>
                        <td>
                            @switch($user->modulo_registro)
                                @case(1)
                                    <span class="badge bg-secondary rounded-pill px-3">
                                        <i class="bi bi-check-circle"></i>
                                        Finalizado para revision y validacion
                                    </span>
                                    @break
                                @case(2)
                                    <span class="badge bg-danger rounded-pill px-3">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        Con requerimiento
                                    </span>
                                    @break
                                @case(3)
                                    <span class="badge bg-info rounded-pill px-3">
                                        <i class="bi bi-clock"></i>
                                        Subsanado en revisión
                                    </span>
                                    @break
                                @case(4)
                                    <span class="badge bg-warning rounded-pill px-3">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        Con requerimiento y subsanado para revisar
                                    </span>
                                    @break
                                @case(5)
                                    <span class="badge bg-success rounded-pill px-3">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Finalizado y validado
                                    </span>
                                    @break
                                @default
                                    <span class="badge bg-secondary rounded-pill px-3">
                                        <i class="bi bi-clock"></i>
                                        En proceso
                                    </span>
                            @endswitch
                        </td>
                        <td class="text-center">
                            @if($user->designado == 1)
                                <span class="badge bg-primary">
                                    <i class="bi bi-check-circle"></i> Designado
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-x-circle"></i> No designado
                                </span>
                            @endif
                        </td>
                        <td class="text-center" style="width: 120px;">
                            <!-- CV -->
                            <button 
                                type="button"
                                class="btn btn-outline-primary btn-md rounded-circle"
                                wire:click="descargarCv({{ $user->id }})"
                                wire:loading.attr="disabled"
                                wire:target="descargarCv({{ $user->id }})"
                                title="Descargar CV">

                                <span wire:loading.remove wire:target="descargarCv({{ $user->id }})">
                                    <i class="bi bi-file-earmark-person"></i>
                                </span>

                                <span 
                                    wire:loading 
                                    wire:target="descargarCv({{ $user->id }})"
                                    class="spinner-border spinner-border-sm"
                                    role="status">
                                </span>

                            </button>
                            <!-- Acuse -->
                            <button 
                                type="button"
                                class="btn btn-outline-primary btn-md rounded-circle"
                                wire:click="descargarAcuse({{ $user->id }})"
                                wire:loading.attr="disabled"
                                wire:target="descargarAcuse({{ $user->id }})"
                                title="Descargar Acuse">

                                <span wire:loading.remove wire:target="descargarAcuse({{ $user->id }})">
                                    <i class="bi bi-receipt"></i>
                                </span>

                                <span 
                                    wire:loading 
                                    wire:target="descargarAcuse({{ $user->id }})"
                                    class="spinner-border spinner-border-sm">
                                </span>

                            </button>
                            {{--  
                            <a href="{{ route('admin.aspirante.examen', $user->id) }}"
                            class="btn btn-outline-success btn-sm rounded-circle"
                            title="Ver examen">
                                <i class="bi bi-file-earmark-check"></i>
                            </a>
                            --}}
                            <!-- Validar documentos -->
                            <button wire:click="validarListaDocumentos({{ $user->id }})" 
                                    class="btn btn-outline-success btn-md rounded-circle" 
                                    title="Validar documentos">
                                <i class="bi bi-file-earmark-check"></i>
                            </button>
                            <!-- Subir entrevista -->
                                {{--  
                            <button wire:click="uploadInterview({{ $user->id }})" 
                                    class="btn btn-outline-info btn-md rounded-circle" 
                                    title="Subir entrevista">
                                <i class="bi bi-camera-video"></i>
                            </button>
                            --}}
                            <!-- Subir resultado examen -->
                                {{--  
                            <button wire:click="uploadExamResult({{ $user->id }})" 
                                    class="btn btn-outline-secondary btn-md rounded-circle" 
                                    title="Subir resultado examen">
                                <i class="bi bi-file-earmark-medical"></i>
                            </button>
                            --}}

                            <!-- editar registro -->
                            {{--  
                            <button 
                                type="button"
                                title="Resetear registro para editar el aspirante"
                                class="btn btn-outline-warning btn-md rounded-circle"
                                wire:click="editarAspirante({{ $user->id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            --}}

                            <button 
                                type="button"
                                title="Resetear registro para editar el aspirante"
                                class="btn btn-outline-danger btn-md rounded-circle  ms-3"
                                wire:click="confirmarReset({{ $user->id }})">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                            <!-- Editar -->
                                {{--  
                            <button wire:click="uploadExamResult({{ $user->id }})" 
                                    class="btn btn-outline-warning btn-md rounded-circle" 
                                    title="Editar aspirante">
                                <i class="bi bi-bi bi-pencil"></i>
                            </button>
                            --}}
                            <!-- Eliminar -->
                            {{--  
                            <button wire:click="deleteUser({{ $user->id }})" 
                                    onclick="return confirm('¿Eliminar usuario?')" 
                                    class="btn btn-outline-danger btn-md rounded-circle"
                                    title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                            --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{--   {{ $users->links() }} --}}
        </div>
        </div>
    </div>
  
</div>
@push('scripts')
    <script>
    document.addEventListener('livewire:init', () => {
        let table = null;
        function asegurarTabla(){
            if($.fn.DataTable.isDataTable('#usersTable')){
                return;
            }
            cargarTabla();
        }
        function cargarTabla() {
            if (!$('#usersTable').length) {
                return;
            }
            if ($.fn.DataTable.isDataTable('#usersTable')) {
                return;
            }
            table = $('#usersTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [
                    [5,10,25,50,-1],
                    [5,10,25,50,"Todos"]
                ],
                language: {

                    search: "Buscar:",

                    zeroRecords: "Sin información",

                    emptyTable: "Sin información",

                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",

                    infoEmpty: "Sin información",

                    infoFiltered: "(filtrado de _MAX_ registros)",

                    lengthMenu: "Mostrar _MENU_ registros",

                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    }

                },
                columnDefs:[
                    {
                        targets:6,
                        orderable:false
                    }
                ]
            });
        }
        function refrescarTabla(){
            if($.fn.DataTable.isDataTable('#usersTable')){
                $('#usersTable').DataTable().destroy();
            }
            setTimeout(()=>{
                cargarTabla();
            },100);
        }
        // Primera carga
        cargarTabla();
        // Sólo cuando realmente quieras reconstruir la tabla
        Livewire.on('recargarTablaUsuarios',()=>{
            refrescarTabla();
        });
        Livewire.on('confirmar-reset',(event)=>{
            Swal.fire({
                title:'¿Está seguro?',
                text:'El aspirante podrá modificar nuevamente su registro.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor:'#E22275',
                cancelButtonColor:'#6c757d',
                confirmButtonText:'Sí, resetear',
                cancelButtonText:'Cancelar'
            }).then((result)=>{
                
                if(result.isConfirmed){
                    Livewire.dispatch('resetAspirante',{
                        id:event.id
                    });
                }
                asegurarTabla();
            });
        });
        Livewire.on('reset-ok',(event)=>{
            Swal.fire({
                icon:'success',
                title:'Registro reiniciado',
                text:event.mensaje ?? 
                'El aspirante puede capturar nuevamente.',
                confirmButtonText:'Aceptar',
                confirmButtonColor:'#E22275'
            });
        });

        Livewire.on('reset-error',()=>{
            Swal.fire({
                icon:'error',
                title:'Error',
                text:'No fue posible resetear el registro.',
                confirmButtonText:'Aceptar',
                confirmButtonColor:'#E22275'
            });
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


        //==========================================
        // DESCARGAR ACUSE
        //==========================================
        Livewire.on('descargar-acuse',(event)=>{
            let link=document.createElement('a');
            link.href='/storage/aspirantes/pdf/generados/'+event.archivo;
            link.download=event.archivo;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });


        //==========================================
        // DESCARGAR CV
        //==========================================
        Livewire.on('descargar-cv',(event)=>{
            let link=document.createElement('a');
            link.href='/storage/aspirantes/pdf/generados/'+event.archivo;
            link.download=event.archivo;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

    });
    </script>
@endpush
