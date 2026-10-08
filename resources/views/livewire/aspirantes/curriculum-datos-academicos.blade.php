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
        <div class="col-md-12 mb-2">
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
                    <small class="text-black d-block mt-1">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        <strong>Obligatorio:</strong> este módulo es requerido para continuar con su proceso como aspirante.
                        Si no cuenta con estudios, seleccione la opción <strong>"Sin estudios"</strong>.
                        Si registra información académica, se le solicitará comprobarla en el módulo de Documentos.
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <label class="form-label small @error('id_nivel_estudios') text-danger @else text-muted @enderror">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Nivel de estudios
            </label>
            <select id="id_nivel_estudios" class="form-select select2" data-model="id_nivel_estudios" wire:ignore>
                @foreach($nivelEstudiosLicenciaturas as $key=>$value)
                <option value="{{ $key }}" @selected($id_nivel_estudios==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_nivel_estudios')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @if($mostrar_carrera)
        <div class="col-md-12 mt-4">
            <label class="form-label small @error('id_carrera') text-danger @else text-muted @enderror">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Licenciatura
            </label>
            <select id="id_carrera" class="form-select select2" data-model="id_carrera" wire:ignore>
                @foreach($carreras as $key=>$value)
                <option value="{{ $key }}" @selected($id_carrera==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_carrera')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @endif
        @if($mostrar_otra_carrera)
        <div class="col-md-12 mt-4">
            <label class="form-label small text-muted">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Escriba el nombre de la licenciatura
            </label>
            <input id="otra_carrera" type="text" class="form-control 
            @error('otra_carrera') is-invalid @enderror" wire:model="otra_carrera">
            @error('otra_carrera')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @endif
        @if($mostrar_estatus_nivel_estudios)
        <div class="col-md-12 mt-4">
            <label class="form-label small @error('id_status_nivel_estudios') text-danger @else text-muted @enderror">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Estatus del nivel de estudios 
            </label>
            <select id="id_status_nivel_estudios" class="form-select select2" data-model="id_status_nivel_estudios" wire:ignore>
                @foreach($estatusNivelEstudiosLicenciaturas as $key=>$value)
                <option value="{{ $key }}" @selected($id_status_nivel_estudios==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_status_nivel_estudios')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @endif
        @if($mostrar_otros_estudios)
        <div class="col-md-12 mt-4">
              <label class="form-label small @error('id_otros_estudios') text-danger @else text-muted @enderror">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Estudios de posgrado 
            </label>
            <select id="id_otros_estudios" class="form-select select2" data-model="id_otros_estudios" wire:ignore>
                @foreach($estudios_posgrados as $key=>$value)
                <option value="{{ $key }}" @selected($id_otros_estudios==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_otros_estudios')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @endif
        @if($mostrar_posgrado)
        <div class="col-md-12 mt-4">
            <label class="form-label small text-muted">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Posgrado
            </label>
            <input id="posgrado" type="text" class="form-control 
            @error('posgrado') is-invalid @enderror" wire:model="posgrado">
            @error('posgrado')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @endif
        @if($mostrar_estatus_posgrado)
        <div class="col-md-12 mt-4">
            <label class="form-label small @error('id_status_otro_estudios') text-danger @else text-muted @enderror">
                <i class="fa-solid fa-star text-danger" style="font-size:8px;"></i>
                Estatus de los estudios de posgrado
            </label>
            <select id="id_status_otro_estudios" class="form-select select2" data-model="id_status_otro_estudios" wire:ignore>
                @foreach($estatusNivelEstudiosposgrados as $key=>$value)
                <option value="{{ $key }}" @selected($id_status_otro_estudios==$key)>
                    {{ $value }}
                </option>
                @endforeach
            </select>
            @error('id_status_otro_estudios')
            <small class="text-danger">
                {{ $message }}
            </small>
            @enderror
        </div>
        @endif
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
            wire:click="storeDatosAcademicos"
            wire:loading.attr="disabled"
            wire:target="storeDatosAcademicos">

            <span wire:loading.remove wire:target="storeDatosAcademicos">
                <i class="fa-solid fa-floppy-disk me-1"></i>
                Guardar
            </span>

            <span wire:loading wire:target="storeDatosAcademicos">
                <i class="fa-solid fa-spinner fa-spin me-1"></i>
                Guardando
            </span>
        </button>
    </div>
</div>
<script>
    document.addEventListener('livewire:init', () => {
        inicializarSelect2();
        Livewire.hook('morphed', () => {
            inicializarSelect2();
        });
        window.addEventListener('refresh-select2', () => {
            setTimeout(() => {
                inicializarSelect2();
            }, 100);
        });
        Livewire.on('swal', (data) => {
            Swal.fire({
                icon: data[0].icon,
                title: data[0].title,
                text: data[0].text,
                confirmButtonText: 'Aceptar'
            });
        });
    });
    function inicializarSelect2() {
        $('.select2').each(function() {
            let select = $(this);
            if (select.hasClass('select2-hidden-accessible')) {
                select.select2('destroy');
            }
            select.select2({
                width: '100%',
                allowClear: true
            });
            let valorActual = select.find('option:selected').val();
            if (valorActual) {
                select.val(valorActual)
                    .trigger('change.select2');
            }
            select.off('change')
            .on('change', function() {
                let modelo = $(this).data('model');
                let valor = $(this).val();
                let wireId = $(this)
                    .closest('[wire\\:id]')
                    .attr('wire:id');
                if(wireId && modelo){
                    Livewire.find(wireId)
                        .set(modelo, valor);
                }
            });
        });
    }
</script>
