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
                    <strong>Opcional:</strong> si cuenta con esta información puede registrarla, en caso contrario omita el módulo y regrese al inicio. Si registra información, deberá comprobarla en el módulo de Documentos.
                </small>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <label class="form-label small @error('id_tipo_ce') text-danger @else text-muted @enderror">
                <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                Tipo de conocimiento electoraL
            </label>
            <select id="id_tipo_ce" class="form-select select2" data-model="id_tipo_ce" wire:ignore>
                @foreach($conocimientos_electorales as $key=>$value)
                <option value="{{ $key }}" @selected($id_tipo_ce==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_tipo_ce')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @if($mostrar_otro_conocimiento)
        <div class="col-md-12 mt-4">
            <label class="form-label small text-muted">
                <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                Describa otro tipo de conocimiento electoral
            </label>
            <input id="otro_ce" type="text" class="form-control 
            @error('otro_ce') is-invalid @enderror" wire:model="otro_ce">
            @error('otro_ce')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @endif
        <div class="col-md-12 mt-4">
            <label class="form-label small @error('id_participacion_ce') text-danger @else text-muted @enderror">
                <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                Tipo de participación
            </label>
            <select id="id_participacion_ce" class="form-select select2" data-model="id_participacion_ce" wire:ignore>
                @foreach($tipo_asistencias as $key=>$value)
                <option value="{{ $key }}" @selected($id_participacion_ce==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_participacion_ce')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        <div class="col-md-12 mt-4">
            <label class="form-label small text-muted">
                <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                Institución
            </label>
            <input id="institucion_ce" type="text" class="form-control 
            @error('institucion_ce') is-invalid @enderror" wire:model="institucion_ce">
            @error('institucion_ce')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>

        <div class="col-md-12 mt-4">
            <label class="form-label small text-muted">
                <i class="fa fa-star text-danger" style="font-size:8px;"></i>
                Período (ejemplo: 2008-2010)
            </label>
            <input id="periodo_ce" type="text" class="form-control 
            @error('periodo_ce') is-invalid @enderror" wire:model="periodo_ce">
            @error('periodo_ce')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{route('dashboard')}}"
        class="btn btn-outline-secondary btn-md px-3 rounded-2">
            <i class="fa fa-arrow-left me-1"></i>
            Volver
        </a>
        <button 
            type="button" 
            class="btn btn-guardar btn-md px-4 rounded-2"
            wire:click="store_conocimiento_electoral"
            wire:loading.attr="disabled"
            wire:target="store_conocimiento_electoral">
            <span wire:loading.remove wire:target="store_conocimiento_electoral">
                <i class="fa fa-save me-1"></i>
                Guardar
            </span>
            <span wire:loading wire:target="store_conocimiento_electoral">
                <i class="fa fa-spinner fa-spin me-1"></i>
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

    <table class="table table-bordered table-striped" id="tablaExperienciaElectorales">
        <thead>
            <tr>
                <th>Conocimiento electoral</th>
                <th>Otro Conocimiento</th>
                <th>Tipo de participación</th>
                <th>Institución</th>
                <th>Período</th>         
                <th width="60">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datos as $item)
            <tr wire:key="experiencia-electoral-{{ $item['id'] }}">
                <td>{{ $item['conocimiento'] }}</td>
                <td>{{ $item['otro_ce'] }}</td>
                <td>{{ $item['participacion'] }}</td>
                <td>{{ $item['institucion_ce'] }}</td>
                <td>{{ $item['periodo_ce'] }}</td>
                <td>
                    <button
                        type="button"
                        class="btn btn-sm btn-warning"
                        wire:click="editarExperienciaElectoral({{ $item['id'] }})">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        wire:click="confirmarDeleteConocimientoElectoral({{ $item['id'] }})">
                        <i class="fa fa-trash"></i>
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
Livewire.on('confirmaBorrarConocimientoElectoral', (event) => {
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
            Livewire.dispatch('eliminarRegistroConocimientosElectoral',{
                id:id
            });
        }
    });
});
// ===============================
// MENSAJES SWEETALERT
// ===============================
Livewire.on('swalConocimientosElectorales',(data)=>{
    Swal.fire({
        icon:data[0].icon,
        title:data[0].title,
        text:data[0].text,
        confirmButtonText:'Aceptar'
    });
});

Livewire.on('actualizarSelectsConocimientos',()=>{
    setTimeout(()=>{
        $('#id_tipo_ce').val(@this.id_tipo_ce ?? '').trigger('change.select2')
        $('#id_participacion_ce').val(@this.id_participacion_ce ?? '').trigger('change.select2')
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
    if(!$('#tablaExperienciaElectorales').length){
        return;
    }
    if($.fn.DataTable.isDataTable('#tablaExperienciaElectorales')){
        $('#tablaExperienciaElectorales')
        .DataTable()
        .destroy();
    }
    $('#tablaExperienciaElectorales').DataTable({
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