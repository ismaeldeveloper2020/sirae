<div>
    <style>
        .btn-guardar{
            background:linear-gradient(135deg,#673AB7,#512DA8);
            border:none;
            color:white;
            font-weight:600;
            box-shadow:0 4px 10px rgba(103,58,183,.35);
            transition:.25s ease;
        }
        .btn-guardar:hover{
            background:linear-gradient(135deg,#512DA8,#4527A0);
            color:white;
            transform:translateY(-2px);
            box-shadow:0 6px 14px rgba(103,58,183,.45);
        }
        /* cuando Livewire esta procesando */
        .btn-guardar:disabled{
            background:linear-gradient(135deg,#9575CD,#7E57C2);
            color:white;
            cursor:not-allowed;
            transform:none;
            box-shadow:none;
        }

        .switch-moderno {
            width: 3.5rem !important;
            height: 1.8rem;
            cursor: pointer;
            background-color: #fff;
            border: 1px solid #adb5bd;
        }

        .switch-moderno:checked {
            background-color: #198754;
            border-color: #198754;
        }
    </style>
    @if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{session('mensaje')}}
    </div>
    @endif
    <div class="row">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-bold mb-1">
                    <i class="fa-solid fa-list-check text-primary me-2"></i>
                    Datos por registrar
                </h5>
                <small class="text-muted">
                    Consulta y edita los registros capturados
                </small>
                <small class="text-muted d-block mt-1">
                    <i class="fa-solid fa-asterisk text-danger me-1"></i>
                    Campos obligatorios para completar el registro.
                </small>
                <small class="text-black d-block mt-2">
                    <i class="fa-solid fa-circle-info me-1"></i>
                    <strong>Opcional:</strong> si cuenta con esta información puede
                    registrarla, en caso contrario omita el módulo y
                    regrese al inicio. Si registra información, deberá
                    comprobarla en el módulo de Documentos.
                </small>
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <label class="form-label small @error('id_giro_el') text-danger @else text-muted @enderror">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Giro de la institución o empresa
            </label>
            <select id="id_giro_el" class="form-select select2" data-model="id_giro_el" wire:ignore>
                @foreach($giros as $key=>$value)
                <option value="{{ $key }}" @selected($id_giro_el==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_giro_el')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        <div class="col-md-12 mt-4">
            <label class="form-label small text-muted">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Institución o empresa
            </label>
            <input id="institucion_el" type="text" class="form-control 
            @error('institucion_el') is-invalid @enderror" wire:model="institucion_el">
            @error('institucion_el')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        <div class="col-md-12 mt-4">
            <label class="form-label small text-muted">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Puesto o cargo
            </label>
            <input id="puesto_el" type="text" class="form-control 
            @error('puesto_el') is-invalid @enderror" wire:model="puesto_el">
            @error('puesto_el')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        <div class="col-md-12 mt-4">
            <label class="form-label small text-muted">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Período (ejemplo: 2018-2020)
            </label>
            <input id="periodo_el" type="text" class="form-control 
            @error('periodo_el') is-invalid @enderror" wire:model="periodo_el">
            @error('periodo_el')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{route('dashboard')}}"
        class="btn btn-outline-secondary btn-md px-3 rounded-2">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Volver
        </a>
        <button 
            type="button" 
            class="btn btn-guardar btn-md px-4 rounded-2"
            wire:click="storeExperienciaLaboral"
            wire:loading.attr="disabled"
            wire:target="storeExperienciaLaboral">

            <span wire:loading.remove wire:target="storeExperienciaLaboral">
                <i class="fa-solid fa-floppy-disk me-1"></i>
                Guardar
            </span>

            <span wire:loading wire:target="storeExperienciaLaboral">
                <i class="fa-solid fa-spinner fa-spin me-1"></i>
                Guardando
            </span>
        </button>
    </div>
    <hr class="my-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h5 class="fw-bold mb-1">
                <i class="fa-solid fa-list-check text-primary me-2"></i>
                Datos registrados
            </h5>
            <small class="text-muted">
                Consulta, edita o elimina los registros capturados.
            </small>
        </div>
    </div>
    <table class="table table-bordered table-striped" id="tablaExperienciaLaborales">
        <thead>
            <tr>
                <th>Giro</th>
                <th>Institución</th>
                <th>Puesto</th>
                <th>Periodo</th>
                <th width="60">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datos as $item)
             <tr wire:key="experiencia-laboral-{{ $item['id'] }}">
                <td>{{ $item['giro'] }}</td>
                <td>{{ $item['institucion_el'] }}</td>
                <td>{{ $item['puesto_el'] }}</td>
                <td>{{ $item['periodo_el'] }}</td>
                <td>
                    <button
                        type="button"
                        class="btn btn-sm btn-warning"
                        wire:click="editar({{ $item['id'] }})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        wire:click="confirmarEliminar({{ $item['id'] }})">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@script
    <script>
    // ===============================
    // ELIMINAR CON SWEETALERT
    // ===============================
    Livewire.on('confirmaBorrarExperienciaLaboral', (event) => {
        let id = event.id;
        Swal.fire({
            title:'¿Está seguro?',
            text:'Este registro será eliminado.',
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#d33',
            cancelButtonColor:'#6c757d',
            confirmButtonText:'Sí, eliminar',
            cancelButtonText:'Cancelar'
        }).then((result)=>{
            if(result.isConfirmed){
                Livewire.dispatch('eliminarRegistroExperienciaLaboral',{
                    id:id
                });
            }
        });
    });
    // ===============================
    // MENSAJES SWEETALERT
    // ===============================
    Livewire.on('swalExperienciasLaborales',(data)=>{
        Swal.fire({
            icon:data[0].icon,
            title:data[0].title,
            text:data[0].text,
            confirmButtonText:'Aceptar'
        });
    });

    Livewire.on('actualizarSelectsLaborales',()=>{
        setTimeout(()=>{
            $('#id_giro_el').val(@this.id_giro_el ?? '').trigger('change.select2');
        },200);
    });


    // ===============================
    // INICIALIZAR AL CARGAR HIJO
    // ===============================
    inicializarSelect2();
    setTimeout(()=>{
        inicializarDataTable();
    },200);
    // ===============================
    // CADA CAMBIO DE LIVEWIRE
    // ===============================
    Livewire.hook('morphed', ({el})=>{
        inicializarSelect2();
        inicializarDataTable();
    });
    // ===============================
    // SELECT2
    // ===============================
    function inicializarSelect2(){
        $('.select2').each(function(){
            let select=$(this);
            if(select.hasClass('select2-hidden-accessible')){
                select.select2('destroy');
            }
            select.select2({
                width:'100%',
                allowClear:true
            });
            select.off('change');
            select.on('change',function(){
                let modelo=$(this).data('model');
                let valor=$(this).val();
                let wireId=$(this)
                .closest('[wire\\:id]')
                .attr('wire:id');
                if(wireId && modelo){
                    Livewire.find(wireId)
                    .set(modelo,valor);
                }
            });
        });
    }
    // ===============================
    // DATATABLE
    // ===============================
    function inicializarDataTable(){
        if(!$('#tablaExperienciaLaborales').length){
            return;
        }
        if($.fn.DataTable.isDataTable('#tablaExperienciaLaborales')){
            $('#tablaExperienciaLaborales')
            .DataTable()
            .destroy();
        }
        $('#tablaExperienciaLaborales').DataTable({
            responsive:true,
            pageLength:10,
            language:{
                search:'Buscar:',
                lengthMenu:'Mostrar _MENU_ registros',
                info:'Mostrando _START_ a _END_ de _TOTAL_',
                paginate:{
                    first:'Primero',
                    last:'Último',
                    next:'Siguiente',
                    previous:'Anterior'
                }
            }
        });
    }
    </script>
@endscript